<?php
namespace App\Controllers;
use App\Models\AdminModel;

class Admin extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->adminModel = new AdminModel();
    }

    public function index()
    {

		if (!$this->session->get('zd_uid')) 
		{
			return redirect()->to(base_url());
		}

		$data = [];
		$val =	$this->session->get('zd_uid');
			$staff_val = $this->adminModel->getdata($val);
			 $data['staff'] = (array) $staff_val;
			
			// Load views
			$template = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('admin_update', $data);
			$template .= view('common/footer');
			$template .= view('page_scripts/adminjs');
			return $template;
    }
   public function createnew() {
		$us_id = $this->input->getPost('us_id');
		$staffname = $this->input->getPost('staffname');
		$staffemail = $this->input->getPost('staffemail');
		$staffotemail = $this->input->getPost('staffotemail');
		$mobile = $this->input->getPost('mobile');
		$password = $this->input->getPost('password');

		$adminModel = new AdminModel();
		$staff = $adminModel->getStaffByid($us_id);
		$oldPassword = $staff->us_Password;
		$newPassword = $password;
		if ($password != $oldPassword) {
			$newPassword = md5($password); // If not same password, keep the old one
		}
		// Validate email formats
			if (!filter_var($staffemail, FILTER_VALIDATE_EMAIL)) {
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Invalid primary email format.'
				]);
			}
			if (!ctype_digit($mobile) || strlen($mobile) !== 10) {
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Phone number must contain only 10 digits.'
				]);
			}
		if($staffname && $staffemail && $password && $mobile) {

				$data = [
				'us_Name'          => $staffname,
				'us_Email'         => $staffemail,
				'us_Email2'        => $staffotemail,
				'us_Phone'		   => $mobile,
				'us_Password'	   => $newPassword,
				'us_Status'		   => 1,
				'us_Role'		   => 1,
				'us_createdby'     => $this->session->get('zd_uid'),
				'us_modifyby'	   => $this->session->get('zd_uid'),     
			];	
				$modifyStaff = $this->adminModel->modifyAdmin($us_id,$data);
				//echo json_encode(array("status" => 1, "msg" => "Updated successfully."));	
				echo json_encode(array(
					"status" => 1,
					"msg" => "Updated successfully.",
				));
			}
		else {
			return $this->response->setJSON([
				'status' => 'error',
				'message' => 'All fields are required.'
			]);
		}
		
	}
}


