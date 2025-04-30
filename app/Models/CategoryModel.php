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
       
        public function getAllCategory() {
            return $this->db->query("SELECT * FROM category WHERE cat_Status <> 3")->getResultArray();
        }
         public function getCategoryByid($id){
            return $this->db->table('category')->where('cat_Id', $id)->get()->getRow(); 
    }

    public function updateCategory($id, $data)
    {
        return $this->db->table('category')->where('cat_Id', $id) ->update($data);
    }
     public function categoryStatus($id)
     {
        $category = $this->getCategoryByid($id);
        if (!$category) {
            return false;
        }
     $newStatus = ($category->cat_Status == 1) ? 1: 2;
      return $this->updateCategory($cat_Id, ['cat_Status' => $newStatus]);
    }

    public function changeCategoryStatus($cat_status, $cat_id, $modified_by) {
		return $this->db->query("update category set cat_Status = '".$cat_status."', cat_modifyon=NOW(), cat_modifyby='".$modified_by."' where cat_Id = '".$cat_id."'");
	}

    }

?>