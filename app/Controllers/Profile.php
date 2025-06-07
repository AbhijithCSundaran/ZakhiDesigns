<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\AddressProfileModel;
use App\Models\OrderModel;

class Profile extends BaseController 
{
   public function index() 
    {
        $userId = session()->get('zd_uid');

        $userModel = new UserModel();
        $addressModel = new AddressProfileModel();
        $orderModel = new OrderModel();

        $user = $userModel->find($userId);

        $data = [
            'user' => $user,
            'addresses' => $addressModel->getUserAddresses($userId),
            'orders' => $orderModel->getOrdersByUser($userId),
        ];

    $template  = view('common/header');
    $template .= view('profile', $data);
    $template .= view('common/footer');
    $template .= view('pagescripts/profilejs');
    return $template;
    }
	public function setDefaultAddress()
	{
		$userId = session()->get('zd_uid');
		$add_Id = $this->request->getPost('add_Id');

		$addressModel = new AddressProfileModel();

		if ($addressModel->setAsDefault($userId, $add_Id)) {
			return $this->response->setJSON(['status' => 'success']);
		} else {
			return $this->response->setJSON(['status' => 'error']);
		}
	}

	
    public function update() {
        $userModel = new UserModel();
        $userModel->updateProfile(session()->get('zd_uid'), $this->request->getPost());
        return $this->response->setJSON(['status' => 'success']);
    }

    public function addAddress() {
        $addressModel = new AddressProfileModel();
        $addressModel->addAddress(session()->get('zd_uid'), $this->request->getPost());
        return $this->response->setJSON(['status' => 'added']);
    }
	public function editAddress() {
		$addressModel = new AddressProfileModel();
		$success = $addressModel->updateAddress($this->request->getPost());

		if ($success) {
			return $this->response->setJSON(['status' => 'success']);
		} else {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Failed to update address.']);
		}
	}
    public function deleteAddress() 
	{
		$add_Id = $this->request->getPost('add_Id');
		$modified_by = session()->get('zd_uid');
		
		$addressModel = new AddressProfileModel();
		$addressModel->deleteAddress(3, $add_Id, $modified_by);

		return $this->response->setJSON(['status' => 'success']);
	}

	public function getAddress()
	{
		$addId = $this->request->getPost('add_Id');
		$userId = session()->get('zd_uid');

		$addressModel = new AddressProfileModel();
		$address = $addressModel->where(['add_Id' => $addId, 'add_CustId' => $userId])->first();

		if ($address) {
			return $this->response->setJSON(['status' => 'success', 'data' => $address]);
		} else {
			return $this->response->setJSON(['status' => 'error', 'msg' => 'Address not found.']);
		}
	}

}
