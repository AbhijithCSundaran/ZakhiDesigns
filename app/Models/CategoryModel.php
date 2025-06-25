<?php 
namespace App\Models;
use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'category';

    // Fix: removed the space from primaryKey
    protected $primaryKey = 'cat_Id';

    protected $allowedFields = []; // Add actual allowed fields if you plan to use insert/update

    public function getAllCategory()
    {
        $query = "
            SELECT * FROM (
    SELECT 
        c.cat_Id,
        c.cat_Name,
        (
            SELECT p.product_images
            FROM product p
            WHERE p.cat_Id = c.cat_Id 
              AND p.product_images IS NOT NULL
              AND p.product_images != ''
            ORDER BY RAND()
            LIMIT 1
        ) AS product_images
        FROM category c
    ) AS category_images
    WHERE product_images IS NOT NULL

        ";
        return $this->db->query($query)->getResultArray();
    }
    
    public function getAllProductUnderCategory($id){
        return $this->db->query("select * from product where cat_Id = '".$id."' and pr_Status = 1 ")->getResultArray();
    }
}

?>