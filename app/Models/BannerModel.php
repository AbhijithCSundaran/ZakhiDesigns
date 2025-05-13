<?php 
namespace App\Models;

use CodeIgniter\Model;

class BannerModel extends Model {
	
        public function __construct() {
            $this->db = \Config\Database::connect();
        }
        public function getAllBanners() {
			return $this->db->table('theme')
			->where('the_Status !=', 3)
			->where('the_CatId IS NULL', null, false)
			->where('the_SubId IS NULL', null, false)
			->get()
			->getResultArray();
        }
        public function productimageInsert($data) {
            return $this->db->table('product_image')->insert($data);
        }
        public function updateProductimage($id, $data)
        {
            return $this->db->table('product_image')->where('pri_Id', $id) ->update($data);
        }

		public function getThemeByid($id){
            return $this->db->table('theme')->where('the_Id', $id)->get()->getRow(); 
		}
		public function updateTheme($id, $data)
		{
			return $this->db->table('theme')->where('the_Id', $id) ->update($data);
		}
        public function deleteBanner($the_status, $the_id, $modified_by)
		{
			return $this->db->query("update theme set the_Status = '".$the_status."', the_modifyon=NOW(), the_modifyby='".$modified_by."' where add_Id = '".$the_id."'");
		}
  
        
        

 
    
   
    }

?>