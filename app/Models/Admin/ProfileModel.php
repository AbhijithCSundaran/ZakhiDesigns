<?php

namespace App\Models\Admin;  

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'us_Id';
    protected $allowedFields = ['us_Name', 'us_Email', 'us_Password'];
    public function getProfileById($us_Id)
    {
        return $this->asArray()->where('us_Id', $us_Id)->first();
    }
    public function updateProfile($us_Id, $data)
    {
        return $this->where('us_Id', $us_Id)->set($data)->update();
    }
    public function checkCurrentPassword($us_Id, $plainPassword)
    {
        $user = $this->getProfileById($us_Id);
        if ($user && password_verify($plainPassword, $user['us_Password'])) {
            return true;
        }
        return false;
    }
    public function change_passwordNow($new_password,$current_password, $us_Id)
    {
		$new_pass = md5($new_password);
        $check = $this->db->query("select us_Password from user where us_Id= '".$us_Id."'")->getRow();
		$cu_pass = md5($current_password);
		if($check && $check->us_Password == $cu_pass ){
		$result = $this->db->query("UPDATE user SET us_Password = '".$new_pass."' WHERE us_Id = '".$us_Id."'");
		return $result;
		}
    }
    public function emailExistsExcept($Name, $email, $Password, $excludeId)
    {
        $builder = $this->builder();
        $builder->where('us_Name', $Name);
        $builder->where('us_Email', $email);
        
        $builder->where('us_Id !=', $excludeId);
        $query = $builder->get();
        return $query->getNumRows() > 0;
    }
}
