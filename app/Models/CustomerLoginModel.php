<?php 
namespace App\Models;


use CodeIgniter\Model;

class CustomerLoginModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }

        public function getLoginAccount($email, $password) {
		
		return $this->db->query("select * from customer where cust_Email = '".$email."' and cust_Password = '".$password."'")->getRow();

	}

    }

        ?>