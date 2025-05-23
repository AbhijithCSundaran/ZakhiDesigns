<?php 
namespace App\Models\Admin;

use CodeIgniter\Model;

class SubcategoryModel extends Model {

     protected $table = 'subcategory';
    protected $primaryKey = 'sub_Id'; // Fixed: Removed space
    protected $allowedFields = ['sub_Category_Name', 'sub_Discount_Value', 'sub_Discount_Type', 'sub_Status'];
	
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

    // DataTables: Get filtered subcategories
    public function getDatatables() {
        $builder = $this->db->table('subcategory s');
        $builder->select('s.*, c.cat_Name');
        $builder->join('category c', 'c.cat_Id = s.cat_Id', 'left');
        $builder->where('s.sub_Status !=', 3);

        $postData = service('request')->getPost();

        if (!empty($postData['search']['value'])) {
            $builder->groupStart()
                ->like('s.sub_Category_Name', $postData['search']['value'])
                ->orLike('c.cat_Name', $postData['search']['value'])
                ->groupEnd();
        }

        if (!empty($postData['length']) && $postData['length'] != -1) {
            $builder->limit($postData['length'], $postData['start']);
        }

        if (!empty($postData['order'])) {
            $columns = ['s.sub_Id', 's.sub_Category_Name', 's.sub_Discount_Value', 's.sub_Discount_Type', 's.sub_Status'];
            $orderCol = $columns[$postData['order'][0]['column']];
            $orderDir = $postData['order'][0]['dir'];
            $builder->orderBy($orderCol, $orderDir);
        }

        return $builder->get()->getResultArray();
    }

    // Count all subcategories (excluding deleted)
    public function countAll() {
        return $this->db->table('subcategory')
            ->where('sub_Status !=', 3)
            ->countAllResults();
    }

    // Count filtered subcategories (DataTables support)
    public function countFiltered() {
        $builder = $this->db->table('subcategory s');
        $builder->join('category c', 'c.cat_Id = s.cat_Id', 'left');
        $builder->where('s.sub_Status !=', 3);

        $postData = service('request')->getPost();
        if (!empty($postData['search']['value'])) {
            $builder->groupStart()
                ->like('s.sub_Category_Name', $postData['search']['value'])
                ->orLike('c.cat_Name', $postData['search']['value'])
                ->groupEnd();
        }

        return $builder->countAllResults();
    }


    }

?>