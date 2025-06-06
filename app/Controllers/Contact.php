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
	public function submit() {
		if ($this->request->isAJAX()) {
			$data = [
				'fullname' => $this->request->getPost('fullname'),
				'email' => $this->request->getPost('email'),
				'contact_no' => $this->request->getPost('contact_no'),
				'message' => $this->request->getPost('message'),
				'submitted_at' => date('Y-m-d H:i:s'),
			];

			$model = new ContactModel();
			$model->insert($data);

			// Send Email
			$email = \Config\Services::email();
			$email->setTo('sandra@smartlounge.online');
			$email->setFrom($data['email'], $data['fullname']);
			$email->setSubject('New Contact Enquiry');
			$email->setMessage(
				"New enquiry received:\n\n".
				"Name: {$data['fullname']}\n".
				"Email: {$data['email']}\n".
				"Phone: {$data['contact_no']}\n".
				"Message: {$data['message']}"
			);

			if ($email->send()) {
				return $this->response->setJSON(['status' => 'success', 'message' => 'Enquiry submitted successfully.']);
			} else {
				return $this->response->setJSON(['status' => 'error', 'message' => 'Email sending failed.']);
			}
		}

		return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid request']);
	}
}