<?php
namespace App\Controllers;
use App\Models\CustomerModel;
class Customer extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        //$getall['users'] = $this->staffModel->getAllStaff();
        $customer = $this->customerModel->getAllCustomer();
        $data['user'] = $customer;
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('customers', $data);
		$template.= view('common/footer');
		//$template.= view('page_scripts/staffjs');
        return $template;

        
    }
		public function view_cust($cust_Id = null) {
		$data = [];
		 if ($cust_Id) {
			$cust_val = $this->customerModel->findCustomerById($cust_Id);
		
			if (!$cust_val) {
				return redirect()->to('staff')->with('error', 'Staff member not found');
			}
			// $data['cust'] = $cust_val;
		$data['cust'] = (array) $cust_val;
		$template  = view('common/header');
		$template .= view('common/leftmenu');
		$template .= view('customer_view', $data);
		$template .= view('common/footer');
		return $template;
		}
		else{
			// Load views
			$template = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('customer_view');
			$template .= view('common/footer');
			//$template .= view('page_scripts/staffjs');
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
		// Validate email formats
			if (!filter_var($staffemail, FILTER_VALIDATE_EMAIL)) {
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Invalid primary email format.'
				]);
			}

			if (!filter_var($staffotemail, FILTER_VALIDATE_EMAIL)) {
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Invalid alternate email format.'
				]);
			}
			if (!ctype_digit($mobile)) {
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Phone number must contain only digits.'
				]);
			}
		if($staffname && $staffemail && $password && $mobile) {
			if (empty($us_id)) {
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
				$data = [
				'us_Name'          => $staffname,
				'us_Email'         => $staffemail,
				'us_Email2'        => $staffotemail,
				'us_Phone'		   => $mobile,
				'us_Status'		   => 1,
				'us_Role'		   => 2,
				'us_Password'      => md5($password),
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

	
}


