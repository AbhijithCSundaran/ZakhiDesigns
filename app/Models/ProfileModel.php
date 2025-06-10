<?php namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table      = 'customer';
    protected $primaryKey = 'cust_Id';

    protected $allowedFields = ['cust_Name', 'cust_Email', 'cust_Phone','cust_Password'];

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
	
public function changePassword($custId, $oldPassword, $newPassword)
{
    $user = $this->find($custId);

    if (!$user || md5($oldPassword) !== $user['cust_Password']) {
        return ['status' => 0, 'msg' => 'Old password does not match.'];
    }

    if (md5($newPassword) === $user['cust_Password']) {
        return ['status' => 0, 'msg' => 'Please enter a new password different from the old one.'];
    }

    $data = ['cust_Password' => md5($newPassword)];

    if ($this->update($custId, $data)) {
        return ['status' => 1, 'msg' => 'Password updated successfully.'];
    } else {
        return ['status' => 0, 'msg' => 'Something went wrong. Could not update password.'];
    }
}



}
