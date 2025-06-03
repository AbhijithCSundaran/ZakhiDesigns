<?php namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
	
    protected $table = 'address';
    protected $primaryKey = 'add_Id';
    protected $allowedFields = [
        'add_CustId', 'add_Name', 'add_Email', 'add_Phone',
        'add_BuldingNo', 'add_Street', 'add_Landmark',
        'add_City', 'add_State', 'add_Pincode', 'add_Default'
    ];

    public function getDefaultAddress($zd_uid)
    {
        return $this->where(['add_CustId' => $zd_uid, 'add_Default' => 1])->first();
    }
	public function insertOrder($data)
	{
		$this->db->table('order_detail')->insert($data);
		return $this->db->insertID(); // return the inserted ID
	}
    public function getAllAddresses($zd_uid)
    {
        return $this->where('add_CustId', $zd_uid)->findAll();
    }
	
	public function insertAndSetDefault($zd_uid, $data)
{
    // 1. Unset all previous default addresses
    $this->builder()->where('add_CustId', $zd_uid)->update(['add_Default' => 0]);

    // 2. Prepare new address data
    $data['add_CustId']   = $zd_uid;
    $data['add_Default']  = 1;

    // 3. Insert new address
    $this->insert($data);
    $newId = $this->getInsertID();

    // 4. Return newly inserted address
    return $this->find($newId);
}

}
