<?php

namespace App\Controllers;
use App\Models\CustomerLoginModel;


class Weblogin extends BaseController
{

	public function __construct()
	{
		$this->session = \Config\Services::session();
		$this->input = \Config\Services::request();
		$this->customerLoginModel = new CustomerLoginModel();
	}

	public function index(): string
	{

		return view('weblogin');
		
	}

	public function webReg()
	{
		return view('webregister');
		   
	}

	public function webForgot(){
		return view('webforgot');
	}
	public function customerAuthen()
	{
		$email = $this->request->getPost('cust_Email');
		$password = md5($this->request->getPost('cust_Password'));
		if ($email && $password) {
			$userLog = $this->customerLoginModel->getLoginAccount($email, $password);
			if ($userLog) {
				$this->session->set([
					'zd_uid' => $userLog->cust_Id,
					'zd_uname' => $userLog->cust_Name,
					'role' => 'user',
				]);

				echo json_encode(array(
					"status" => 1,
					"msg" => null
				));
			} else {
				echo json_encode([
					"status" => 0,
					"msg" => "Invalid username or password. Please try again!"
				]);
			}
		} else {
			echo json_encode(array(
				"status" => 0,
				"msg" => "Login credentials are mandatory"
			));
		}
	}
	public function webForgotEmailSend()
{
    $forgotCustEmail = $this->request->getPost("forgotCustEmail");
    if ($forgotCustEmail) {
        if (!filter_var($forgotCustEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->response->setJSON([
                'status' => '0',
                'msg' => 'Invalid Email Format.'
            ]);
        }

        // Check if email exists
        $emailExist = $this->customerLoginModel->getEmailExist($forgotCustEmail);
        if ($emailExist) {
            $to = $emailExist['cust_Email'];
            $subject = 'Link to reset your password';
            $fromEmail = 'sandrakbabu23@gmail.com';  
            $fromName = 'Sandra';

            $logoUrl = base_url(ASSET_PATH . 'assets/images/logo.jpg');
            $frgtpswd = base_url('forgot_password');

            $message = "
                <h3>Forgot Password</h3>
                <p style='text-align: center; font-size: 16px; margin-top: 20px;'>
                    <a href='$frgtpswd'>Click Here To Reset The Password.</a>
                </p>
                <p style='text-align: center; margin-top: 20px;'>
                    <a href='https://zakhidesigns.com' style='padding: 10px 20px; background-color: #d81b60; color: white; text-decoration: none; border-radius: 5px;'>Visit Our Website</a>
                </p>
                <p style='text-align: center; font-size: 14px; color: #555; margin-top: 30px;'>
                    For any queries, reach us at <a href='mailto:support@zakhidesigns.com'>support@zakhidesigns.com</a>
                </p>
            ";

            // Load Email library with config
            $emailConfig = new \Config\Email();
            $email = \Config\Services::email($emailConfig);

            $email->setFrom($fromEmail, $fromName);
            $email->setTo($to);
            $email->setSubject($subject);
            $email->setMessage($message);
            $email->setMailType('html');  // very important

            if ($email->send()) {
                return $this->response->setJSON([
                    'status' => 1,
                    'msg' => 'A Reset Link Has Been Sent To Your Email Address.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 0,
                    'msg' => 'Failed To Send The Link. Please Try Again.',
                    'error' => $email->printDebugger(['headers'])
                ]);
            }
        } else {
            return $this->response->setJSON([
                "status" => 0,
                "msg" => "Email Doesn't Exist."
            ]);
        }
    } else {
        return $this->response->setJSON([
            "status" => 0,
            "msg" => "Enter Your Email Address."
        ]);
    }
}




	public function logout()
	{
		$session = session();
		$session->remove(['zd_uid', 'zd_uname']);
		return redirect()->to(base_url('/'));
	}


}