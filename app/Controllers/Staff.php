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
   public function createnew() {
		$us_id = $this->input->getPost('us_id');
		$staffname = $this->input->getPost('staffname');
		$staffemail = $this->input->getPost('staffemail');
		$staffotemail = $this->input->getPost('staffotemail');
		$mobile = $this->input->getPost('mobile');
		$password = $this->input->getPost('password');
		// Validate customer name
		if (!preg_match('/^[a-zA-Z0-9\s]+$/', $staffname)) {
			return $this->response->setJSON([
				'status' => 'error',
				'msg' => 'Please enter name correctly.'
			]);
		}
		// Validate email formats
			if (!filter_var($staffemail, FILTER_VALIDATE_EMAIL)) {
				return $this->response->setJSON([
					'status' => 'error',
					'msg' => 'Please enter a valid mail id.'
				]);
			}

			if (!ctype_digit($mobile) || strlen($mobile) !== 10) {
				return $this->response->setJSON([
					'status' => 'error',
					'msg' => 'Phone number must contain 10 digits.'
				]);
			}
			if($staffname && $staffemail && $password && $mobile) {
				if (empty($us_id)) {
					 $staffModel = new StaffModel();
						// Check if the email already exists
						$existingStaff = $staffModel->getStaffByEmail($staffemail);
						if ($existingStaff) {
							// Email exists, return an error message
							return $this->response->setJSON([
								'status' => 'error',
								'msg' => 'Email already exists. Please enter another.'
							]);
							
						}
					
						$data = [
							'us_Name'          => $staffname,
							'us_Email'         => $staffemail,
							'us_Email2'        => $staffotemail,
							'us_Phone'		   => $mobile,
							'us_Status'		   => 1,
							'us_Role'		   => 2,
							'us_Password'      => md5($password),
							'us_createdon'     => date("Y-m-d H:i:s"),
							'us_createdby'     => $this->session->get('zd_id'),
							'us_modifyby'      => $this->session->get('zd_id'),
							];
							$CreateStaff = $this->staffModel->createStaff($data);
							//echo json_encode(array("status" => 1, "msg" => "Created successfully."));
							echo json_encode(array(
								"status" => 1,
								"msg" => "Created successfully.",
								"redirect" => base_url('staff')
							));
					}
				
				else {
					$staffModel = new StaffModel();
					$staff = $staffModel->getStaffByid($us_id);
					$oldPassword = $staff->us_Password;
					$newPassword = $password;
					if ($password != $oldPassword) {
						$newPassword = md5($password); // If not same password, keep the old one
					}
					else{
						$newPassword = $oldPassword;
					}
					
							$data = [
						'us_Name'          => $staffname,
						'us_Email'         => $staffemail,
						'us_Email2'        => $staffotemail,
						'us_Phone'		   => $mobile,
						'us_Status'		   => 1,
						'us_Role'		   => 2,
						'us_Password'      =>  $newPassword,
						'us_createdby'     => $this->session->get('zd_uid'),
						'us_modifyby'	   => $this->session->get('zd_uid'),     
						];
						$modifyStaff = $this->staffModel->modifyStaff($us_id,$data);
						//echo json_encode(array("status" => 1, "msg" => "Updated successfully."));	
						echo json_encode(array(
							"status" => 1,
							"msg" => "Updated successfully.",
							"redirect" => base_url('staff')
						));
					
				}
			}
		else {
			return $this->response->setJSON([
				'status' => 'error',
				'message' => 'All fields are required.'
			]);
		}
		
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


