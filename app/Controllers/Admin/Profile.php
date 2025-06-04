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
    if (!session()->get('ad_uid')) {
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
	   $us_Id = $this->session->ad_uid;
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
    $us_Id = $this->session->ad_uid;
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

    
    $us_Id = $this->session->ad_uid;
    $current = $this->request->getPost('current_password');
    $new = $this->request->getPost('new_password');
    $confirm = $this->request->getPost('confirm_password');

    $session = session();
    $model = new \App\Models\Admin\ProfileModel();

    $admin_id = $session->get('admin_id');
    $current_password = $this->request->getPost('current_password');
    $new_password = $this->request->getPost('new_password');
    $confirm_password = $this->request->getPost('confirm_password');

    $admin = $model->where('id', $admin_id)->first();

    if (!$admin || !password_verify($current_password, $admin['password'])) {
        return redirect()->back()->with('error', 'Current password is incorrect');
    }

    if ($new_password !== $confirm_password) {
        return redirect()->back()->with('error', 'New password and confirmation do not match');
    }

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $model->update($admin_id, ['password' => $hashed_password]);

    return redirect()->back()->with('success', 'Your password has been changed successfully.');
}


}
