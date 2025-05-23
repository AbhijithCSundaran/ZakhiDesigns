<?php 
namespace App\Models\Admin;

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
    
public function isCategoryExists($categoryName, $excludeId = null) {
    $builder = $this->db->table('category');
    $builder->where('cat_Name', $categoryName);
    $builder->where('cat_Status !=', 3); // Ignore soft-deleted categories

    if ($excludeId) {
        $builder->where('cat_Id !=', $excludeId);
    }

    return $builder->get()->getRow();
}

    public function updateCategory($id, $data)
    {
        return $this->db->table('category')->where('cat_Id', $id) ->update($data);
    }

    public function deleteCategoryById($cat_status, $cat_id, $modified_by)
		{
			return $this->db->query("update category set cat_Status = '".$cat_status."', cat_modifyon=NOW(), cat_modifyby='".$modified_by."' where cat_Id = '".$cat_id."'");
		}

    }

?>