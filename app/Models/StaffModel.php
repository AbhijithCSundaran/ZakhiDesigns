<?php 
namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        public function getAllStaff(){
			$query =  $this->db->query("select * from user where us_Role != 1 AND  us_Status != 3");
			return  $query->getResult();
        }
		 public function createStaff($data) {
            return $this->db->table('user')->insert($data);
        }
		public function modifyStaff($us_id,$data) {
					
			$this->db->table('user')->where('us_Id',$us_id)->update($data);
			return $this->db->getLastQuery();
		}
		public function getStaffByid($us_Id)
		{
			return $this->db->query("select * from user where us_Id = '".$us_Id."'")->getRow();
		}
		public function deleteStaffById($us_status, $us_id, $modified_by)
		{
			return $this->db->query("update user set us_Status = '".$us_status."', us_modifyon=NOW(), us_modifyby='".$modified_by."' where us_Id = '".$us_id."'");
		}
		public function updateStaff($us_Id, $data)
		{
			return $this->db->table('user')->where('us_Id', $us_Id) ->update($data);
		}
		public function getStaffByEmail($email)
		{
			// Use query builder to check if the email exists (ignoring 'cust_Status = 3' customers)
			$builder = $this->db->table('user');
			$builder->where('us_Email', $email);
			$builder->where('us_Status !=', 3);
			$query = $builder->get();
			return $query->getRowArray(); // This will return a single record or null if not found
		}
		public function emailExistsExcept($email, $excludeId)
		{
			$builder = $this->db->table('user');
			$builder->where('us_Email', $email);
			$builder->where('us_Id !=', $excludeId);
			$builder->where('us_Status !=', 3);
			$query = $builder->get();
			return $query->getNumRows() > 0;
		}
    }

?>
