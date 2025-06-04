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

    public function useAddress()
    {
        $zd_uid = session()->get('zd_uid');
        $addressId = $this->request->getPost('addressId');

        $addressModel = new AddressModel();
        $addressModel->setDefault($zd_uid, $addressId);

        return $this->response->setJSON(['success' => true]);
    }

    public function saveNewAddress()

	{
		print_r('Hello');
		exit;
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

			$defaultAddress = $model->getDefaultAddress($zd_uid);
			return $this->response->setJSON([
				'success' => true,
				'defaultAddress' => $defaultAddress
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
        $zd_uid = session()->get('zd_uid');

        if (empty($zd_uid)) {
            return redirect()->to(base_url());
        }

        $od_Id = $this->request->getPost('od_Id');

        if (empty($od_Id)) {
            return $this->response->setJSON([
                'status' => 0,
                'msg'    => 'Missing order ID.'
            ]);
        }

        $order = $orderModel->getOrdersById($od_Id);
        if (!$order) {
            return $this->response->setJSON([
                'status' => 0,
                'msg'    => 'Order not found.'
            ]);
        }

        $pr_Id   = $order->pr_Id;
        $cust_id = $order->cus_Id;
        $qty     = $order->od_Quantity;

        $product = $orderModel->getProductById($pr_Id);
        $productName   = $product->pr_Name ?? '';
        $pr_code       = $product->pr_Code ?? '';
        $grand_total   = $order->od_Grand_Total ?? 0;
        $custEmail     = '';

        $customer = $orderModel->getCustomerAddress($cust_id);

        if (!$customer) {
            return $this->response->setJSON([
                'status' => 0,
                'msg'    => 'Customer details not found.'
            ]);
        }

        $custName    = $customer->add_Name ?? '';
        $custPhone   = $customer->add_Phone ?? '';
        $custEmail   = $customer->add_Email ?? '';
        $custAddress = $customer->add_Address ?? '';

        $message = "🛒 *New Order Placed*\n"
            . "*Product:* $productName\n"
            . "*Code:* $pr_code\n"
            . "*Amount:* ₹$grand_total\n"
            . "*Customer:* $custName\n"
            . "*Address:* $custAddress\n"
            . "*Phone:* $custPhone\n";

        $email = \Config\Services::email();
        $email->setTo($custEmail);
        $email->setBCC('sandra@smartlounge.online');
        $email->setSubject('New Order Confirmation');
        $email->setMessage(nl2br($message));
        $email->send();

        return $this->response->setJSON([
            'status' => 1,
            'msg'    => 'Order confirmation sent successfully. Mail sent to your mail ID.',
            'od_Id'  => $od_Id
        ]);
    }
}
