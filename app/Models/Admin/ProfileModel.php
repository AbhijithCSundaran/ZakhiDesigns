<?php

namespace App\Models\Admin;  

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'us_Id';

   protected $allowedFields = ['us_Name', 'us_Email', 'us_Password'];

    
    public function getProfileById($us_Id)
    {
        return $this->asArray()->where('us_Id', $us_Id)->first();
    }

    public function updateProfile($us_Id, $data)
    {
        return $this->where('us_Id', $us_Id)->set($data)->update();
    }

   
    public function checkCurrentPassword($us_Id, $plainPassword)
    {
        $user = $this->getProfileById($us_Id);
        if ($user && password_verify($plainPassword, $user['us_Password'])) {
            return true;
        }
        return false;
    }

    
  public function change_password()
{
    $session = session();
    $user_id = $session->get('zd_uid');

    $current_password = $this->request->getPost('current_password');
    $new_password = $this->request->getPost('new_password');
    $confirm_password = $this->request->getPost('confirm_password');

    $adminModel = new \App\Models\Admin\ProfileModel();
    $admin = $adminModel->getProfileById($user_id); 

    if (!$admin || !password_verify($current_password, $admin['us_Password'])) {
        $session->setFlashdata('error', 'Current password is incorrect.');
        return redirect()->to('admin/profile');
    }

    if ($new_password !== $confirm_password) {
        $session->setFlashdata('error', 'New password and confirm password do not match.');
        return redirect()->to('admin/profile');
    }

    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    $adminModel->changePassword($user_id, $hashed);

    $session->setFlashdata('success', 'Your password has been changed successfully.');
    return redirect()->to('admin/profile');
}


   
    public function emailExistsExcept($Name, $email, $Password, $excludeId)
    {
        $builder = $this->builder();
        $builder->where('us_Name', $Name);
        $builder->where('us_Email', $email);
        
        $builder->where('us_Id !=', $excludeId);
        $query = $builder->get();
        return $query->getNumRows() > 0;
    }
}
