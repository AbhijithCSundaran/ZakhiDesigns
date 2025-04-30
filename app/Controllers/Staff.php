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
	public function addStaff()
	{
		$template = view('common/header');
		$template.= view('common/leftmenu');
		$template.=	view('staff_add');
		$template.=	view('common/footer');
		$template.= view('page_scripts/staffjs');
		return $template;
	}
   public function createnew() {
		$staffname = $this->input->getPost('staffname');
		$staffemail = $this->input->getPost('staffemail');
		$staffotemail = $this->input->getPost('staffotemail');
		$password = $this->input->getPost('password');
		$us_id = $this->input->getPost('us_id');
		
		if($staffname && $staffemail && $password) {
			
			$data = [
				'us_Name'          => $staffname,
				'us_Email'         => $staffemail,
				'us_Email2'        => $staffotemail,
				'us_Status'		   => 1,
				'us_Role'		   => 2,
				'us_Password'      => md5($password),
				'us_createdon'    => date("Y-m-d H:i:s"),
				'us_createdby'    => $this->session->get('zd_id'),
				'us_modifyon'   => $this->session->get('zd_id'),
			];
			if ($us_id!=0) {
				
				$modifyStaff = $this->StaffModel->modifyStaff($us_id, $data);
				echo json_encode(array("status" => 1, "respmsg" => "Updated successfully."));
			} else {
				$CreateStaff = $this->staffModel->createStaff($data);
				echo json_encode(array("status" => 1, "respmsg" => "Created successfully."));
			}
		}
		else {
			return $this->response->setJSON([
				'status' => 'error',
				'message' => 'All fields are required.'
			]);
		}
		
	}
}


