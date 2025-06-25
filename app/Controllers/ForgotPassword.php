<?php

namespace App\Controllers;
use App\Models\CustomerLoginModel;


class ForgotPassword extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->customerLoginModel = new CustomerLoginModel();
        $this->customerModel = new CustomerLoginModel();
    }

    public function index()
    {
        $email = $this->request->getGet('email');
        return view('forgot_password', ['email' => $email]);
    }

    public function resetPassword()
    {
        $new_password = $this->input->getPost('new_reset_password');
        $confirm_password = $this->input->getPost('confirm_reset_password');
        $email = $this->input->getPost('email'); // Example only, replace by actual user email.
		if (empty($new_password) || empty($confirm_password)) {
			return $this->response->setJSON([
				'status' => 0,
				'msg' => 'Both Fields Are Required.'
			]);
		}
		if (strlen($new_password) < 6 || strlen($new_password) > 15) {
			return $this->response->setJSON([
				'status' => 0,
				'msg' => 'Password Must Be 6-15 Characters Long.'
			]);
		}
		else if ($new_password === $confirm_password ) {
				$pass = md5($new_password);
				$this->customerModel->resetPasswordNow($pass, $email);

				return $this->response->setJSON([
					'status' => 1,
					'msg' => 'Password Updated Successfully.',
					 'redirect' => base_url('/')  
				]);
				} else {
					return $this->response->setJSON([
						'status' => 0,
						'msg' => 'New Password Does Not Match With Confirm Password.'
					]);
        		}
    }
}
