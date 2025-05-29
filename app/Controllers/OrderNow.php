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
			return $template;
    }
    public function orderproduct($pr_Id)
    {
        $zd_uid = session()->get('zd_uid');

        if (empty($zd_uid)) {
            return redirect()->to(base_url());
        }

        $orderModel = new OrderNowModel();
        $data['details'] = $orderModel->getProductWithAddress($zd_uid, $pr_Id);
		
        return view('common/header')
            . view('order_now',$data)
            . view('common/footer');
    }
	public function orderproduct($pr_Id)
	{
		$zd_uid = session()->get('zd_uid');
		if (empty($zd_uid)) {
			return redirect()->to(base_url());
		}

		$model = new \App\Models\OrderNowModel();
		$data['product'] = $model->getProductById($pr_Id);
		$data['address'] = $model->getDefaultAddress($zd_uid);

		if ($this->request->getMethod() === 'post') {
			$orderData = [
				'user_id'       => $zd_uid,
				'product_id'    => $this->request->getPost('pr_Id'),
				'size'          => $this->request->getPost('size'),
				'color'         => $this->request->getPost('selected_color'),
				'quantity'      => $this->request->getPost('quantity'),
				'created_at'    => date('Y-m-d H:i:s')
			];
			$model->insertOrder($orderData);
			return redirect()->to(base_url('order/confirmation'));
		}

		echo view('common/header');
		echo view('order_now', $data);
		echo view('common/footer');
	}
	public function submit()
	{
		if ($this->request->isAJAX()) {
			$data = $this->request->getJSON(true);

			$model = new \App\Models\OrderNowModel();

			$insertData = [
				'user_id'    => session()->get('zd_uid'),
				'product_id' => $data['pr_Id'],
				'size'       => $data['size'],
				'color'      => $data['selected_color'],
				'quantity'   => $data['quantity'],
				'created_at' => date('Y-m-d H:i:s')
			];

			if ($model->insertOrder($insertData)) {
				return $this->response->setJSON(['success' => true]);
			} else {
				return $this->response->setJSON(['success' => false]);
			}
		}

		return $this->response->setStatusCode(403)->setJSON(['error' => 'Invalid request']);
	}

}

?>
   

