<?php 
namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        public function getAllCustomer(){
        $sql="select c.*,s.* from customer c, address s where c.cust_Id=s.add_CusId";
		$query = $this->db->query($sql);
		return $query->getResultArray();
        }
		  public function findCustomerById($id)
		  
		{
			return $this->db->query("select * from customer where cust_Id = '".$id."'and cust_Status=1")->getRow();
			//return $this->db->table('customer')->where(['cust_Id' => $id, 'cust_Status' => 1])->first();
		}
		 public function createStaff($data) {
            return $this->db->table('user')->insert($data);
        }
		public function modifyStaff($us_id,$data) {
					
			$this->db->table('user')->where('us_Id',$us_id)->update($data);
			return $this->db->getLastQuery();
		}
		public function deleteStaffById($us_status, $us_id, $modified_by)
		{
			return $this->db->query("update user set us_Status = '".$us_status."', us_modifyon=NOW(), us_modifyby='".$modified_by."' where us_Id = '".$us_id."'");
		}
    }

?>
