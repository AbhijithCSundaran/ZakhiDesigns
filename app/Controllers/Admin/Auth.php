<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\Admin\UsModel;

class Auth extends BaseController
{

	public function __construct()
	{

		$this->session = \Config\Services::session();
		$this->input = \Config\Services::request();
		$this->usModel = new \App\Models\Admin\UsModel();

	}
    // public function login()
    // {
    //     echo  $email = $this->request->getPost('email');
	// 	echo $password = $this->request->getPost('password');
    //     exit();
    // }

    public function authenticate()
    {

        $email = $this->request->getPost('email');
		$password = md5($this->request->getPost('password'));
		//$recaptcha = $this->input->getPost('g-recaptcha-response');
		if ($email && $password){
				$userLog = $this->usModel->getLoginAccount($email, $password);
				if ($userLog) {
					$this->session->set([
						'ad_uid' => $userLog->us_Id,
						'ad_uname' => $userLog->us_Name,
						'role' => 'admin',
					]);
					if($userLog->us_Status == '1'){
						echo json_encode(array(
							"status" => 1,
							"msg" => null
						));
					}	
					if($userLog->us_Status == '2'){
						echo json_encode(array(
							"status" => 0,
							"msg" => "Staff Access Restricted. Please Contact Admin."
						));	
					}
					if($userLog->us_Status == '3'){
						echo json_encode(array(
							"status" => 0,
							"msg" => "No Such Staff Member Exists."
						));	
					}
				} else {
					echo json_encode(array(
						"status" => 0,
						"msg" => "Invalid Credentials"
					));
				}
			} 
		else {
				echo json_encode(array(
					"status" => 0,
					"msg" => "Login Credentials Are Mandatory"
				));
			}
			
		}

	public function logout()
	{
		$session = session();
		$session->remove(['ad_uid', 'ad_uname']); 
		return redirect()->to(base_url('admin'));
	}



	private function reCaptcha($recaptcha)
    {
        $secretKey = '6LeoL5UpAAAAANCPPYP_gZWrENl5vYFJIZytnUkD';
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents($url . '?secret=' . $secretKey . '&response=' . $recaptcha);
        $result = json_decode($response, true);

        return $result['success'] ?? false;
    }
}
?>