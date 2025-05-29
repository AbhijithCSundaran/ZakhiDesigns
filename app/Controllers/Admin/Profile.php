<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\ProfileModel;

class Profile extends BaseController
{
	protected $ProfileModel;
	
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->input = \Config\Services::request();
		$this->ProfileModel = new \App\Models\Admin\ProfileModel();

		
	}

	public function index()
{
    if (!session()->get('zd_uid')) {
        return redirect()->to(base_url('/admin'));
    }
	
    $template = view('Admin/common/header');
    $template .= view('Admin/common/leftmenu');
    $template .= view('Admin/admin_update');
    $template .= view('Admin/common/footer');
    $template .= view('Admin/page_scripts/profilejs');
  
  return $template;
}

   public function edit_admin()
   {
	   $us_Id = $this->session->zd_uid;
     $admin = $this->ProfileModel->getProfileById($us_Id); 
	

    $data['user'] = (array) $admin; 

    $template = view('Admin/common/header');
    $template .= view('Admin/common/leftmenu');
    $template .= view('Admin/profile', $data);
    $template .= view('Admin/common/footer');
    $template .= view('Admin/page_scripts/profilejs');

    return $template;
}
public function update()
{
    $us_Id = $this->session->zd_uid;
    $data = [
        'us_Name' => $this->request->getPost('us_Name'),
        'us_Email' => $this->request->getPost('us_Email'),
    ];

    $model = new \App\Models\Admin\ProfileModel();

    if ($model->updateProfile($us_Id, $data)) {
        session()->setFlashdata('success', 'Profile updated successfully.');
    } else {
        session()->setFlashdata('error', 'Failed to update profile.');
    }

    return redirect()->to('admin/profile');
}
public function change_password()
{
    $us_Id = $this->session->zd_uid;
    $current = $this->request->getPost('current_password');
    $new = $this->request->getPost('new_password');
    $confirm = $this->request->getPost('confirm_password');

    $model = new \App\Models\Admin\ProfileModel();

    if (!$model->checkCurrentPassword($us_Id, $current)) {
        session()->setFlashdata('error', 'Current password is incorrect.');
    } elseif ($new !== $confirm) {
        session()->setFlashdata('error', 'New passwords do not match.');
    } else {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        if ($model->changePassword($us_Id, $hashed)) {
            session()->setFlashdata('success', 'Password changed successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to change password.');
        }
    }

    return redirect()->to('admin/profile');
}



}
