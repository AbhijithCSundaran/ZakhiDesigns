<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ReturnpolicyModel;

class ReturnAndRefundPolicy extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->request = \Config\Services::request();
    }

    public function index()
    {
        $template  = view('common/header');
        $template .= view('returnpolicy');
        $template .= view('common/footer');

        return $template;
    }
}
