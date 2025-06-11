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
         
    
public function isCategoryExists($categoryName, $excludeId = null) {
    $builder = $this->db->table('category');
    $builder->where('cat_Name', $categoryName);
    $builder->where('cat_Status !=', 3); // Ignore soft-deleted categories

    if ($excludeId) {
        $builder->where('cat_Id !=', $excludeId);
    }

    return $builder->get()->getRow();
}
	public function getCategoryByid($catId){

			return $this->db->query("select * from category where cat_Id = '".$catId."'")->getRow();
    }
    public function updateCategory($catId, $data)
    {
        return $this->db->table('category')->where('cat_Id', $catId) ->update($data);
    }
  // delete category
  
   // public function deleteCategoryById($cat_id, $modified_by)
	// {
		// $subcategory = $this->db->table('subcategory')
								// ->select('sub_Id')
								// ->where('cat_Id', $cat_id)
								// ->get()
								// ->getResult();
		// $sub = array_map(function($row) {
			// return $row->sub_Id;
		// }, $subcategory);

		// $product = $this->db->table('product')
							// ->select('pr_Id')
							// ->groupStart()
								// ->where('cat_Id', $cat_id)
								// ->orWhereIn('sub_Id', $sub)
							// ->groupEnd()
							// ->where('pr_Status', 1)
							// ->get()
							// ->getResult();

		// if (!empty($product) || !empty($sub))) {
			// return false;
		// } else {
			// return $this->db->table('category')
				// ->where('cat_Id', $cat_id)
				// ->update([
					// 'cat_Status'   => 3,
					// 'cat_modifyon' => date('Y-m-d H:i:s'),
					// 'cat_modifyby' => $modified_by
				// ]);
		// }
	// }
	
	public function deleteCategoryById($cat_id, $modified_by)
{
	$subcategory = $this->db->table('subcategory')
							->select('sub_Id')
							->where('cat_Id', $cat_id)
							->get()
							->getResult();
							
	
	$product = $this->db->table('product')
						->select('pr_Id')
						->groupStart()
							->where('cat_Id', $cat_id)
						->groupEnd()
						->where('pr_Status', 1)
						->get()
						->getResult();

	if (!empty($product) || !empty($subcategory)) {
		return false;
	} else {
		return $this->db->table('category')
			->where('cat_Id', $cat_id)
			->update([
				'cat_Status'   => 3,
				'cat_modifyon' => date('Y-m-d H:i:s'),
				'cat_modifyby' => $modified_by
			]);
	}
}



		
	//**************************Data table */
				
	protected $table = 'category';
    protected $primaryKey = 'cat_Id';
    protected $allowedFields = ['cat_Name', 'cat_Discount_Value','cat_Discount_Type','cat_Status']; // Adjust to your table

    // For DataTables
    public function getDatatables()
	{
		$builder = $this->db->table('category c');
		
		// Select required fields including category and subcategory names
		$builder->select('c.*');
		
		// Only fetch rows of active staffs
		$builder->where('c.cat_Status !=', 3);

		// Add search logic if required
		$postData = service('request')->getPost();
		if (!empty($postData['search']['value'])) {
			$builder->groupStart()
					->like('c.cat_Name', $postData['search']['value'])
					->groupEnd();
		}

		// Add pagination (limit and offset)
		if (!empty($postData['length']) && $postData['length'] != -1) {
			$builder->limit($postData['length'], $postData['start']);
		}

		// Apply ordering if provided
		if (!empty($postData['order'])) {
			$columns = ['c.cat_Id ', 'c.cat_Name', 'cat.cat_Discount_Value','cat.cat_Discount_Type','c.cat_Status'];
			$orderCol = $columns[$postData['order'][0]['column']];
			$orderDir = $postData['order'][0]['dir'];
			$builder->orderBy($orderCol, $orderDir);
		}

		// Execute the query and return the result
		return $builder->get()->getResultArray();
	}


	public function countAll()
	{
		return $this->db->table('category')
			->where('cat_Status !=', 3)
			->countAllResults();
	}

	public function countFiltered()
	{
		$builder = $this->db->table('category c');

		// Only fetch rows where either staffs exists
		$builder->where('c.cat_Status !=', 3);
	 
		$postData = service('request')->getPost();
		if (!empty($postData['search']['value'])) {
			$builder->groupStart()
					->like('c.cat_Name', $postData['search']['value'])
					->groupEnd();
		}
		return $builder->countAllResults();
	}
    }

    

?>