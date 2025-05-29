<?php 
namespace App\Models\Admin;

use CodeIgniter\Model;

class OrdersModel extends Model {
	
	public function __construct() {
		$this->db = \Config\Database::connect();
	}
        
		
	protected $table = 'order_detail';
    protected $primaryKey = 'or_Id';
    protected $allowedFields = ['or_Status','tracker_Link','od_Status','cu_Id']; // Adjust to your table

    // For DataTables
   public function getDatatables($searchValue = null)
    {
        $builder = $this->db->table('order_detail')
            ->select([
                'order_detail.od_Id',
                'order_detail.od_Quantity',
                'order_detail.od_Status',
                'order_detail.od_createdon',
                'product.pr_Name',
                'product.pr_Code',
                'customer.cust_Name',
                'customer.cust_Email',
                'customer.cust_Phone'
            ])
            ->join('product', 'product.pr_Id = order_detail.pr_Id', 'left')
            ->join('customer', 'customer.cust_Id = order_detail.cus_Id', 'left');

            if (!empty($searchValue)) {
                $builder->groupStart()
                        ->like('customer.cust_Name', $searchValue)
                        ->groupEnd();
            }

        return $builder->get()->getResult();
    }

   
public function getOrder($od_id)
{
    return $this->db->table('order_detail')
        ->select('order_detail.*, product.pr_Code, product.pr_Description, product.pr_Name')
        ->join('product', 'product.pr_Id = order_detail.pr_Id')
        ->where('order_detail.od_Id', $od_id)
        ->get()
        ->getRow();
}


public function getCustomer($cust_Id)
{
    return $this->db->table('customer')
        ->where('cust_Id', $cust_Id)
        ->get()
        ->getRow();
}

public function getAddress($cust_Id)
{
    return $this->db->table('address')
        ->where('add_CustId', $cust_Id)
        ->where('add_default', '1')
        ->get()
        ->getRow();
}
public function updateStatus($od_id, $tracker, $status)
{
    
    return $this->db->table('order_detail')
        ->where('od_Id', $od_id)
        ->update([
            'tracker_Link' => $tracker,
            'od_Status'    => $status
        ]);
}

   
   
}

?>
