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
		$template.= view('page_scripts/customerjs');
        return $template;

        
    }
		public function view_cust($cust_Id = null) {
		$data = [];
		 if ($cust_Id) {
			$cust_val = $this->customerModel->findCustomerById($cust_Id);
		
			if (!$cust_val) {
				return redirect()->to('customer')->with('error', 'Staff member not found');
			}
			// $data['cust'] = $cust_val;
		$data['cust'] = (array) $cust_val;
		$template  = view('common/header');
		$template .= view('common/leftmenu');
		$template .= view('customer_view', $data);
		$template .= view('common/footer');
		$template.= view('page_scripts/customerjs');
		return $template;
		}
		else{
			// Load views
			$template = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('customer_view');
			$template .= view('common/footer');
			$template .= view('page_scripts/customerjs');
			return $template;
			
		}
	}
    public function createnew() {
		$cust_id = $this->input->getPost('cust_id');
		$custname = $this->input->getPost('custname');
		$custemail = $this->input->getPost('custemail');
		$mobile = $this->input->getPost('mobile');
		$password = $this->input->getPost('password');
		echo $status = $this->input->getPost('custstatus');
		//$status =	$this->input->getPost('custstatus');
	
		// Validate email formats
			if (!filter_var($custemail, FILTER_VALIDATE_EMAIL)) {
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Invalid primary email format.'
				]);
			}
			if (!ctype_digit($mobile)) {
				return $this->response->setJSON([
					'status' => 'error',
					'message' => 'Phone number must contain only digits.'
				]);
			}
		
		if($custname && $custemail && $password && $mobile) {
			if (empty($cust_id)) {
				$data = [
				'cust_Name'          => $custname,
				'cust_Email'         => $custemail,
				'cust_Phone'	     => $mobile,
				'cust_Password'      => md5($password),
				'cust_Status'	   	 => $status,
				'cust_createdon'     => date("Y-m-d H:i:s"),
				'cust_createdby'     => $this->session->get('zd_id'),
				'cust_modifyby'      => $this->session->get('zd_id'),
			];
				$CreateCust = $this->customerModel->createcust($data);
				//echo json_encode(array("status" => 1, "msg" => "Created successfully."));
				echo json_encode(array(
					"status" => 1,
					"msg" => "Created successfully.",
					"redirect" => base_url('customer')
				));
				
			} 
			else {
				$data = [
				'cust_Name'          => $custname,
				'cust_Email'         => $custemail,
				'cust_Phone'	     => $mobile,
				'cust_Status'	     => $status,
				'cust_createdon'     => date("Y-m-d H:i:s"),
				'cust_createdby'     => $this->session->get('zd_id'),
				'cust_modifyby'      => $this->session->get('zd_id'),  
			];				
				$modifycust = $this->customerModel->modifycust($cust_id,$data);
				//echo json_encode(array("status" => 1, "msg" => "Updated successfully."));	
				echo json_encode(array(
					"status" => 1,
					"msg" => "Updated successfully.",
					"redirect" => base_url('customer')
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
	 public function deleteCust($cust_id) {
		if ($cust_id) {
			$modified_by = $this->session->get('zd_uid');
			$us_status = $this->customerModel->deleteCustById(3, $cust_id, $modified_by);

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
		//$id = $this->request->getPost('id');
		$cust_id = $this->request->getPost('cust_id');
		$status = $this->request->getPost('status');
		if (!$cust_id) {
			return $this->response->setJSON(['success' => false, 'msg' => 'Invalid ID']);
		}

		$this->customerModel->update($id, ['cust_Status' => $status]);
		return $this->response->setJSON(['success' => true, 'msg' => 'Status updated']);
	}
	
}


