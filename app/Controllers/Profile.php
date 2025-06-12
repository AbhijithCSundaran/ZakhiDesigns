<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Models\AddressProfileModel;
use App\Models\OrderModel;
use App\Models\ProfileModel;
use App\Models\ProductDisplayModel;

class Profile extends BaseController 
{
	protected $productdisplayModel;
    protected $categories;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
    }

  public function index() 
{
    $userId = session()->get('zd_uid');

    // If not logged in and JS is bypassed
    if (!$userId) {
        if ($this->request->isAJAX()) {
            return view('weblogin'); // For modal
        } else {
            return redirect()->to(base_url());
        }
    }

    $this->productdisplayModel = new ProductDisplayModel();
    $this->categories = $this->productdisplayModel->getAllCategoriesAndSub();

    $data['categories'] = $this->categories;
    $data['title'] = 'Profile';

    $data['product'] = $this->productdisplayModel->getAllProducts();

    $userModel = new UserModel();
    $addressModel = new AddressProfileModel();
    $orderModel = new OrderModel();

    $user = $userModel->find($userId);

    // MERGE instead of overwrite
    $data = array_merge($data, [
        'user' => $user,
        'addresses' => $addressModel->getUserAddresses($userId),
        'orders' => $orderModel->getOrdersByUser($userId),
    ]);

    $template  = view('common/header', $data);
    $template .= view('profile');
    $template .= view('common/footer');
    $template .= view('pagescripts/profilejs');

    return $template;
}

	 public function editProfile()
    {
        $profileModel = new ProfileModel();

        $id = session()->get('zd_uid');
        $data = [
            'cust_Name'  => $this->request->getPost('name'),
            'cust_Email' => $this->request->getPost('email'),
            'cust_Phone' => $this->request->getPost('phone'),
        ];
        $updatedUser = $profileModel->updateUserProfile($id, $data);

        if ($updatedUser) {
            return $this->response->setJSON([
                'status' => 'success',
                'msg' => 'Profile updated successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'msg' => 'Failed to update profile.'
            ]);
        }
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
        return $this->response->setJSON(['status' => 'success']);
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
	
public function changePassword()
{
    $custId = session()->get('zd_uid');

    $oldPassword = $this->request->getPost('oldPassword');
    $newPassword = $this->request->getPost('newPassword');
    $confirmPassword = $this->request->getPost('confirmPassword');

    // Validation: check empty fields
    if (empty($oldPassword)) {
        return $this->response->setJSON(['status' => 0, 'msg' => 'Please enter the old password.']);
    }
    if (empty($newPassword)) {
        return $this->response->setJSON(['status' => 0, 'msg' => 'Please enter a new password.']);
    }
    if (empty($confirmPassword)) {
        return $this->response->setJSON(['status' => 0, 'msg' => 'Please confirm your new password.']);
    }

    // Check new password matches confirm password
    if ($newPassword !== $confirmPassword) {
        return $this->response->setJSON(['status' => 0, 'msg' => 'New password and confirm password do not match.']);
    }

    // Call model to change password
    $profileModel = new ProfileModel();
    $result = $profileModel->changePassword($custId, $oldPassword, $newPassword);

    return $this->response->setJSON($result);
}


}
