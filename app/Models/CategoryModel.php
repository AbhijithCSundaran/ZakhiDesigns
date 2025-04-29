<?php 
namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
       
        public function categoryInsert($data) {
            return $this->db->table('category')->insert($data);
        }
        public function getAllCategory(){
          $catgeory = $this->db->table('category')->get()->getResultArray();
          echo $category;

        }
    }

?>