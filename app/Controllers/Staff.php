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
		$password = $this->input->getPost('password');
		$staffemail = $this->input->getPost('staffemail');
		if (!filter_var($staffemail, FILTER_VALIDATE_EMAIL)) {
			return $this->response->setJSON([
				'status' => 'error',
				'message' => 'Invalid email format'
			]);
		}
		if($staffname && $staffemail && $password) {
			if (empty($us_id)) {
				$data = [
				'us_Name'          => $staffname,
				'us_Email'         => $staffemail,
				'us_Email2'        => $staffotemail,
				'us_Status'		   => 1,
				'us_Role'		   => 2,
				'us_Password'      => md5($password),
				'us_createdon'     => date("Y-m-d H:i:s"),
				'us_createdby'     => $this->session->get('zd_id'),
				'us_modifyby'      => $this->session->get('zd_id'),
			];
				$CreateStaff = $this->staffModel->createStaff($data);
				echo json_encode(array("status" => 1, "msg" => "Created successfully."));
				
			} 
			else {
				$data = [
				'us_Name'          => $staffname,
				'us_Email'         => $staffemail,
				'us_Email2'        => $staffotemail,
				'us_Status'		   => 1,
				'us_Role'		   => 2,
				'us_Password'      => md5($password),
				'us_createdby'     => $this->session->get('zd_uid'),
				'us_modifyby'	   => $this->session->get('zd_uid'),     
			];				
				$modifyStaff = $this->staffModel->modifyStaff($us_id,$data);
				echo json_encode(array("status" => 1, "msg" => "Updated successfully."));	
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

	
}


