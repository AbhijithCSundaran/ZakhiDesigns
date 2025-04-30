<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Category</h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Category</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-sm-12">

                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-7">

                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex justify-content-end p-2">
                                                    <a href="<?= base_url('category/add'); ?>" class="btn btn-primary">
                                                        Add Category
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="card">
                                        <!-- <div class="card-header">
                                               <div class="card-header-right">
                                                    <ul class="list-unstyled card-option">
                                                        <li><i class="fa fa fa-wrench open-card-option"></i></li>
                                                        <li><i class="fa fa-window-maximize full-card"></i></li>
                                                        <li><i class="fa fa-minus minimize-card"></i></li>
                                                        <li><i class="fa fa-refresh reload-card"></i></li>
                                                        <li><i class="fa fa-trash close-card"></i></li>
                                                    </ul>
                                                </div>
                                            </div> -->
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="categoryList">
                                                    <thead>
                                                        <tr>
                                                            <th>Slno</th>
                                                            <th>Category Name</th>
                                                            <th>Discount Value</th>
                                                            <th>Discount Type</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php foreach($category as $index => $cat) : ?>

                                                        <tr>
                                                            <td><?= $index + 1; ?></td>
                                                            <td><?= ucwords($cat['cat_Name']); ?></td>
                                                            <td><?= $cat['cat_Discount_Value']; ?></td>
                                                            <td><?= $cat['cat_Discount_Type']; ?></td>
                                                            <td>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input checkactive"
                                                                        type="checkbox"
                                                                        id="statusSwitch-<?= $cat['cat_Id']; ?>"
                                                                        value="<?= $cat['cat_Id']; ?>"
                                                                        <?= ($cat['cat_Status'] == 1) ? 'checked' : ''; ?>>
                                                                    <label class="form-check-label pl-0 label-check"
                                                                        for="statusSwitch-<?= $cat['cat_Id']; ?>">
                                                                        
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                            <i class="bi bi-pencil-square"></i>

                                                                <i class="bi bi-trash text-danger icon-clickable" data-toggle="modal"
                                                                data-target="#deleteModal"  onclick="confirmDelete(<?= $cat['cat_Id']; ?>)" 
                                                                   ></i>

                                                            </td>

                                                        </tr>


                                                        <?php endforeach; ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                <!-- Page-body end -->
            </div>
            <div id="styleSelector"> </div>
        </div>
    </div>
</div>

<!--Delete Modal-->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <img src="<?= base_url('public/assets/images/delete_icon.gif'); ?>" alt="Delete Icon"
                            class="img-fluid d-block mx-auto" style="width:100px;">
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-auto">
                        <p class="text-center">Your data will be lost.<br>
                            Are you sure you want to delete the Category?</p>
                    </div>

                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="deleteCategory"
                    onclick="deleteCategory()">Delete</button>
            </div>
        </div>
    </div>
</div>