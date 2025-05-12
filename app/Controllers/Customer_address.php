<?php
namespace App\Controllers;
use App\Models\AddressModel;
class Customer_address extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->addressModel = new AddressModel();
    }

    public function location($cust_id)
    {
			
        $customer = $this->addressModel->getAllCustomer($cust_id);
        $data['user'] = $customer;
        $data['add_CustId'] = $cust_id;
        $template = view('common/header');
		$template.= view('common/leftmenu');
		$template.= view('customer_address', $data);
		$template.= view('common/footer');
		$template.= view('page_scripts/addressjs');
        return $template;

        
    }
	public function view_address($cust_id, $add_id = null)
	{

		if (!$this->session->get('zd_uid')) {
			return redirect()->to(base_url());
		}

		$data = [
			'add_CustId' => $cust_id,
			'add_id' => $add_id,
		];
		
		// If editing an address (i.e., $add_id is provided)
		
		if ($add_id) {
			
			$address = $this->addressModel->getCustomerByid($add_id);
			if (!$address) {
				return redirect()->to('customer_address')->with('error', 'Customer address not found');
			}
			$data['address'] = (array) $address;
			// Load views
			$template  = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('customer_address_add', $data);
			$template .= view('common/footer');
			$template .= view('page_scripts/addressjs');
			return $template;
		}
		else
		{
			
			$template  = view('common/header');
			$template .= view('common/leftmenu');
			$template .= view('customer_address_add',$data);
			$template .= view('common/footer');
			$template .= view('page_scripts/addressjs');
			return $template;
		}
	}
	/*************************************/
	 public function createnew() {
		$cust_id 	= 	$this->input->getPost('cust_id');
		$add_id 	= 	$this->input->getPost('add_id');
		$custname 	= 	$this->input->getPost('custname');
		$mobile 	= 	$this->input->getPost('mobile');
		$hname		=	$this->input->getPost('hname');
		$street		=	$this->input->getPost('street');
		$landmark	=	$this->input->getPost('landmark');
		$city		=	$this->input->getPost('city');
		$pincode	=	$this->input->getPost('pincode');
		$state		=	$this->input->getPost('state');
		
				$addressModel = new AddressModel();
				if($custname && $mobile && $hname && $street && $city && $pincode && $state){
					if (empty($add_id) && !empty($cust_id)){
						$data = [
						'add_Name'          	=> $custname,
						'add_BuldingNo'         => $hname,
						'add_Landmark'	    	=> $landmark,
						'add_Street'     		=> $street,
						'add_City'				=> $city,
						'add_State'				=> $state,
						'add_Pincode'			=> $pincode,
						'add_Phone'				=> $mobile,
						'add_CustId'			=> $cust_id,
						'add_Status'	   		=> 1,
						'add_createdon'    		=> date("Y-m-d H:i:s"),
						'add_createdby'    		=> $this->session->get('zd_uid'),
						'add_modifyby'     		=> $this->session->get('zd_uid'),
					];
						$CreateCust = $this->addressModel->createcust($data);
						//echo json_encode(array("status" => 1, "msg" => "Customer address Created successfully."));
						echo json_encode(array(
							"status" => 1,
							"msg" => "Customer Created successfully."
							
						));
					}
					else {
		
				
				$data = [
						'add_Id'				=> $add_id,
						'add_CustId'			=> $cust_id,
						'add_Name'          	=> $custname,
						'add_BuldingNo'         => $hname,
						'add_Landmark'	    	=> $landmark,
						'add_Street'     		=> $street,
						'add_City'				=> $city,
						'add_State'				=> $state,
						'add_Pincode'			=> $pincode,
						'add_Phone'				=> $mobile,
						'add_CustId'			=> $cust_id,
						'add_Status'	   		=> 1,
						'add_createdon'    		=> date("Y-m-d H:i:s"),
						'add_createdby'    		=> $this->session->get('zd_uid'),
						'add_modifyby'     		=> $this->session->get('zd_uid'),
					];
				$modifyaddress = $this->addressModel->modifyaddress($add_id,$data);
				//echo json_encode(array("status" => 1, "msg" => "Customer address details updated successfully."));	
				echo json_encode(array(
					"status" => 1,
					"msg" => "Customer address details updated successfully.",
					"redirect" => base_url('customer')
				));
			}
				}
				
			} 
		/***************************************/
		 public function deleteAddress($add_id) {
		if ($add_id) {
			$modified_by = $this->session->get('zd_uid');
			$add_status = $this->addressModel->deleteCustById(3, $add_id, $modified_by);

			if ($add_status) {
				echo json_encode([
					'success' => true,
					'msg' => 'Address deleted successfully.'
				]);
			} else {
				echo json_encode([
					'success' => false,
					'msg' => 'Failed to delete address.'
				]);
			}
		} else {
			echo json_encode([
				'success' => false,
				'msg' => 'Invalid request.'
			]);
		}
	}
		/***************************************/
	}
	


