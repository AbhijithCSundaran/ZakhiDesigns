<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        public function getAllProducts() {
            return $this->db->table('product')->where('pr_Status', 1)->get()->getResult();
        }
        public function productimageInsert($data) {
            return $this->db->table('product_image')->insert($data);
        }
        public function updateProductimage($id, $data)
        {
            return $this->db->table('product_image')->where('pri_Id', $id) ->update($data);
        }

        
  
        
        

 
    
   
    }

?>