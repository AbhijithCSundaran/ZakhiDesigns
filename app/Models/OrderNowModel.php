<?php namespace App\Models;

use CodeIgniter\Model;

class OrderNowModel extends Model
{
    protected $table = 'product'; // Primary table
    protected $primaryKey = 'pr_Id';

   public function getProductWithAddress($cus_Id, $pr_Id)
{
    return $this->db->table('order_detail od')
        ->select('od.*, product.*, address.*')
        ->join('product', 'product.pr_Id = od.pr_Id', 'left')
        ->join('address', 'address.add_Id = od.cus_Id AND address.add_Default = 1', 'left')
        ->where('od.cus_Id', $cus_Id)
        ->where('od.pr_Id', $pr_Id)
        ->orderBy('od.od_Id', 'DESC')
        ->get()
        ->getRowArray();
}
	public function getOrdersById($od_Id)
	{
		return $this->db->query("select * from order_detail where od_Id = '".$od_Id."'")->getRow();
	}
	
	public function getProductByid($pr_Id)
	{
		return $this->db->table('product p')
			->select('p.*, c.cat_Name, s.sub_Category_Name')
			->join('category c', 'c.cat_Id = p.cat_id', 'left')
			->join('subcategory s', 's.sub_Id = p.sub_id', 'left')  // only once
			->where('p.pr_Id', $pr_Id)
			->get()
			->getRow(); 
	}
public function getCustomerAddress($cus_Id)
{
    return $this->db->table('address')
        ->where('add_CustId', $cus_Id)
        ->where('add_Default', 1)
        ->get()
        ->getRow();
}
 public function getDefaultAddress($zd_uid)
    {
        return $this->where(['add_CustId' => $zd_uid, 'add_Default' => 1])->first();
    }

    public function getAllAddresses($zd_uid)
    {
        return $this->where('add_CustId', $zd_uid)->findAll();
    }
}
