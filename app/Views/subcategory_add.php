<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Add Subcategory</h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Add Subcategory</a>
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

                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex justify-content-end p-2">
                                                    <a href="<?= base_url('subcategory'); ?>" class="btn btn-primary">
                                                        Back
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form name="createSubcategory" id="createSubcategory" method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Category Name</label>
                                            <div class="col-sm-6">
                                                <select class="form-control fs-13" name="cat_id" id="categoryName"
                                                    required>
                                                    <option value="">-- Select Category --</option>
                                                    <?php if (!empty($category)) : ?>
                                                    <?php foreach ($category as $cate): ?>
                                                    <option value="<?= esc($cate->cat_Id); ?>"
                                                        <?= (isset($subcategory) && $subcategory['cat_Id'] == $cate->cat_Id) ? 'selected' : ''; ?>>
                                                        <?= esc($cate->cat_Name); ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                    <?php else : ?>
                                                    <option value="">No Category Available</option>
                                                    <?php endif; ?>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Subcategory Name</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="subcategory_name" id="subcatName"
                                                    class="form-control"
                                                    value="<?= isset($subcategory) ? ($subcategory['sub_Category_Name']) : '' ?>"
                                                    placeholder="Enter the Subcategory name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Discount Value</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="discount_value"
                                                    id="discountValue"
                                                    value="<?= isset($subcategory) ? ($subcategory['sub_Discount_Value']) : '' ?>"
                                                    placeholder="Enter the Discount value">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Discount Type</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="discount_type"
                                                    id="discountType"
                                                    value="<?= isset($subcategory) ? ($subcategory['sub_Discount_Type']) : '' ?>"
                                                    placeholder="Discount Type">
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <input type="hidden" name="sub_id"
                                                value="<?= isset($subcategory) ? ($subcategory['sub_Id']) : '' ?>">
                                            <div class="button-group">
                                                <button type="button" class="btn btn-secondary">
                                                    <i class="bi bi-x-circle"></i> Discard
                                                </button>
                                                <button type="button" class="btn btn-success" id="subcategorySubmit"
                                                    name="subcategorySubmit">
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