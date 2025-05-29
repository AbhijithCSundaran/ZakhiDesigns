<?php 
namespace App\Models;
use CodeIgniter\Model;

class ProductModel extends Model
{
	 public function getAllProducts() {
		return $this->db->table('product')
		->where('pr_Status !=', 3)
		->get()
		->getResultArray();
       }
    protected $table = 'product';
    protected $primaryKey = 'pr_Id';
    protected $allowedFields = ['pr_Name', 'pr_Description', 'pr_Selling_Price', 'product_images'];
/* 	public function searchProducts($keyword)
	{
		return $this->distinct()
			->where('pr_Status !=', 3)
			->like('pr_Name', $keyword)
			->findAll();
	} */
    public function searchProducts($keyword)
	{
		return $this->where('pr_Status !=', 3)
			->like('pr_Name', $keyword)
			->groupBy('pr_Id')
			->findAll();
	}
	 public function getProductById($id)
    {
		 return $this->db->table('product')
        ->where('pr_Id', $id)
        ->get()
        ->getRowArray();
    }


}
?>