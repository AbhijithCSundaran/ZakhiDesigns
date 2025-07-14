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
            'fullname'     => $this->request->getPost('fullname'),
            'email'        => $this->request->getPost('email'),
            'contact_no'   => $this->request->getPost('contact_no'),
            'message'      => $this->request->getPost('message'),
            'submitted_at' => date('Y-m-d H:i:s'),
        ];

        $model = new \App\Models\ContactModel();
        $inserted = $model->insert($data);

        if (!$inserted) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to save contact enquiry.'
            ]);
        }

        $emailService = \Config\Services::email();

        // === CONFIGURE SMTP (replace with actual details) ===
        $emailService->initialize([
            'protocol'    => 'smtp',
            'SMTPHost'    => 'smtp.sandrakbabu23@gmail.com',
            'SMTPUser'    => 'noreply@zakhidesigns.com',
            'SMTPPass'    => 'uthram123',
            'SMTPPort'    => 587,
            'SMTPTimeout'=> 5,
            'mailType'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
        ]);

        // === 1. Send mail to Admin ===
        $emailService->setFrom('noreply@zakhidesigns.com', 'Zakhi Designs Website');
        $emailService->setTo('sandrakbabu23@gmail.com');
        $emailService->setReplyTo($data['email'], $data['fullname']);

        $emailService->setSubject('New Contact Enquiry');

        $adminMessage = 
            "New enquiry received:<br><br>" .
            "<strong>Name:</strong> {$data['fullname']}<br>" .
            "<strong>Email:</strong> {$data['email']}<br>" .
            "<strong>Phone:</strong> {$data['contact_no']}<br>" .
            "<strong>Message:</strong><br>" . nl2br($data['message']);

        $emailService->setMessage($adminMessage);
        $emailService->send(); // Don't stop even if admin mail fails

        // === 2. Send automatic reply to user ===
        $emailService->clear(); // Reset email object for second email

        $emailService->setFrom('noreply@zakhidesigns.com', 'Zakhi Designs');
        $emailService->setTo($data['email']);
        $emailService->setSubject('Thank you for contacting Zakhi Designs');

        $userMessage = "
            <p>Dear <strong>{$data['fullname']}</strong>,</p>

            <p>Thank you for reaching out to Zakhi Designs. We’ve received your message and will get back to you as soon as possible.</p>

            <p style='text-align: center; font-size: 16px; margin-top: 20px;'>
                <strong>Thank you for purchasing with Zakhi Designs!</strong><br>
                We’re excited to prepare your order. Your item will be delivered in the next 5–7 business days.
            </p>

            <p style='text-align: center; margin-top: 20px;'>
                <a href='https://zakhidesigns.com' style='padding: 10px 20px; background-color: #d81b60; color: white; text-decoration: none; border-radius: 5px;'>Visit Our Website</a>
            </p>

            <p style='text-align: center; font-size: 14px; color: #555; margin-top: 30px;'>
                For any queries, reach us at <a href='mailto:support@zakhidesigns.com'>support@zakhidesigns.com</a>
            </p>

            <br><br>
            <p>Warm regards,<br>Zakhi Designs Team</p>
        ";

        $emailService->setMessage($userMessage);

        if ($emailService->send()) {
            return $this->response->setJSON([
                'status' => '1',
                'message' => 'Your enquiry has been sent successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => '0',
                'message' => 'Message saved but email could not be sent. Please try again later.'
            ]);
        }
    }

    return $this->response->setJSON([
        'status' => '0',
        'message' => 'Invalid request.'
    ]);
}

}