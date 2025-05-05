<?php
namespace App\Controllers;
use App\Models\UsModel;

class Auth extends BaseController
{

	public function __construct()
	{

		$this->session = \Config\Services::session();
		$this->input = \Config\Services::request();
		$this->usModel = new UsModel();

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
		$recaptcha = $this->input->getPost('g-recaptcha-response');
		if ($email && $password) {
				$userLog = $this->usModel->getLoginAccount($email, $password);
				if ($userLog) {
					$this->session->set([
						'zd_uid' => $userLog->us_Id,
						'zd_uname' => $userLog->us_Name,
					]);
					//$this->session->get('fav_user_name');
					echo json_encode(array(
						"status" => 1,
						"msg" => null
					));
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
					"msg" => "Login credentials are mandatory"
				));
			}
			
		}

	public function logout()
{
    $session = session();
    $session->destroy();
    return redirect()->to(base_url('/')); 
	//return view('login');
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