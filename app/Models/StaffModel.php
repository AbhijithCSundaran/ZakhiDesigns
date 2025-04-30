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
    }

?>