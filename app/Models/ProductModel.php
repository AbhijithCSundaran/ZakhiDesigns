<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        

 public function getAllProducts()
{
    return $this->db->table('product')
        ->select('product.*, subcategory.sub_Category_Name, category.cat_Name')
        ->join('subcategory', 'subcategory.sub_Id = product.sub_Id', 'left')
        ->join('category', 'category.cat_Id = product.cat_Id', 'left')
        ->where('product.pr_Status !=', 3)
        ->get()
        ->getResult();
}

        
        
       
        public function productInsert($data) {
            return $this->db->table('product')->insert($data);
        }
       
        public function getAllCatandSub() {
            return $this->db->table('subcategory')
                ->select('subcategory.*, category.cat_Name')
                ->join('category', 'category.cat_Id = subcategory.cat_Id', 'left')
                ->where('subcategory.sub_Status !=', 3)
                ->get()
                ->getResult();
        }
        public function updateProduct($id, $data)
        {
            return $this->db->table('product')->where('pr_Id', $id) ->update($data);
        }

        public function getSubcategoriesByCatId($catId)
{
    return $this->db->table('subcategory')
        ->where('cat_Id', $catId)
        ->where('sub_Status !=', 3)
        ->get()
        ->getResult();
}

public function getAllCategories()
{
    return $this->db->table('category')
        ->where('cat_Status !=', 3)
        ->get()
        ->getResult();
}
        

     public function getProductImages($productId)
    {
        return $this->db->table('product')
                    ->where('pr_Id', $productId)
                    ->select('product_images')
                    ->first()['product_images'] ?? '[]';
    }

    public function updateProductImages($productId, $mediaJson)
    {
        return $this->db->table('product')
        ->where('pr_Id', $productId)->set(['product_images' => $mediaJson])->update();

    }
  
        
        

 
    
   
    }

?>