<?php 
namespace App\Models;

use CodeIgniter\Model;

class SubcategoryModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        public function getAllCategory() {
            return $this->db->table('category')->where('cat_Status', 1)->get()->getResult();
        }
        
       public function issubCategoryExists($sub_Name, $excludeId = null) {
    $builder = $this->db->table('subcategory');
    $builder->where('sub_Category_Name', $sub_Name);
    $builder->where('sub_Status !=', 3); 

    if ($excludeId) {
        $builder->where('sub_Id !=', $excludeId);
    }

    return $builder->get()->getRow(); 
}
       
        public function subcategoryInsert($data) {
            return $this->db->table('subcategory')->insert($data);
        }
       
        public function getAllSubcategories() {
            return $this->db->table('subcategory')
                ->select('subcategory.*, category.cat_Name')
                ->join('category', 'category.cat_Id = subcategory.cat_Id', 'left')
                ->where('subcategory.sub_Status !=', 3)
                ->get()
                ->getResult();
        }
        
        

    public function getsubCategoryByid($id) {
        return $this->db->table('subcategory')
            ->select('subcategory.*, category.cat_Name')
            ->join('category', 'category.cat_Id = subcategory.cat_Id', 'left')
            ->where('subcategory.sub_Id', $id)
            ->where('category.cat_Status <>', 3)
            ->get()
            ->getRow();
    }
    
    public function updatesubCategory($id, $data)
    {
        return $this->db->table('subcategory')->where('sub_Id', $id) ->update($data);
    }
     

           public function deleteSubcategoryById($sub_status, $sub_id, $modified_by)
		{
			return $this->db->query("update subcategory set sub_Status = '".$sub_status."', sub_modifiyon=NOW(), sub_modifyby='".$modified_by."' where sub_Id = '".$sub_id."'");
		}
    }

?>