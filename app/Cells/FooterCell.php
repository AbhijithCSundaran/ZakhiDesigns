<?php namespace App\Cells;

use CodeIgniter\View\Cells\Cell;
use App\Models\AdminUserModel;

class FooterCell extends Cell
{
    public function storeInfo()
    {
        $userModel = new AdminUserModel();

        // Fetch store contact user (use correct us_Id, e.g., 1)
        $user = $userModel->find(1); // or dynamic if needed

        return view('common/store_info', ['user' => $user]);
    }
}
