<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfileModel;

class Profile extends BaseController
{
	
	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->input = \Config\Services::request();
		// $this->ProfileModel = new ProfileModel();
	}

	public function index()
	{
		
		

		$template = view('Admin/common/header');
		$template .= view('Admin/common/leftmenu');
		$template .= view('Admin/profile');
		$template .= view('Admin/page_scripts/profilejs');
		$template .= view('Admin/common/footer');
		

		return $template;
	}

	public function update()
	{
		$adminId = $this->session->get('us_Id');
		$name = $this->input->getPost('name');
		$email = $this->input->getPost('us_Email');

		if (!preg_match('/^[a-zA-Z ]+$/', $name)) {
			$this->session->setFlashdata('error', 'Please enter name correctly.');
			return redirect()->to('admin/profile');
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->session->setFlashdata('error', 'Please enter a valid email address.');
			return redirect()->to('admin/profile');
		}

		$data = [
			'us_Name'  => $name,
			'us_Email' => $email,
		];

		$this->ProfileModel->update($adminId, $data);
		$this->session->setFlashdata('success', 'Profile updated successfully.');
		return redirect()->to('admin/profile');
	}

	public function change_password()
	{
		$adminId = $this->session->get('us_Id');
		$currentPassword = $this->input->getPost('current_password');
		$newPassword = $this->input->getPost('new_password');
		$confirmPassword = $this->input->getPost('confirm_password');

		$admin = $this->ProfileModel->find($adminId);

		if (!$admin || !password_verify($currentPassword, $admin['us_Password'])) {
			$this->session->setFlashdata('error', 'Current password is incorrect.');
			return redirect()->to('admin/profile');
		}

		if (strlen($newPassword) < 4 || strlen($newPassword) > 10) {
			$this->session->setFlashdata('error', 'Password must be between 4 to 10 characters.');
			return redirect()->to('admin/profile');
		}

		if ($newPassword !== $confirmPassword) {
			$this->session->setFlashdata('error', 'New password and confirm password do not match.');
			return redirect()->to('admin/profile');
		}

		$this->ProfileModel->update($adminId, [
			'us_Password' => password_hash($newPassword, PASSWORD_DEFAULT)
		]);

		$this->session->setFlashdata('success', 'Password changed successfully.');
		return redirect()->to('admin/profile');
	}

	public function ajaxList()
	{
		return $this->response->setJSON([
			'status' => 'success',
			'message' => 'AJAX list loaded'
		]);
	}
}
