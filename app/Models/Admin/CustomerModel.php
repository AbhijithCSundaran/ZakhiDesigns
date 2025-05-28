<?php 
namespace App\Models\Admin;

use CodeIgniter\Model;

class CustomerModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        public function getAllCustomer(){
			$sql="select * from customer where cust_Status != 3";
        //$sql="select c.*,s.* from customer c, address s where c.cust_Status = 1 and c.cust_Id=s.add_CusId ";
			$query = $this->db->query($sql);
			return $query->getResultArray();
        }
		  public function findCustomerById($id) 
		{
			return $this->db->query("select * from customer where cust_Id = '".$id."'and cust_Status=1")->getRowArray();;
			//return $this->db->table('customer')->where(['cust_Id' => $id, 'cust_Status' => 1])->first();
		}
		 public function createcust($data) {
            return $this->db->table('customer')->insert($data);
        }
		public function modifycust($cust_id,$data) {
					
			$this->db->table('customer')->where('cust_Id',$cust_id)->update($data);
			return $this->db->getLastQuery();
		}
		public function deleteCustById($cust_status, $cust_id, $modified_by)
		{
			return $this->db->query("update customer set cust_Status = '".$cust_status."', cust_modifyon=NOW(), cust_modifyby='".$modified_by."' where cust_Id = '".$cust_id."'");
		}
		public function updateCustomer($id, $data)
		{
			return $this->db->table('customer')->where('cust_Id', $id) ->update($data);
		}
		public function getCustomerByid($id){
            return $this->db->table('customer')->where('cust_Id', $id)->get()->getRow(); 
		}
		public function getCustomerByEmail($email)
		{
			// Use query builder to check if the email exists (ignoring 'cust_Status = 3' customers)
			$builder = $this->db->table('customer');
			$builder->where('cust_Email', $email);
			$builder->where('cust_Status !=', 3);
			$query = $builder->get();
			
			return $query->getRowArray(); // This will return a single record or null if not found
		}

	public function emailExistsExcept($email, $excludeId)
	{
		$builder = $this->db->table('customer');
		$builder->where('cust_Email', $email);
		$builder->where('cust_Id !=', $excludeId);
		$builder->where('cust_Status !=', 3);
		$query = $builder->get();
		return $query->getNumRows() > 0;
	}
	
	
	//**************************Data table */
	protected $table = 'customer';
    protected $primaryKey = 'cust_Id';
    protected $allowedFields = ['cust_Name', 'cust_Email','cust_Phone', 'cust_Status']; // Adjust to your table

    // For DataTables
    public function getDatatables()
	{
		$builder = $this->db->table('customer c');
		
		// Select required fields including category and subcategory names
		$builder->select('c.*');
		
		// Only fetch rows of active staffs
		$builder->where('c.cust_Status !=', 3);

		// Add search logic if required
		$postData = service('request')->getPost();
		if (!empty($postData['search']['value'])) {
			$builder->groupStart()
					->like('c.cust_Name', $postData['search']['value'])
					->groupEnd();
		}

		// Add pagination (limit and offset)
		if (!empty($postData['length']) && $postData['length'] != -1) {
			$builder->limit($postData['length'], $postData['start']);
		}

		// Apply ordering if provided
		if (!empty($postData['order'])) {
			$columns = ['c.cust_Name ', 'c.cust_Email','c.cust_Phone','c.cust_Status'];
			$orderCol = $columns[$postData['order'][0]['column']];
			$orderDir = $postData['order'][0]['dir'];
			$builder->orderBy($orderCol, $orderDir);
		}

		// Execute the query and return the result
		return $builder->get()->getResultArray();
	}


	public function countAll()
	{
		return $this->db->table('customer')
			->where('cust_Status !=', 3)
			->countAllResults();
	}

	public function countFiltered()
	{
		$builder = $this->db->table('customer c');

		// Only fetch rows where either staffs exists
		$builder->where('c.cust_Status !=', 3);
	 
		$postData = service('request')->getPost();
		if (!empty($postData['search']['value'])) {
			$builder->groupStart()
					->like('c.cust_Name', $postData['search']['value'])
					->groupEnd();
		}
		return $builder->countAllResults();
	}
    }

?>


