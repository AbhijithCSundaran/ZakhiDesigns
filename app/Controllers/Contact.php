<?php
namespace App\Controllers;
use App\Controllers\BaseController;
//use App\Models\DeliveryModel;
use App\Models\ContactModel;
use App\Models\ProductDisplayModel;

class Contact extends BaseController
{
	protected $productdisplayModel;
    protected $categories;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
    }

    public function index()
    {
		$this->productdisplayModel = new ProductDisplayModel();
        $this->categories = $this->productdisplayModel->getAllCategoriesAndSub();
		 $data['categories'] = $this->categories;
        $data['title'] = 'Contact Us';

        $data['product'] = $this->productdisplayModel->getAllProducts();
        $template = view('common/header',$data);
		$template.= view('contact');
        $template.= view('common/footer');
		$template.= view('pagescripts/contactjs');
        return $template;

        
    }
	public function submit()
{
    if ($this->request->isAJAX()) {
        $data = [
            'fullname'    => $this->request->getPost('fullname'),
            'email'       => $this->request->getPost('email'),
            'contact_no'  => $this->request->getPost('contact_no'),
            'message'     => $this->request->getPost('message'),
            'submitted_at'=> date('Y-m-d H:i:s'),
        ];

        $model = new ContactModel();
        $inserted = $model->insert($data);

        if (!$inserted) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to save contact enquiry.'
            ]);
        }

        $to = 'sandrakbabu23@gmail.com';
        $subject = 'New Contact Enquiry';

        $message =
            "New enquiry received:\n\n" .
            "Name: {$data['fullname']}\n" .
            "Email: {$data['email']}\n" .
            "Phone: {$data['contact_no']}\n" .
            "Message: {$data['message']}";

        $headers = "From: {$data['fullname']} <{$data['email']}>\r\n" .
                   "Reply-To: {$data['email']}\r\n" .
                   "MIME-Version: 1.0\r\n" .
                   "Content-Type: text/plain; charset=UTF-8\r\n" .
                   "X-Mailer: PHP/" . phpversion();

        // Send email and check result
        $mailSent = mail($to, $subject, $message, $headers);

        if ($mailSent) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Your enquiry has been sent successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to send email. Please try again later.'
            ]);
        }
    }

    // Not AJAX or invalid request
    return $this->response->setJSON([
        'status' => 'error',
        'message' => 'Invalid request.'
    ]);
}

}