<?php 
namespace App\Controllers;

use App\Models\OrderNowModel;
use CodeIgniter\Controller;

class OrderNow extends Controller
{
	public function index()
    {
			if (!$this->session->get('zd_uid')) {
				return redirect()->to(base_url());
			}
			$template = view('common/header');
			$template.= view('order_now');
			$template.= view('common/footer'); 
			$template.=view('pagescripts/OrderNowjs');
			return $template;
    }
  public function orderproduct($od_Id)
{
    $zd_uid = session()->get('zd_uid');

    if (empty($zd_uid)) {
        return redirect()->to(base_url());
    }

    $orderModel = new OrderNowModel();

    // Fetch order details by order ID
    $orders = $orderModel->getOrdersById($od_Id);

    if (empty($orders)) {
        // Handle case when order is not found, e.g. redirect or show error
        return redirect()->to(base_url())->with('error', 'Order not found');
    }

    $pr_Id = $orders->pr_Id;
	$cus_Id = $orders->cus_Id;

    // Fetch product details by product ID
    $data['product'] = $orderModel->getProductById($pr_Id);

    // Fetch product + address details by customer ID and product ID
    $data['details'] = $orderModel->getProductWithAddress($cus_Id, $pr_Id);

    return view('common/header')
        . view('order_now', $data)
        . view('common/footer')
		.view('pagescripts/OrderNowjs');
}


public function submit()
{
    $orderModel = new OrderNowModel();
    $zd_uid = session()->get('zd_uid');

    if (empty($zd_uid)) {
        return redirect()->to(base_url());
    }

    $od_Id = $this->request->getPost('od_Id'); // Get order ID from form

    if (empty($od_Id)) {
        return $this->response->setJSON([
            'status' => 0,
            'msg'    => 'Missing order ID.'
        ]);
    }

    // Fetch order details
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

    // Fetch product details
    $product = $orderModel->getProductById($pr_Id);
    $productName   = $product->pr_Name ?? '';
    $pr_code       = $product->pr_Code ?? '';
    $selling_price = $order->od_Selling_Price ?? 0;
    $grand_total   = $order->od_Grand_Total ?? 0;

    // Fetch customer address
    $customer = $orderModel->getCustomerAddress($cust_id);
    $custName    = $customer->add_Name ?? '';
    $custPhone   = $customer->add_Phone ?? '';
    $custEmail   = $customer->add_Email ?? '';
    $custAddress = $customer->add_Address ?? '';

    // Prepare message
    $message = "🛒 *New Order Placed*\n"
        . "*Product:* $productName\n"
        . "*Code:* $pr_code\n"
        . "*Amount:* ₹$grand_total\n"
        . "*Customer:* $custName\n"
        . "*Address:* $custAddress\n"
        . "*Phone:* $custPhone\n";

    //  Send Email
		$email = \Config\Services::email();
		$email->setTo($custEmail);
		$email->setBCC('sandra@smartlounge.online'); // Replace with staff email
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
?>
   

