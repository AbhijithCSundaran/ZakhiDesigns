<?php 
namespace App\Models;


use CodeIgniter\Model;

class CustomerLoginModel extends Model {
    protected $table = 'customer';
protected $allowedFields = [
    'cust_Name', 'cust_Email', 'cust_Phone', 'cust_Password',
    'cust_Status', 'cust_createdon', 'cust_createdby', 'cust_modifyby'
];

	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }

        public function getLoginAccount($email, $password) {
            // echo "select * from customer where cust_Email = '".$email."' and cust_Password = '".$password."'" ; exit();
		return $this->db->query("select * from customer where cust_Email = '".$email."' and cust_Password = '".$password."'")->getRow();
	    }
        public function getEmailExist($forgotCustEmail) {
            return $this->db->query("select cust_Id,cust_Email,cust_Name from customer where cust_Email = '".$forgotCustEmail."'")->getRow();
        }
        public function resetPasswordNow($pass, $email)
        {
            return $this->db->table('customer')
                ->where('cust_Email', $email)
                ->update(['cust_Password' => $pass]);
        }
        	  public function createcust($data)
    {
        return $this->insert($data);
    }
public function getCustomerByEmail($email)
		{
			// Use query builder to check if the email exists (ignoring 'cust_Status = 3' customers)
			$builder = $this->db->table('customer');
			$builder->where('cust_Email', $email);
			$builder->where('cust_Status !=', 3);
			$query = $builder->get();
			
			return $query->getRowArray(); // This will return a single record or null if not found
		}

    }

        ?>