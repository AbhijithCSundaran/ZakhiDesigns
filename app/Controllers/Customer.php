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
	    $password =$this->input->getPost('password');
		 if (!preg_match('/^[a-zA-Z ]+$/', $custname)) {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Please enter name correctly.']);
		}

		// Validate email formats
			if (!filter_var($custemail, FILTER_VALIDATE_EMAIL)) {
				return $this->response->setJSON([
					'status' => 'error',
					'msg' => 'Invalid email format.'
				]);
			}
			// Validate mobile
			if (!ctype_digit($mobile) || strlen($mobile) !== 10) {
				return $this->response->setJSON(['status' => 'error', 'msg' => 'Phone number must contain exactly 10 digits.']);
			}
			//validate password length
			
			if (!empty($password) && (strlen($password) < 6 || strlen($password) > 15)) {
				return $this->response->setJSON([
					'status' => 'error',
					'msg' => 'Password must be between 6 to 15 characters.'
				]);
			}
/* 				   // Allow only letters, numbers, @ and _
			if (!preg_match('/^[a-zA-Z0-9@_]+$/', $password)) {
				return $this->response->setJSON([
					'status' => 'error',
					'msg' => 'Password can only contain letters, numbers, @, and _.'
				]);
			} */
			$customerModel = new CustomerModel();
			if($custname && $custemail && $mobile) {
			if (empty($cust_id)) {
				// INSERT
			// Check if email already exists
				if ($customerModel->getCustomerByEmail($custemail)) {
					return $this->response->setJSON(['status' => 'error', 'msg' => 'Email already exists.']);
				}
				$data = [
				'cust_Name'          => $custname,
				'cust_Email'         => $custemail,
				'cust_Phone'	     => $mobile,
				'cust_Password'      => md5($password),
				'cust_Status'	   	 => 1,
				'cust_createdon'     => date("Y-m-d H:i:s"),
				'cust_createdby'     => $this->session->get('zd_uid'),
				'cust_modifyby'      => $this->session->get('zd_uid'),
			];
				$CreateCust = $this->customerModel->createcust($data);
				//echo json_encode(array("status" => 1, "msg" => "Customer Created successfully."));
				echo json_encode(array(
					"status" => 1,
					"msg" => "Customer Created successfully.",
					"redirect" => base_url('customer')
				));
				
			} 
			else {
				 // UPDATE
				$existing = $customerModel->getCustomerById($cust_id);
					// Check if email changed and already exists for another user
				if ($custemail !== $existing->cust_Email && $customerModel->emailExistsExcept($custemail, $cust_id)) {
					return $this->response->setJSON(['status' => 'error', 'msg' => 'Email already exists.']);
				}
				// Compare hashed passwords (check if the passwords match)
				$data = [
				'cust_Name'          => $custname,
				'cust_Email'         => $custemail,
				'cust_Phone'	     => $mobile,
				'cust_createdon'     => date("Y-m-d H:i:s"),
				'cust_createdby'     => $this->session->get('zd_uid'),
				'cust_modifyby'      => $this->session->get('zd_uid'),  
			];	
					
				$modifycust = $this->customerModel->modifycust($cust_id,$data);
				//echo json_encode(array("status" => 1, "msg" => "Customer details updated successfully."));	
				echo json_encode(array(
					"status" => 1,
					"msg" => "Customer details updated successfully.",
					"redirect" => base_url('customer')
				));
			}
		}
		else {
			return $this->response->setJSON([
				'status' => 'error',
				'msg' => 'All mandatory fields are required.'
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
	
		$custId = $this->request->getPost('cust_Id');
        $newStatus = $this->request->getPost('cust_Status');
    
        $customerModel = new CustomerModel();
        $customer = $customerModel->getCustomerByid($custId);
    
        if (!$customer) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Customer not found'
            ]);
        }
        $update = $customerModel->updateCustomer($custId, ['cust_Status' => $newStatus]);
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


