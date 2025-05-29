<?php namespace App\Models;

use CodeIgniter\Model;

class OrderNowModel extends Model
{
    protected $table = 'product'; // Primary table
    protected $primaryKey = 'pr_Id';

    public function getProductWithAddress($zd_uid, $pr_Id)
    {
        // Join address table with condition add_Default = 1 and matching user ID
        return $this->select('product.*, address.*')
                    ->join('address', 'address.add_Id = ' . $this->db->escape($zd_uid) . ' AND address.add_Default = 1', 'left')
                    ->where('product.pr_Id', $pr_Id)
                    ->first();
    }
	public function insertOrder(array $data)
    {
        $this->insert($data);
		return $this->getInsertID(); 
    }
}
