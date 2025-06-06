<?php 
namespace App\Models\Admin;

use CodeIgniter\Model;

class CategoryModel extends Model {

     public function __construct() {
            $this->db = \Config\Database::connect();
        }
}

?>