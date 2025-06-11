<?php

namespace App\Models\Admin;  

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'us_Id';
    protected $allowedFields = ['us_Name', 'us_Email', 'us_Password'];
	protected $returnType = 'array'; 
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
	 public function change_passwordNow($us_Id, $current_password, $new_password)
	{
	$user = $this->find($us_Id);

		if (!$user || md5($current_password) !== $user['us_Password']) {
			return ['status' => 0, 'msg' => 'Old password does not match.'];
		}

		if (md5($new_password) === $user['us_Password']) {
			return ['status' => 0, 'msg' => 'Please enter a new password different from the old one.'];
		}

		$data = ['us_Password' => md5($new_password)];

		if ($this->update($us_Id, $data)) {
			return ['status' => 1, 'msg' => 'Password updated successfully.'];
		} else {
			return ['status' => 0, 'msg' => 'Something went wrong. Could not update password.'];
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
