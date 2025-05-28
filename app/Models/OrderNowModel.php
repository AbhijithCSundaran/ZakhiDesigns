<?php
namespace App\Models;
use CodeIgniter\Model;

class OrderNowModel extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'pr_Id';

    // Optional: if you plan to insert/update orders
    protected $allowedFields = [
        'pr_Id', 'pr_Name', 'pr_Description', 'mrp', 'pr_Selling_Price', 'pr_Size', 'pr_Aval_Colors', 'pr_Stock'
    ];

    /**
     * Get full order page data including customer, address, and product info
     */
    public function getOrderData($custId, $productId)
    {
        return $this->db->table('products p')
            ->select('p.*, c.cust_Name, c.cust_Email, c.cust_Phone, a.address_line1, a.address_line2, a.city, a.state, a.zip')
            ->join('customers c', 'c.cust_id = ' . $this->db->escape($custId))
            ->join('addresses a', 'a.cust_id = c.cust_id', 'left')
            ->where('p.pr_Id', $productId)
            ->get()
            ->getRowArray(); // or getRow() for object
    }
}
