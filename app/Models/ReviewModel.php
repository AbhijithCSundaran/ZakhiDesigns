<?php
namespace App\Models;
use CodeIgniter\Model;

class ReviewModel extends Model {
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'rating', 'review', 'created_at', 'is_approved'];
    public $timestamps = false;
}
