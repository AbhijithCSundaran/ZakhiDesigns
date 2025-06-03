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
        $template .= view('order_now', $data); // FIXED: was `data` instead of `$data`
        $template .= view('common/footer'); 
        $template .= view('pagescripts/OrderNowjs');

        return $template;
    }

    public function getAddress($id)
{
    $model = new AddressModel();
    $address = $model->find($id);  // CI built-in method to find row by primary key
    return $this->response->setJSON($address);
}


public function saveNewAddress()
{
    $session = session();
    $zd_uid = $session->get('zd_uid');  // Or however you get user ID

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
    ];

    $addressModel = new \App\Models\AddressModel();
    $newAddress = $addressModel->insertAndSetDefault($zd_uid, $data);

    if ($newAddress) {
        return $this->response->setJSON([
            'status' => 'success',
            'address' => $newAddress,
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'msg' => 'Failed to save new address.',
        ]);
    }
}


    public function saveAddress()
    {
        $model = new AddressModel();
        $data = $this->request->getPost();
        $data['user_id'] = session()->get('zd_uid'); // FIXED: match to `zd_uid` not `user_id`

        if (!empty($data['add_Default'])) {
            // Reset previous default addresses
            $model->where('user_id', $data['user_id'])->set(['add_Default' => 0])->update();
        }

        $model->save($data);
        $id = $model->getInsertID();
        $address = $model->find($id);

        return $this->response->setJSON($address);
    }
	public function orderproduct($od_Id)
{
    $zd_uid = session()->get('zd_uid');

    if (empty($zd_uid)) {
        return redirect()->to(base_url());
    }

    $orderModel = new OrderNowModel();
    $addressModel = new AddressModel(); // Load address model

    $orders = $orderModel->getOrdersById($od_Id);

    if (empty($orders)) {
        return redirect()->to(base_url())->with('error', 'Order not found');
    }

    $pr_Id = $orders->pr_Id;
    $cus_Id = $orders->cus_Id;

    $data['product'] = $orderModel->getProductById($pr_Id);
    $data['details'] = $orderModel->getProductWithAddress($cus_Id, $pr_Id);

    // ✅ Add this line to pass all addresses (fix for undefined $addresses)
    $data['addresses'] = $addressModel->getAllAddresses($zd_uid);

    return view('common/header')
        . view('order_now', $data)
        . view('common/footer')
        . view('pagescripts/OrderNowjs');
}


    /* public function orderproduct($od_Id)
    {
        $zd_uid = session()->get('zd_uid');

        if (empty($zd_uid)) {
            return redirect()->to(base_url());
        }

        $orderModel = new OrderNowModel();

        $orders = $orderModel->getOrdersById($od_Id);

        if (empty($orders)) {
            return redirect()->to(base_url())->with('error', 'Order not found');
        }

        $pr_Id = $orders->pr_Id;
        $cus_Id = $orders->cus_Id;

        $data['product'] = $orderModel->getProductById($pr_Id);
        $data['details'] = $orderModel->getProductWithAddress($cus_Id, $pr_Id);

        return view('common/header')
            . view('order_now', $data)
            . view('common/footer')
            . view('pagescripts/OrderNowjs');
    }
 */
    public function submit()
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
        $selling_price = $order->od_Selling_Price ?? 0;
        $grand_total   = $order->od_Grand_Total ?? 0;

        $customer = $orderModel->getCustomerAddress($cust_id);
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
        $email->setBCC('sandra@smartlounge.online'); // You can make this configurable
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
