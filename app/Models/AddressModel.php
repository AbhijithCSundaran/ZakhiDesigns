<?php

namespace App\Models;

use CodeIgniter\Model;

class AddressModel extends Model
{
		public function getAllCustomer()
		{
			return $this->db->table('customer c')
				->join('address s', 'c.cust_Id = s.add_CusId')
				->select('c.*, s.*')
				->where('c.cust_Status !=', 3)
				->where('s.add_Status !=', 3)
				->get()
				->getResultArray();
		}

}
