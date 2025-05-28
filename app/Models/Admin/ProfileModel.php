<?php
namespace App\Models\Admin;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'us_Id';
    protected $allowedFields = ['us_Name', 'us_Email', 'us_Password'];
    protected $returnType = 'array';

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getProfileById($us_Id)
    {
        return $this->db->table('user')->where('us_Id', $us_Id)->get()->getRowArray();
    }

    public function updateProfile($us_Id, $data)
    {
        return $this->db->table('user')->where('us_Id', $us_Id)->update($data);
    }

    public function checkCurrentPassword($us_Id, $plainPassword)
    {
        $user = $this->getProfileById($us_Id);
        if ($user && password_verify($plainPassword, $user['us_Password'])) {
            return true;
        }
        return false;
    }

    public function changePassword($us_Id, $hashedPassword)
    {
        return $this->updateProfile($us_Id, ['us_Password' => $hashedPassword]);
    }

    public function emailExistsExcept($email, $excludeId)
    {
        return $this->db->table('user')
            ->where('us_Email', $email)
            ->where('us_Id !=', $excludeId)
            ->where('us_Status !=', 3)
            ->countAllResults() > 0;
    }
}
