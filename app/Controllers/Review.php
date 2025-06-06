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
    public function index() {
		$this->productdisplayModel = new ProductDisplayModel();
        $this->categories = $this->productdisplayModel->getAllCategoriesAndSub();
		$data['categories'] = $this->categories;
        $data['title'] = 'Review';

        $data['product'] = $this->productdisplayModel->getAllProducts();
        $model = new ReviewModel();
        $data['reviews'] = $model->where('is_approved', 1)->orderBy('created_at', 'DESC')->findAll();

        return view('common/header',$data)
             . view('review', $data)
             . view('common/footer')
			 .view('pagescripts/reviewjs');
    }

    public function submit() {
        if ($this->request->isAJAX()) {
            $model = new ReviewModel();
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'rating' => (int)$this->request->getPost('rating'),
                'review' => $this->request->getPost('review'),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $model->insert($data);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Thank you for your review!']);
        }
        return $this->response->setStatusCode(400)->setJSON(['status' => 'error']);
    }
}
