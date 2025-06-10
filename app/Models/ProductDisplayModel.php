<?php 
namespace App\Models;
use CodeIgniter\Model;

class ProductDisplayModel extends Model
{
	protected $table = 'product';
    protected $primaryKey = 'pr_Id';
	protected $allowedFields = ['pr_Name', 'pr_Description', 'pr_Selling_Price', 'product_images',
	'cat_Id', 'sub_Id','pr_Price','pr_modifyon','pr_Stock','pr_Status'];
	public function getAllProducts()
	{

		return $this->db->query("select pd.*, avg(rating) as ratings 
							from product as pd 
							left join reviews as rw on rw.pr_Id = pd.pr_Id 
							where pd.pr_Status = 1 group by pd.pr_Id")->getResultArray();
		
	}

   
/* 	public function searchProducts($keyword)
	{
		return $this->distinct()
			->where('pr_Status !=', 3)
			->like('pr_Name', $keyword)
			->findAll();
	} */
	
	///// view collection ////
	public function getSimilarProducts($cat_Id, $excludeId)
{
    return $this->select('product.pr_Id, product.pr_Name, product.product_images, product.pr_Selling_Price, AVG(reviews.rating) as ratings')               ->join('reviews', 'reviews.pr_Id = product.pr_Id', 'left')
                ->where('product.cat_Id', $cat_Id)
                ->where('product.pr_Status', 1)
                ->where('product.pr_Id !=', $excludeId)
                ->groupBy('product.pr_Id, product.pr_Name, product.product_images, product.pr_Selling_Price')
                ->orderBy('product.pr_createdon', 'DESC')
                ->findAll(8);
}

	public function getProductsByModifiedDate()
    {
       return $this->select('product.*, AVG(reviews.rating) AS ratings')
            ->join('reviews', 'reviews.pr_Id = product.pr_Id', 'left')
            ->where('product.pr_Status', 1)
            ->where('product.pr_createdon IS NOT NULL') // or any condition you want
            ->groupBy('product.pr_Id')
            ->orderBy('product.pr_createdon', 'DESC')
            ->findAll();

    }


 public function getAllProduct()
    {
       return $this->db->query("select pd.*, avg(rating) as ratings 
				from product as pd 
				left join reviews as rw on rw.pr_Id = pd.pr_Id 
				where pd.pr_Status = 1 group by pd.pr_Id")->getResultArray();
    }
    public function getProductsByCategoryName($cat_Id)
    {
       return $this->select('product.*, AVG(reviews.rating) AS ratings')
            ->join('reviews', 'reviews.pr_Id = product.pr_Id', 'left')
            ->where('product.cat_Id', $cat_Id)
            ->where('product.pr_Status', 1)
            ->groupBy('product.pr_Id')
            ->orderBy('product.pr_createdon', 'DESC')
            ->findAll();


    }

    public function getProductsBySubcategoryName($sub_Id)
    {
       return $this->select('product.*, AVG(reviews.rating) AS ratings')
            ->join('reviews', 'reviews.pr_Id = product.pr_Id', 'left')
            ->where('product.sub_Id', $sub_Id)
            ->where('product.pr_Status', 1)
            ->groupBy('product.pr_Id')
            ->orderBy('product.pr_createdon', 'DESC')
            ->findAll();

    }
    public function searchProducts($keyword)
	{
		return $this->select('product.*, AVG(reviews.rating) AS ratings')
            ->join('reviews', 'reviews.pr_Id = product.pr_Id', 'left')
            ->where('product.pr_Status', 1)
            ->like('product.pr_Name', $keyword)
            ->groupBy('product.pr_Id')
            ->findAll();

			
	}
	 public function getProductById($id)
    {
	
		$builder = $this->db->query("
        SELECT pd.*, AVG(rw.rating) AS avg_rating
        FROM product AS pd
        LEFT JOIN reviews AS rw ON rw.pr_Id = pd.pr_Id
        WHERE pd.pr_Status = 1 AND pd.pr_Id = ?
        GROUP BY pd.pr_Id
    ", [$id]);

    return $builder->getRowArray();
    }
	public function insertOrder($data)
	{
		$this->db->table('order_detail')->insert($data);
		return $this->db->insertID(); // return the inserted ID
	}

  /*   public function getAllCategoriesWithSub()
    {

        $builder = $this->db->table('category');
        $builder->select('category.id as cat_id, category.cat_Name, subcategory.id as sub_id, subcategory.sub_Name');
        $builder->join('subcategory', 'subcategory.cat_id = category.id', 'left');
        $query = $builder->get();

        $result = [];
        foreach ($query->getResultArray() as $row) {
            $catId = $row['cat_id'];
            if (!isset($result[$catId])) {
                $result[$catId] = [
                    'id' => $catId,
                    'cat_Name' => $row['cat_Name'],
                    'subcategory' => [],
                ];
            }
            if (!empty($row['sub_id'])) {
                $result[$catId]['subcategory'][] = [
                    'id' => $row['sub_id'],
                    'sub_Name' => $row['sub_Name'],
                ];
            }
        }

        return array_values($result);
    }
 */
    public function getAllCategoriesAndSub()
    {
        $db = \Config\Database::connect();

        // Fetch categories
        $categories = $db->table('category')
            ->select('cat_Id, cat_Name')
            ->where('cat_Status', 1)
            ->orderBy('cat_Name', 'ASC')
            ->get()
            ->getResultArray();

        // Fetch subcategories grouped by category
        $subcategories = $db->table('subcategory')
            ->select('sub_Id, sub_Category_Name, cat_Id')
            ->where('sub_Status', 1)
            ->orderBy('sub_Category_Name', 'ASC')
            ->get()
            ->getResultArray();

        // Map subcategories to categories
        $catMap = [];
        foreach ($categories as &$cat) {
            $cat['subcategories'] = [];
            $catMap[$cat['cat_Id']] = &$cat;
        }

        foreach ($subcategories as $sub) {
            if (isset($catMap[$sub['cat_Id']])) {
                $catMap[$sub['cat_Id']]['subcategories'][] = $sub;
            }
        }

        return $categories;


	}
	public function getProductsByCategory($categoryId)
{
    return $this->db->table('product')
        ->where('cat_Id', $categoryId)
        ->where('pr_Status', 1)
        ->get()
        ->getResultArray();
}

public function getProductsBySubCategory($subCategoryId)
{
    return $this->db->table('product')
        ->where('sub_Id', $subCategoryId)
        ->where('pr_Status',1)
        ->get()
        ->getResultArray();
}
public function updateStockAfterOrder($pr_Id, $quantity)
    {
        $product = $this->find($pr_Id);
        if ($product && isset($product['pr_Stock'])) {
            $newStock = max(0, $product['pr_Stock'] - $quantity); // avoid negative stock
            $this->update($pr_Id, ['pr_Stock' => $newStock]);
        }
    }

}
?>