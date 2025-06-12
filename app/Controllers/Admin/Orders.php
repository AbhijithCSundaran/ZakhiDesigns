<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\OrdersModel;

class Orders extends BaseController
{

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->OrdersModel = new \App\Models\Admin\OrdersModel();
    }

    
	public function index()
	{
		$data = []; 
		$orders = $this->OrdersModel->getDatatables();
		// print_r($orders);
		// exit;
		$template  = view('Admin/common/header');
		$template .= view('Admin/common/leftmenu');
		$template .= view('Admin/orders', $data); 
		$template .= view('Admin/common/footer');
		$template .= view('Admin/page_scripts/ordersjs');

		return $template;
	}
	  
	// Listing table data
       public function ajaxList()
{
    $model = new \App\Models\Admin\OrdersModel();

    $start = $this->request->getPost('start');
    $length = $this->request->getPost('length');
    $searchValue = $this->request->getPost('search')['value'];

    // Get paginated data
    $data = $model->getDatatables($searchValue, $start, $length);

    $formattedData = [];
    foreach ($data['data'] as $row) {
        $formattedData[] = [
            'cust_Name'     => $row->cust_Name ?? 'N/A',
            'cust_Email'    => $row->cust_Email ?? 'N/A',
            'cust_Phone'    => $row->cust_Phone ?? 'N/A',
            'pr_Code'       => $row->pr_Code ?? 'N/A',
            'od_Quantity'   => $row->od_Quantity ?? 'N/A',
            'od_createdon'  => !empty($row->od_createdon) ? date('d M Y, h:i A', strtotime($row->od_createdon)) : 'N/A',
            'od_Status'     => $this->getStatusLabel($row->od_Status),
            'actions'       => '<a href="' . base_url('admin/orders/view/' . $row->od_Id). '">
                                <i class="fa fa-eye"></i></a>'
        ];
    }

    return $this->response->setJSON([
        'draw' => intval($this->request->getPost('draw')),
        'recordsTotal' => $data['total'],        // total records without filtering
        'recordsFiltered' => $data['filtered'],  // total records after filtering
        'data' => $formattedData
    ]);
}

// for Labeling the Status

         private function getStatusLabel($status)
            {
                switch ($status) {
                    case '1':
                        return 'New';
                    case '2':
                        return 'Confirmed';
                    case '3':
                        return 'Packed';
                    case '4':
                        return 'Dispatched';
                    default:
                        return 'Pending';
                }
            }

   public function orderView($od_id)
    {
        $model = new \App\Models\Admin\OrdersModel();
        if($this->session->get('ad_uid')){
             if ($this->request->isAJAX()) {
            $order = $model->getOrder($od_id);
            if (!$order) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Order not found'
                ]);
            }
            
            $cust_Id = $order->cus_Id;
            $customer = $model->getCustomer($cust_Id);
            $address = $model->getAddress($cust_Id);

            return $this->response->setJSON([
                'status' => true,
                'data' => [
                    'order'    => $order,
                    'customer' => $customer,
                    'address'  => $address
                ]
            ]);
        }
        
        $data['od_Id'] = $od_id;
        return view('Admin/common/header')
            . view('Admin/common/leftmenu')
            . view('Admin/order_view', $data)
            . view('Admin/common/footer')
           // . view('Admin/page_scripts/ordersjs');
            . view('Admin/page_scripts/orders_viewjs');
        }

    }

    public function orderStatusUpdation($od_id)
    {
        $model = new \App\Models\Admin\OrdersModel();
        $tracker = $this->input->getPost('tracker');
        $status = $this->input->getPost('status');
        
        if ($this->request->isAJAX()) {
            $updation = $model->updateStatus($od_id, $tracker, $status);
            if (!$status) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Updation not done'
                ]);
            }
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Status updation successful'
            ]);
        }
        return $this->response->setJSON([
            'status' => false,
            'message' => 'Status Updation failed'
        ]);
    }    
	
}


