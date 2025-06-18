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

	public function index()
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
					'status' => 0,
					'msg' => 'Invalid Email Format.'
				]);
			}

			// Check if email exists
			$emailExist = $this->customerLoginModel->getEmailExist($forgotCustEmail);
			if ($emailExist) {
				$to        = $forgotCustEmail;
				$subject   = 'Link to reset your password';
				$fromEmail = 'sandra@smartlounge.online';
				$fromName  = 'Sandra';
				
				$logoUrl = base_url(ASSET_PATH . 'assets/images/logo.jpg');
			// $frgtpswd = base_url('forgotPassword');
			$frgtpswd = base_url('forgotPassword?email=' . urlencode($forgotCustEmail));

				$message = "
					<center>
					<img src='{$logoUrl}' alt='Zakhi Designs Logo' style='height: 60px;'>
					<h2>Forgot Password</h2>
					</center><br>
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

				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=UTF-8\r\n";
				$headers .= "From: {$fromName} <{$fromEmail}>\r\n";
				$headers .= "Reply-To: {$fromEmail}\r\n";
				$headers .= "Bcc: sandra@smartlounge.online\r\n";
				$headers .= "X-Mailer: PHP/" . phpversion();

				$mailSent = mail($to, $subject, $message, $headers);
				
				return $this->response->setJSON([
					'status' => $mailSent ? 1 : 0,
					'msg' => $mailSent ? 'A Reset Link Has Been Sent To Your Email Address.' : 'Failed To Send The Link. Please Try Again.'
				]);
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