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
}
