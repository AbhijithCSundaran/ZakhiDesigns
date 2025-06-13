<?php
namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'order_detail'; // adjust if your table is named differently
    protected $primaryKey = 'od_Id';

    protected $allowedFields = [
        'cus_Id', 'pr_Id', 'od_Quantity', 'od_Selling_Price', 'od_Status', 'od_createdon','od_status',
		'od_Size','od_Color','od_Original_Price','od_DiscountValue','od_DiscountType','od_createdby',
		'od_modifyby','od_modifyon','tracker_link','pr_Code','od_Grand_Total'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'od_createdon';
    protected $updatedField  = 'od_modifyon'; // optional

    /**
     * Get all orders for a specific user.
     *
     * @param int $userId
     * @return array
     */
    public function getOrdersByUser($userId)
	{
	// 	return $this->select('order_detail.*, product.*')
	// 				->join('product', 'product.pr_Id = order_detail.pr_Id')
	// 				->where('order_detail.cus_Id', $userId)
	// 				->orderBy('order_detail.od_createdon', 'DESC')
	// 				->findAll();
    return $this->select('order_detail.*, product.*')
            ->join('product', 'product.pr_Id = order_detail.pr_Id')
            ->where('order_detail.cus_Id', $userId)
            ->where('order_detail.od_Status', 1) // added condition
            ->orderBy('order_detail.od_createdon', 'DESC')
            ->findAll();

	}


    /**
     * Get orders with product details (JOIN)
     *
     * @param int $userId
     * @return array
     */
    public function getOrdersWithProducts($userId)
    {
        return $this->select('order_detail.*, product.pr_Name, product.product_image')
                    ->join('product', 'product.pr_Id = order_detail.pr_Id')
                    ->where('order_detail.cus_Id', $userId)
                    ->orderBy('order_detail.od_createdon', 'DESC')
                    ->findAll();
    }

}
