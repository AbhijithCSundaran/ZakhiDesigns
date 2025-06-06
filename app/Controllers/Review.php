<?php
namespace App\Controllers;
use App\Models\ReviewModel;
use App\Models\ProductDisplayModel;

class Review extends BaseController {
	protected $productdisplayModel;
    protected $categories;
	
	public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->input = \Config\Services::request();
    }
   public function index($prId)
{
	if (!$this->session->get('zd_uid')) {
        return redirect()->to(base_url());
    }
	$cust_Id =  $this->session->get('zd_uid');
    $productModel = new \App\Models\ProductDisplayModel();
    $reviewModel = new \App\Models\ReviewModel();

    $product = $productModel->find($prId);

    if (!$product) {
        return redirect()->to('/')->with('error', 'Product not found');
    }

    $reviews = $reviewModel->where('pr_Id', $prId)->orderBy('created_at', 'DESC')->findAll();

    return view('common/header')
        . view('review', [
            'product' => $product,
            'reviews' => $reviews
        ])
        . view('common/footer')
		.view('pagescripts/reviewjs');
}

public function submit()
{
    $session = session();
    $custId = $session->get('zd_uid'); // Get customer ID from session

    if (!$custId) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'You must be logged in to submit a review.'
        ]);
    }

    $request = service('request');

    $data = [
        'pr_Id'     => $request->getPost('pr_Id'),
        'cust_Id'   => $custId,
        'name'      => $request->getPost('name'),
        'email'     => $request->getPost('email'),
        'rating'    => $request->getPost('rating'),
        'review'    => $request->getPost('review'),
        'created_at' => date('Y-m-d H:i:s')
    ];

    $validation = \Config\Services::validation();
    $validation->setRules([
        'name'   => 'required',
        'email'  => 'required|valid_email',
        'rating' => 'required|in_list[1,2,3,4,5]',
        'review' => 'required'
    ]);

    if (!$validation->run($data)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => $validation->getErrors()
        ]);
    }

    $reviewModel = new \App\Models\ReviewModel();
    $reviewModel->insert($data);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Review submitted successfully.'
    ]);
}
}
