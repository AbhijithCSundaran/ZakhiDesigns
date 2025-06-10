<?php namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table      = 'customer';
    protected $primaryKey = 'cust_Id';

    protected $allowedFields = ['cust_Name', 'cust_Email', 'cust_Phone'];

    public function getUserById($id)
    {
        return $this->find($id);
    }

    public function updateUserProfile($id, $data)
    {
        if ($this->update($id, $data)) {
            return $this->getUserById($id); 
        }
        return false;
    }
}
