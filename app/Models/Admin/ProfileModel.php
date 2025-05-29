<?php

namespace App\Models\Admin;  

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'us_Id';

    protected $allowedFields = ['us_Name', 'us_Email'];

    
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

    
    public function changePassword($us_Id, $hashedPassword)
    {
        return $this->updateProfile($us_Id, ['us_Password' => $hashedPassword]);
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
