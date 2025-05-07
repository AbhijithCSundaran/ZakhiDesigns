<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Add Products</h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Add Product</a>
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
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-7">
                                        <div id="messageBox" class="alert alert-success" style="display: none;"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex justify-content-end p-2">
                                                    <a href="<?= base_url('product'); ?>" class="btn btn-primary"> Back
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                
                                    <form name="createCategory" id="createCategory" method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Category Name <span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" name="category_name" id="categoryName" class="form-control"
                                                 placeholder="Enter the Category name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Discount Value <span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="discount_value" id="discountValue"
                                                 placeholder="Enter the Discount value">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Discount Type <span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="discount_type" id="discountType" 
                                                 
                                                placeholder="Discount Type">
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                        <input type="hidden" name="cat_id"
                                        >
                                            <div class="button-group">
                                                <button type="button" class="btn btn-secondary"
                                                onclick="window.location.href='<?= base_url('product'); ?>'">
                                                    <i class="bi bi-x-circle"></i> Discard
                                                </button>
                                                <button type="button" class="btn btn-primary" id="categorySubmit" name="categorySubmit">
                                                    <i class="bi bi-check-circle"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                     </form>


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