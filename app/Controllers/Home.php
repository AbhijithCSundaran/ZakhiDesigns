<?php

namespace App\Controllers;

use App\Models\ProductDisplayModel;
use App\Models\Admin\Theme_Model;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Home extends BaseController
{
    protected $productdisplayModel;
    protected $categories;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        $this->productdisplayModel = new ProductDisplayModel();
        $this->categories = $this->productdisplayModel->getAllCategoriesAndSub();
    }

    public function index()
    {
        $data['categories'] = $this->categories;
        $data['title'] = 'Homepage';

        $data['product'] = $this->productdisplayModel->getAllProducts();

        $themeModel = new Theme_Model();
        $themes = $themeModel->fetchTheme();
        if (!empty($themes)) {
            $data['themes'] = $themes[0];
        }

        $template  = view('common/header', $data);
        $template .= view('banner');
        $template .= view('category', $data);
        $template .= view('top_products', $data);
        $template .= view('footer_banner', $data);
        $template .= view('common/footer', $data);

        return $template;
    }
}
