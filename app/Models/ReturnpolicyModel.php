<?php 
namespace App\Models\Admin;

use CodeIgniter\Model;

class ReturnpolicyModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
       
        public function returnpolicy Insert($data) {
            return $this->db->table('returnpolicy')->insert($data);
        }
       
        public function getAll() {
            return $this->db->query("SELECT * FROM returnpolicy WHERE cat_Status <> 3")->getResultArray();
        }
         public function getReturnpolicyByid($id){
            return $this->db->table('returnpolicy')->where('cat_Id', $id)->get()->getRow(); 
    }
}