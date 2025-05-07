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
        
       
        public function subcategoryInsert($data) {
            return $this->db->table('subcategory')->insert($data);
        }
       
        // public function getAllsubCategory() {
        //     return $this->db->query("SELECT * FROM subcategory WHERE sub_Status <> 3")->getResultArray();
        // }

        public function getAllsubcategory() {
            return $this->db->table('subcategory')
                ->select('subcategory.*, category.cat_Name, category.cat_status')
                ->join('category', 'category.cat_Id = subcategory.cat_Id', 'left')
                ->where('category.cat_Status <>', 3)
                ->get()
                ->getResultArray();
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
    //  public function categoryStatus($id)
    //  {
    //     $category = $this->getCategoryByid($id);
    //     if (!$category) {
    //         return false;
    //     }
    //  $newStatus = ($category->cat_Status == 1) ? 1: 2;
    //   return $this->updateCategory($cat_Id, ['cat_Status' => $newStatus]);
    // }

    // public function changeCategoryStatus($cat_status, $cat_id, $modified_by) {
	// 	return $this->db->query("update category set cat_Status = '".$cat_status."', cat_modifyon=NOW(), cat_modifyby='".$modified_by."' where cat_Id = '".$cat_id."'");
	// }

    }

?>