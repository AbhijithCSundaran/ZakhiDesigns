<?php 
namespace App\Controllers;

use App\Models\OrderNowModel;
use App\Models\AddressModel;
use App\Models\ProductDisplayModel;
use CodeIgniter\Controller;

class OrderNow extends Controller
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
        if (!session()->get('zd_uid')) {
            return redirect()->to(base_url());
        }
		
		$this->productdisplayModel = new ProductDisplayModel();
        $this->categories = $this->productdisplayModel->getAllCategoriesAndSub();
	    $data['categories'] = $this->categories;

        $data['product'] = $this->productdisplayModel->getAllProducts();

        $zd_uid = session()->get('zd_uid');
        $model = new AddressModel();
       $orderModel = new OrderNowModel();
    
       $od_Id = $this->request->getPost('od_Id');

        $addresses = $model->getAllAddresses($zd_uid);
		$orders = $orderModel->getOrdersById($od_Id);

        $data = [
            'details'      => $model->getDefaultAddress($zd_uid),
            'addresses'    => $addresses,
            'is_new_user'  => empty($addresses),
			'od_Id'        => $od_Id,
			'order'		=> $orders,
        ];

        return view('common/header',$data)
             . view('order_now', $data)
             . view('common/footer')
             . view('pagescripts/OrderNowjs');
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
        $zd_uid = session()->get('zd_uid');
        $model = new AddressModel();

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
            'add_Status'     => 1,
            'add_createdon'  => date("Y-m-d H:i:s"),
            'add_Default'    => 1
        ];

        // Reset all defaults to 0 before inserting new default
        $model->where('add_CustId', $zd_uid)->set(['add_Default' => 0])->update();

        if ($model->insert($data)) {
            $insertId = $model->getInsertID();
            $details = $model->find($insertId);
            return $this->response->setJSON([
                'success'  => 1,
                'insertId' => $insertId,
                'details'  => $details,
                'message'  => 'Address saved successfully.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => 0,
                'message' => 'Failed to save address.',
                'errors'  => $model->errors()
            ]);
        }
    }

    public function orderproduct($od_Id)
    {
        $zd_uid = session()->get('zd_uid');
        if (empty($zd_uid)) {
            return redirect()->to(base_url());
        }
		$this->productdisplayModel = new ProductDisplayModel();
        $categories = $this->productdisplayModel->getAllCategoriesAndSub();
        
		//  $data['categories'] = $this->categories;
         
        
        $orderModel   = new OrderNowModel();
        $addressModel = new AddressModel();

        $orders = $orderModel->getOrdersById($od_Id);

        if (empty($orders)) {
            return redirect()->to(base_url())->with('error', 'Order not found');
        }

        $pr_Id     = $orders->pr_Id;
        $addresses = $addressModel->getAllAddresses($zd_uid);

        $data = [
            'product'      => $orderModel->getProductById($pr_Id),
            'details'      => $addressModel->getDefaultAddress($zd_uid),
            'addresses'    => $addresses,
            'categories'  => $categories,
            'is_new_user'  => empty($addresses),
			'od_Id'        => $od_Id,
			'order'			=> $orders,
        ];
      
      

        return view('common/header',$data)
             . view('order_now', $data)
             . view('common/footer')
             . view('pagescripts/OrderNowjs');
    }

    public function submitfrm()
    {
        $orderModel    = new OrderNowModel();
        $addressModel  = new AddressModel();
        $productModel  = new ProductDisplayModel();

        $zd_uid = session()->get('zd_uid');
        $od_Id  = $this->request->getPost('od_Id');
        $add_Id = $this->request->getPost('add_Id') ?? $this->request->getPost('address_id');

        if (empty($zd_uid) || empty($od_Id) || empty($add_Id)) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Missing required information.']);
        }

        $order = $orderModel->getOrdersById($od_Id);
        if (!$order) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Order not found.']);
        }

        // Update stock
        $productModel->updateStockAfterOrder($order->pr_Id, $order->od_Quantity);

        // Update order
        $orderModel->updateOrderStatus($od_Id, [
            'od_Status'    => 1,
            'od_createdby' => $zd_uid,
            'od_createdon' => date('Y-m-d H:i:s'),
            'od_modifyby'  => $zd_uid,
            'add_Id'       => $add_Id
        ]);

        // Send email
        $product  = $orderModel->getProductById($order->pr_Id);
        $customer = $addressModel->find($add_Id);

        if (!$customer) {
            return $this->response->setJSON(['status' => 0, 'msg' => 'Customer address not found.']);
        }

        $addressDetails = implode('<br>', array_filter([
            $customer['add_BuldingNo'] ?? '',
            $customer['add_Street'] ?? '',
            $customer['add_Landmark'] ?? '',
            $customer['add_City'] ?? '',
            $customer['add_State'] ?? '',
            $customer['add_Pincode'] ?? ''
        ]));

        $to        = $customer['add_Email'];
        $subject   = 'Order Confirmation From Zakhi Designs';
        $fromEmail = 'sandra@smartlounge.online';
        $fromName  = 'Sandra';
      //  $logoUrl = base_url(ASSET_PATH . 'assets/images/logo.jpg');

      $logoUrl = base_url(ASSET_PATH . 'assets/images/logo.jpg');

$message = "
    <h3>🛒 Order Confirmation</h3>
    <table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;'>
        <tr style='background-color: #f5f5f5;'>
        <td colspan='2' align='center'>
             <img src='{$logoUrl}' alt='Zakhi Designs Logo' style='height: 60px;'><br>
         <strong style='font-size: 18px;'>Zakhi Designs</strong>
         </td>
        </tr>
        <tr><th>Order ID</th><td>{$od_Id}</td></tr>
        <tr><th>Product</th><td>{$product->pr_Name}</td></tr>
        <tr><th>Product Code</th><td>{$product->pr_Code}</td></tr>
        <tr><th>Quantity</th><td>{$order->od_Quantity}</td></tr>
        <tr><th>Total Amount</th><td>₹{$order->od_Grand_Total}</td></tr>
        <tr><th>Customer Name</th><td>{$customer['add_Name']}</td></tr>
        <tr><th>Email</th><td>{$customer['add_Email']}</td></tr>
        <tr><th>Phone</th><td>{$customer['add_Phone']}</td></tr>
        <tr><th>Delivery Address</th><td>{$addressDetails}</td></tr>
    </table>
    <p style='text-align: center; font-size: 16px; margin-top: 20px;'>
        <strong>Thank you for purchasing with Zakhi Designs!</strong><br>
        We’re excited to prepare your order. Your item will be delivered in the next 5–7 business days.
    </p>
    <p style='text-align: center; margin-top: 20px;'>
        <a href='https://zakhidesigns.com' style='padding: 10px 20px; background-color: #d81b60; color: white; text-decoration: none; border-radius: 5px;'>Visit Our Website</a>
    </p>
    <p style='text-align: center; font-size: 14px; color: #555; margin-top: 30px;'>
        For any queries, reach us at <a href='mailto:support@zakhidesigns.com'>support@zakhidesigns.com</a>
    </p>
";


        $headers  = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: {$fromName} <{$fromEmail}>\r\n";
        $headers .= "Reply-To: {$fromEmail}\r\n";
        $headers .= "Bcc: sandra@smartlounge.online\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        $mailSent = mail($to, $subject, $message, $headers);
        return $this->response->setJSON([
            'status' => $mailSent ? 1 : 0,
            'msg'    => $mailSent ? 'Order confirmation email sent successfully!' : 'Failed to send order email. Please try again later.'
        ]);
    }
}

    // <td colspan='2' align='center'>
    //             <img src='{$logoUrl}' alt='Zakhi Designs Logo' style='height: 60px;'><br>
    //             <strong style='font-size: 18px;'>Zakhi Designs</strong>
    //         </td>