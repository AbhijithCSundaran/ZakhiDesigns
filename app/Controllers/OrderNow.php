<?php 
namespace App\Controllers;

use App\Models\OrderNowModel;
use App\Models\AddressModel;
use CodeIgniter\Controller;

class OrderNow extends Controller
{
    public function index()
    {
        if (!session()->get('zd_uid')) {
            return redirect()->to(base_url());
        }

        $zd_uid = session()->get('zd_uid');
        $model = new AddressModel();

        $data['details'] = $model->getDefaultAddress($zd_uid);
        $data['addresses'] = $model->getAllAddresses($zd_uid);
        $template = view('common/header');
        $template .= view('order_now', $data); 
        $template .= view('common/footer'); 
        $template .= view('pagescripts/OrderNowjs');

        return $template;
    }

    public function getAddress($id)
    {
		$model = new AddressModel();
		$address = $model->findAddress($id);
		if (!$address) {
			return $this->response->setStatusCode(404)->setJSON(['error' => 'Address not found']);
		}
		return $this->response->setJSON($address);
	}

    public function saveNewAddress()
	{
		$od_Id = $this->request->getPost('od_Id');
		$zd_uid = session()->get('zd_uid');

		$setAsDefault = $this->request->getPost('setAsDefault');

		$model = new AddressModel();

		if ($setAsDefault) {
			$model->setDefault($zd_uid, 0);
		}
		$data = [
			'add_Name'       => $this->request->getPost('newName'),
			'add_Email'      => $this->request->getPost('newEmail'),
			'add_Phone'      => $this->request->getPost('newPhone'),
			'add_BuldingNo'  => $this->request->getPost('newBuilding'),
			'add_Street'     => $this->request->getPost('newStreet'),
			'add_Landmark'   => $this->request->getPost('newLandmark'),
			'add_City'       => $this->request->getPost('newCity'),
			'add_State'      => $this->request->getPost('newState'),
			'add_Pincode'    => $this->request->getPost('newPincode'),
			'add_CustId'     => $zd_uid,
			'add_createdby'  => $zd_uid,
			'add_createdon'  => date("Y-m-d H:i:s"),
			'add_Default'    => $setAsDefault ? 1 : 0,
		];

			$model->insert($data);
			$insertId = $model->getInsertID();

			if ($setAsDefault) {

				$model->setDefault($zd_uid, $insertId);
			}

			$details = $model->findAddress($insertId);
			return $this->response->setJSON([
				'success' => true,
				'details' => $details
			]);
	}

    public function orderproduct($od_Id)
    {
        $zd_uid = session()->get('zd_uid');

        if (empty($zd_uid)) {
            return redirect()->to(base_url());
        }

        $orderModel = new OrderNowModel();
        $addressModel = new AddressModel();

        $orders = $orderModel->getOrdersById($od_Id);

        if (empty($orders)) {
            return redirect()->to(base_url())->with('error', 'Order not found');
        }

        $pr_Id = $orders->pr_Id;
        $cus_Id = $orders->cus_Id;

        $data = [
            'product'   => $orderModel->getProductById($pr_Id),
            'details'   => $orderModel->getProductWithAddress($cus_Id, $pr_Id),
            'addresses' => $addressModel->getAllAddresses($zd_uid),
        ];

        return view('common/header')
            . view('order_now', $data)
            . view('common/footer')
            . view('pagescripts/OrderNowjs');
    }

    public function submitfrm()
{
    $orderModel = new OrderNowModel();
    $addressModel = new AddressModel();
    $zd_uid = session()->get('zd_uid');
    $od_Id = $this->request->getPost('od_Id');
    $add_Id = $this->request->getPost('add_Id');

    if (empty($zd_uid) || empty($od_Id)) {
        return $this->response->setJSON(['status' => 0, 'msg' => 'Unauthorized or missing data.']);
    }

    $order = $orderModel->getOrdersById($od_Id);
    if (!$order) {
        return $this->response->setJSON(['status' => 0, 'msg' => 'Order not found.']);
    }

    $orderModel->updateOrderStatus($od_Id, [
        'od_Status'     => 1,
        'od_createdby'  => $zd_uid,
        'od_createdon'  => date('Y-m-d H:i:s'),
        'add_Id'        => $add_Id
    ]);
    $product = $orderModel->getProductById($order->pr_Id);
    $customer = $addressModel->findAddress($order->add_Id);
    if (!$customer) {
        return $this->response->setJSON(['status' => 0, 'msg' => 'Customer address not found.']);
    }
		$addressDetails = implode(', ', array_filter([
        $customer->add_BuldingNo ?? '',
        $customer->add_Street ?? '',
        $customer->add_Landmark ?? '',
        $customer->add_City ?? '',
        $customer->add_State ?? '',
        $customer->add_Pincode ?? ''
    ]));

    $message = "
        <h3>🛒 Order Confirmation</h3>
        <table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse;'>
            <tr><th>Order ID</th><td>{$od_Id}</td></tr>
            <tr><th>Product</th><td>{$product->pr_Name}</td></tr>
            <tr><th>Product Code</th><td>{$product->pr_Code}</td></tr>
            <tr><th>Quantity</th><td>{$order->od_Quantity}</td></tr>
            <tr><th>Total Amount</th><td>₹{$order->od_Grand_Total}</td></tr>
            <tr><th>Customer</th><td>{$customer['add_Name']}</td></tr>
            <tr><th>Email</th><td>{$customer['add_Email']}</td></tr>
            <tr><th>Phone</th><td>{$customer['add_Phone']}</td></tr>
            <tr><th>Delivery Address</th><td>{$addressDetails}</td></tr>
        </table>
    ";
    $email = \Config\Services::email();
    $email->setTo($customer['add_Email']);
    $email->setBCC('sandra@smartlounge.online');
    $email->setSubject('New Order Confirmation');
    $email->setMessage($message);
    $email->setMailType('html');

    $email->send();

    return $this->response->setJSON([
        'status' => 1,
        'msg'    => 'Order confirmed successfully. Email sent.',
        'od_Id'  => $od_Id
    ]);
}


}
