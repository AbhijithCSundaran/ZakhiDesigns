<?php
namespace App\Controllers;
use App\Models\StaffModel;

class Staff extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->staffModel = new StaffModel();
    }

    public function index()
    {
        //$getall['users'] = $this->staffModel->getAllStaff();
        $staff = $this->staffModel->getAllStaff();
        $data['user'] = $staff;
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('staff', $data);
		$template.= view('common/footer');
		$template.= view('page_scripts/staffjs');
        return $template;

        
    }
	public function addStaff($us_id = null)
	{
		if (!$this->session->get('zd_uid')) 
		{
			return redirect()->to(base_url());
		}

		$data = [];
		 if ($us_id) {
			$staff_val = $this->staffModel->getStaffByid($us_id);
		
			if (!$staff_val) {
				return redirect()->to('staff')->with('error', 'Staff member not found');
			}
			// $data['staff'] = $staff_val;
			 $data['staff'] = (array) $staff_val;
			
			// Load views
			$template = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('staff_add', $data);
			$template .= view('common/footer');
			$template .= view('page_scripts/staffjs');
			return $template;
		}
		else
		{
			// Load views
			$template = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('staff_add');
			$template .= view('common/footer');
			$template .= view('page_scripts/staffjs');
			return $template;
		}
		
	}
	  public function createnew()
	{
		$us_id         = $this->input->getPost('us_id');
		$staffname     = $this->input->getPost('staffname');
		$staffemail    = $this->input->getPost('staffemail');
		$staffotemail  = $this->input->getPost('staffotemail');
		$mobile        = $this->input->getPost('mobile');
		$password      = $this->input->getPost('password');
		$oldpass	   = $this->input->getPost('old_password');
		$newPass   	   = $this->input->getPost('new_password');

		// Validate name
		if (!preg_match('/^[a-zA-Z ]+$/', $staffname)) {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Please enter name correctly.']);
		}

		// Validate emails
		if (!filter_var($staffemail, FILTER_VALIDATE_EMAIL)) {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Please enter a valid primary email.']);
		}
		// Validate mobile
		if (!empty($mobile) && (!ctype_digit($mobile) || strlen($mobile) !== 10)) {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Phone number must contain exactly 10 digits.']);
		}
		//validate password length
		
		if (!empty($password) && (strlen($password) < 6 || strlen($password) > 15)) {
			return $this->response->setJSON([
				'status' => 'error',
				'msg' => 'Password must be between 6 to 15 characters.'
			]);
		}
		if (!empty($newPass) && (strlen($newPass) < 6 || strlen($newPass) > 15)) {
			return $this->response->setJSON([
				'status' => 'error',
				'msg' => 'Password must be between 6 to 15 characters.'
			]);
		}
	/* 	   // Allow only letters, numbers, @ and _
		if (!preg_match('/^[a-zA-Z0-9@_]+$/', $password)) {
			return $this->response->setJSON([
				'status' => 'error',
				'msg' => 'Password can only contain letters, numbers, @, and _.'
			]);
		}
		   // Allow only letters, numbers, @ and _
		if (!preg_match('/^[a-zA-Z0-9@_]+$/', $newPass)) {
			return $this->response->setJSON([
				'status' => 'error',
				'msg' => 'Password can only contain letters, numbers, @, and _.'
			]);
		}
	 */
		$staffModel = new StaffModel();
		// INSERT
		if (empty($us_id)) {
			// Check if email already exists
			if ($staffModel->getStaffByEmail($staffemail)) {
				return $this->response->setJSON(['status' => 'error', 'msg' => 'Email already exists.']);
			}

			$data = [
				'us_Name'       => $staffname,
				'us_Email'      => $staffemail,
				'us_Email2'     => $staffotemail,
				'us_Phone'      => $mobile,
				'us_Status'     => 1,
				'us_Role'       => 2,
				'us_Password'   => md5($password),
				'us_createdon'  => date("Y-m-d H:i:s"),
				'us_createdby'  => $this->session->get('zd_id'),
				'us_modifyby'   => $this->session->get('zd_id'),
			];

			$staffModel->createStaff($data);
			return $this->response->setJSON(['status' => 1, 'msg' => 'Staff Created successfully.', 'redirect' => base_url('staff')]);
		}

		// UPDATE
		$existing = $staffModel->getStaffById($us_id);
		if(empty($oldpass)&& empty($newPass))
		{
			$newPassword	=	$existing->us_Password;
		}
		else{
		
			if (!empty($oldpass) && $existing->us_Password !== md5($oldpass)) {
				return $this->response->setJSON([
					'status' => 'error',
					'msg' => 'Password not matching with old password.'
				]);
			}
			else{
				
				if (empty($newPass) && md5($newPass) !== md5($oldpass)|| md5($newPass) === md5($oldpass)) {
				return $this->response->setJSON([
					'status' => 'error',
					'msg' => 'Please check your new password.'
				]);
				}
				else{
				$newPassword	=	md5($newPass);
				}
			}
		}
		if (!$existing) {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Staff not found.']);
		}

		// Check if email changed and already exists for another user
		if ($staffemail !== $existing->us_Email && $staffModel->emailExistsExcept($staffemail, $us_id)) {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Email already exists.']);
		}
		// Use old password if input is empty, otherwise hash new password
		$data = [
			'us_Name'      => $staffname,
			'us_Email'     => $staffemail,
			'us_Email2'    => $staffotemail,
			'us_Phone'     => $mobile,
			'us_Status'    => 1,
			'us_Role'      => 2,
			'us_Password'  => $newPassword,
			'us_modifyby'  => $this->session->get('zd_uid'),
		];

		$staffModel->modifyStaff($us_id, $data);
		return $this->response->setJSON(['status' => 1, 'msg' => 'Staff Updated successfully.', 'redirect' => base_url('staff')]);
	}
	 public function deleteStaff($us_id) {
		if ($us_id) {
			$modified_by = $this->session->get('zd_uid');
			$us_status = $this->staffModel->deleteStaffById(3, $us_id, $modified_by);

			if ($us_status) {
				echo json_encode([
					'success' => true,
					'msg' => 'Staff deleted successfully.'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'msg' => 'Failed to delete staff.'
				]);
			}
		} else {
			echo json_encode([
				'success' => false,
				'msg' => 'Invalid request.'
			]);
		}
	}
	public function updateStatus()
	{
	
		$us_Id = $this->request->getPost('us_Id');
        $newStatus = $this->request->getPost('us_Status');
        $staffModel = new StaffModel();
        $staff = $staffModel->getStaffByid($us_Id);
    
        if (!$staff) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Customer not found'
            ]);
        }
        $update = $staffModel->updateStaff($us_Id, ['us_Status' => $newStatus]);
        if ($update) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Status Updated Successfully!',
                'new_status' => $newStatus
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update status'
            ]);
        }
	}

	
}


