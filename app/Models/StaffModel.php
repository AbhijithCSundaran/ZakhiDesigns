<?php 
namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        public function getAllStaff(){
        $query =  $this->db->query("select * from user where us_Role != 1 AND  us_Status = 1");
		return  $query->getResult();
        }
		 public function createStaff($data) {
            return $this->db->table('user')->insert($data);
        }
		public function modifyStaff($us_id,$data) {
					
			$this->db->table('user')->where('us_Id',$us_id)->update($data);
			return $this->db->getLastQuery();
		}
		public function getStaffByid($us_id)
		{
			return $this->db->query("select * from user where us_Id = '".$us_id."'")->getRow();
		}
		public function deleteStaffById($us_status, $us_id, $modified_by)
		{
			return $this->db->query("update user set us_Status = '".$us_status."', us_modifyon=NOW(), us_modifyby='".$modified_by."' where us_Id = '".$us_id."'");
		}
    }

?>
