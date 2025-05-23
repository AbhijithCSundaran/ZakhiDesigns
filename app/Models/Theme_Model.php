<?php 
namespace App\Models;

use CodeIgniter\Model;

class Theme_Model extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        public function getAllBanners() {
			return $this->db->table('themes')
			->where('theme_Status !=', 3)
			->get()
			->getResultArray();
        }
        /* public function createBanner($data) {
            return $this->db->table('theme')->insert($data);
        } */
		
		public function insert_data($data)
		{
			return $this->db->table('themes')->insert($data);
		}

		public function modifyThemes($id, $data)
		{
			return $this->db->table('themes')->where('theme_Id', $id)->update($data);
		}

		public function getThemesByid($id)
		{
			return $this->db->table('themes')->where('theme_Id', $id)->get()->getRow();
		}

		 /* public function insert_data($data) {
            return $this->db->table('themes')->insert($data);
        }*/
		
		public function getThemeByid($id){
            return $this->db->table('themes')->where('theme_Id', $id)->get()->getRow(); 
		} 
		public function getThemeStatusByid($themeId){
            return $this->db->table('themes')->where('theme_Id', $themeId)->get()->getRow(); 
		}
		public function deactivateAllThemesExcept($themeId)
		{
			
			return $this->db->table('themes')
				->where('theme_Id !=', $themeId)
				->where('theme_Status !=',3)
				->update(['theme_Status' => 2]);
		}
		public function updateTheme($themeId, $data)
		{
			return $this->db->table('themes')->where('theme_Id', $themeId) ->update($data);
		}
        public function deleteBannerById($theme_Status, $theme_id, $modified_by)
		{
			return $this->db->query("update themes set theme_Status = '".$theme_Status."', theme_modifyon=NOW(), theme_modifyby='".$modified_by."' where theme_Id = '".$theme_id."'");
		}
		/* public function modifyThemes($theme_id,$data) {
					
			$this->db->table('themes')->where('theme_Id',$theme_id)->update($data);
			return $this->db->getLastQuery();
		} */
  /****************************************************************************************************************/
   protected $table = 'themes';
    protected $primaryKey = 'theme_Id';
    protected $allowedFields = ['theme_Name', 'theme_Home_Banner', 'theme_Status']; // Adjust to your table

    // For DataTables
   public function getDatatables()
{
    $builder = $this->db->table('themes t');
    
    // Select required fields including category and subcategory names
    $builder->select('t.*');
	
    // Only fetch rows where either category or subcategory exists
    $builder->where('t.theme_Status !=', 3);

    // Add search logic if required
    $postData = service('request')->getPost();
    if (!empty($postData['search']['value'])) {
        $builder->groupStart()
                ->like('t.the_Name', $postData['search']['value'])
                ->groupEnd();
    }

    // Add pagination (limit and offset)
    if (!empty($postData['length']) && $postData['length'] != -1) {
        $builder->limit($postData['length'], $postData['start']);
    }

    // Apply ordering if provided
    if (!empty($postData['order'])) {
        $columns = ['t.theme_Id', 't.theme_Name', 't.theme_Decsription','t.theme_Status'];
        $orderCol = $columns[$postData['order'][0]['column']];
        $orderDir = $postData['order'][0]['dir'];
        $builder->orderBy($orderCol, $orderDir);
    }

    // Execute the query and return the result
    return $builder->get()->getResultArray();
}


	public function countAll()
	{
		return $this->db->table('themes')
			->where('theme_Status !=', 3)
			->countAllResults();
	}

	public function countFiltered()
{
    $builder = $this->db->table('themes t');

    // Only fetch rows where either category or subcategory or products exists
    $builder->where('t.theme_Status !=', 3);
 
    $postData = service('request')->getPost();
    if (!empty($postData['search']['value'])) {
        $builder->groupStart()
                ->like('t.theme_Name', $postData['search']['value'])
                ->groupEnd();
    }
    return $builder->countAllResults();
}




  /***************************************************************************************************/
  }      

?>