<?php
 
namespace App\Controllers;
 
use App\Models\CustomerLoginModel;
 
class GoogleLoginCallback extends BaseController
{
    protected $customerLoginModel;
 
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
        $this->customerLoginModel = new CustomerLoginModel();
    }
 
    public function googleLogin()
    {
        $data = $this->request->getJSON(true);
 
        if (!isset($data['email']) || !isset($data['google_token'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email and Google token are required.',
                'data'    => []
            ]);
        }
 
        $googleToken = $data['google_token'];
        $email = $data['email'];
 
        // Verify Google ID token
        $client = \Config\Services::curlrequest();
        $response = $client->get("https://oauth2.googleapis.com/tokeninfo?id_token=" . $googleToken);
 
        if ($response->getStatusCode() !== 200) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid Google token.',
                'data'    => []
            ]);
        }
 
        $googleUser = json_decode($response->getBody(), true);
 
        if ($googleUser['email'] !== $email) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Token and email do not match.',
                'data'    => []
            ]);
        }
 
        $user = $this->customerLoginModel->where('cust_Email', $email)->first();
        $isNew = false;
        $now = date('Y-m-d H:i:s');
 
        if ($user) {
            if ($user['auth_type'] !== 'google') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'This account is registered with manual login. Please use email and password.',
                    'data'    => []
                ]);
            }
 
            if ($user['cust_Status'] == 2) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Your account has been suspended by the admin.',
                    'data'    => []
                ]);
            } elseif ($user['cust_Status'] == 3) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Account deleted.',
                    'data'    => []
                ]);
            }
 
        } else {
            $newUserData = [
                'cust_Email'      => $email,
                'cust_Name'       => isset($googleUser['name']) ? $googleUser['name'] : explode('@', $email)[0],
                'cust_Password'   => '',
                'auth_type'       => 'google',
                'cust_Phone'      => '',
                'cust_Status'     => 1,
                'cust_createdon'  => $now,
                'cust_createdby'  => 1,
                'cust_modifyby'   => 1,
                'cust_modifyon'   => $now
            ];
 
            $this->customerLoginModel->insert($newUserData);
            $userId = $this->customerLoginModel->insertID();
            $user = $this->customerLoginModel->find($userId);
            $isNew = true;
        }
 
        // Optionally set session (if you're not using JWT):
        $this->session->set([
            'cust_Id'     => $user['cust_Id'],
            'cust_Name'   => $user['cust_Name'],
            'logged_in'   => true,
            'login_type'  => 'google'
        ]);
 
        return $this->response->setJSON([
            'success' => true,
            'message' => $isNew ? 'Registration successful via Google.' : 'Google login successful.',
            'data'    => [
                'cust_Id'        => $user['cust_Id'],
                'cust_Name'      => $user['cust_Name'],
                'cust_Phone'     => $user['cust_Phone'] ?? '',
                'cust_Email'     => $user['cust_Email'],
                'auth_type'      => $user['auth_type'] ?? 'google',
                'cust_Status'    => $user['cust_Status'],
                'cust_createdon' => $user['cust_createdon'],
                'cust_modifyon'  => $user['cust_modifyon']
            ]
        ]);
    }
}