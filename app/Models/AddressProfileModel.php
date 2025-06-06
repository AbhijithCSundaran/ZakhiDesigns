<?php
namespace App\Models;
use CodeIgniter\Model;

class AddressProfileModel extends Model {
    protected $table = 'address';
    protected $primaryKey = 'add_Id';
    protected $allowedFields = ['add_Id', 'add_Name','add_BuildingNo','add_Landmark','add_Street', 'add_City',
	'add_State', 'add_Pincode', 'add_Default','add_Status','add_createdon','add_createdby','add_modifyon',
	'add_modifyby','add_Phone','add_Email','add_CustId' ];

   public function getUserAddresses($userId) {
    return $this->where('add_CustId', $userId)
                ->where('add_Status', 1)
                ->findAll();
}
    public function addAddress($userId, $data) {
        $saveData = [
            'add_CustId'     => $userId,
            'add_Name'       => $data['newName'],
            'add_BuldingNo'  => $data['newBuilding'],
            'add_Landmark'   => $data['newLandmark'],
            'add_Street'     => $data['newStreet'],
			'add_City'       => $data['newCity'],
			'add_State'      => $data['newState'],
			'add_Pincode'    => $data['newPincode'],
            'add_Default'    => isset($data['setAsDefault']) ? 1 : 0,
			'add_Status'     =>1,
			'add_createdon'  =>date("Y-m-d H:i:s"),
			'add_createdby'  =>$userId,
        ];
        return $this->save($saveData);
    }

	public function setAsDefault($userId, $add_Id)
	{
		// Reset all to non-default for the user
		$this->where('add_CustId', $userId)->set(['add_Default' => 0])->update();

		// Set the selected address as default
		return $this->update($add_Id, ['add_Default' => 1]);
	}

    public function updateAddress($data) {
        $updateData = [
           'add_Name'        => $data['add_Name'],
            'add_BuldingNo'  => $data['add_BuldingNo'],
            'add_Landmark'   => $data['add_Landmark'],
            'add_Street'     => $data['add_Street'],
			'add_City'       => $data['add_City'],
			'add_State'      => $data['add_State'],
			'add_Pincode'    => $data['add_Pincode'],
            'add_Default'    => isset($data['setAsDefault']) ? 1 : 0,
			'add_Status'     =>1,
			//'add_modifyon' =>date("Y-m-d H:i:s"),
			'add_modifyby'  =>$data['add_CustId'],
			'add_modifyon'    => date('Y-m-d H:i:s'),
        ];
			$this->db->table('address')->where('add_Id',$data['add_Id'])->update($data);
			return $this->db->getLastQuery();
    }

   public function deleteAddress($add_status, $add_Id, $modified_by) {
    return $this->db->query("
        UPDATE address 
        SET add_Status = '$add_status', 
            add_modifyon = NOW(), 
            add_modifyby = '$modified_by' 
        WHERE add_Id = '$add_Id'
    ");
}

}
