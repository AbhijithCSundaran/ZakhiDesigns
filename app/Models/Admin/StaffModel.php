<?php 
namespace App\Models\Admin;

use CodeIgniter\Model;

class StaffModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        public function getAllStaff(){
			$query =  $this->db->query("select * from user where us_Role != 1 AND  us_Status != 3");
			return  $query->getResult();
        }
		 public function createStaff($data) {
            return $this->db->table('user')->insert($data);
        }
		public function modifyStaff($us_id,$data) {
					
			$this->db->table('user')->where('us_Id',$us_id)->update($data);
			return $this->db->getLastQuery();
		}
		public function getStaffByid($us_Id)
		{
			return $this->db->query("select * from user where us_Id = '".$us_Id."'")->getRow();
		}
		public function deleteStaffById($us_status, $us_id, $modified_by)
		{
			return $this->db->query("update user set us_Status = '".$us_status."', us_modifyon=NOW(), us_modifyby='".$modified_by."' where us_Id = '".$us_id."'");
		}
		public function updateStaff($us_Id, $data)
		{
			return $this->db->table('user')->where('us_Id', $us_Id) ->update($data);
		}
		public function getStaffByEmail($email)
		{
			// Use query builder to check if the email exists (ignoring 'cust_Status = 3' customers)
			$builder = $this->db->table('user');
			$builder->where('us_Email', $email);
			$builder->where('us_Status !=', 3);
			$query = $builder->get();
			return $query->getRowArray(); // This will return a single record or null if not found
		}
		public function emailExistsExcept($email, $excludeId)
		{
			$builder = $this->db->table('user');
			$builder->where('us_Email', $email);
			$builder->where('us_Id !=', $excludeId);
			$builder->where('us_Status !=', 3);
			$query = $builder->get();
			return $query->getNumRows() > 0;
		}

		//**************************Data table */
	protected $table = 'user';
    protected $primaryKey = 'us_Id';
    protected $allowedFields = ['us_Name', 'us_Email','us_Email2','us_Phone', 'us_Status']; // Adjust to your table

    // For DataTables
    public function getDatatables()
	{
		$builder = $this->db->table('user u');
		
		// Select required fields including category and subcategory names
		$builder->select('u.*');
		
		// Only fetch rows of active staffs
		$builder->where('u.us_Status !=', 3);

		// Add search logic if required
		$postData = service('request')->getPost();
		if (!empty($postData['search']['value'])) {
			$builder->groupStart()
					->like('u.us_Name', $postData['search']['value'])
					->groupEnd();
		}

		// Add pagination (limit and offset)
		if (!empty($postData['length']) && $postData['length'] != -1) {
			$builder->limit($postData['length'], $postData['start']);
		}

		// Apply ordering if provided
		if (!empty($postData['order'])) {
			$columns = ['u.us_Id ', 'u.us_Name', 'u.us_Email','u.us_Email2','u.us_Phone','u.us_Status'];
			$orderCol = $columns[$postData['order'][0]['column']];
			$orderDir = $postData['order'][0]['dir'];
			$builder->orderBy($orderCol, $orderDir);
		}

		// Execute the query and return the result
		return $builder->get()->getResultArray();
	}


	public function countAll()
	{
		return $this->db->table('user')
			->where('us_Status !=', 3)
			->countAllResults();
	}

	public function countFiltered()
	{
		$builder = $this->db->table('user u');

		// Only fetch rows where either staffs exists
		$builder->where('u.us_Status !=', 3);
	 
		$postData = service('request')->getPost();
		if (!empty($postData['search']['value'])) {
			$builder->groupStart()
					->like('u.us_Name', $postData['search']['value'])
					->groupEnd();
		}
		return $builder->countAllResults();
	}
    }

?>
