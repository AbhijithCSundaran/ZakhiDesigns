<?php
namespace App\Models;
use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'rating', 'review', 'created_at', 'is_approved', 'cust_Id', 'pr_Id'];
    public $timestamps = false;

    public function getAverageRatingForProducts(array $productIds): array
    {
        if (empty($productIds)) {
            return [];
        }

        return $this->select('pr_Id, ROUND(AVG(rating)) as avg_rating')
            ->whereIn('pr_Id', $productIds)
            ->groupBy('pr_Id')
            ->findAll();
    }

	  public function getLimitedReviewsByProductId($productId, $limit = 5)
    {
        return $this->select('reviews.*, customer.*')
                    ->join('customer', 'customer.cust_Id = reviews.cust_Id')
                    ->where('reviews.pr_Id', $productId)
                    ->orderBy('reviews.created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
    // Get total count of reviews for a product
    public function getReviewCountByProductId($productId)
    {
        return $this->where('pr_Id', $productId)
                    ->countAllResults();
    }
}
