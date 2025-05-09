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
                                        
                                        <div id="messageBox" class="alert alert-success" style="display: none;"></div>
                                    </div>
                                </div>
                                <div class="card-block">
                                
                                    <form name="createProduct" id="createProduct" method="post">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Product Name <span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" name="product_name" id="productName" class="form-control"
                                                 placeholder="Enter the Product Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Product Code <span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="product_code" id="productCode"
                                                 placeholder="Enter the Product Code">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Product Description <span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                            <textarea rows="5" cols="5" class="form-control" name="product_description" id="productDes"
                                            placeholder=""></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Maximum Retail Price(MRP)<span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="mrp" id="mRp"
                                                 placeholder="Enter the MRP">
                                            </div>
                                        </div>
                                      <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Discount Type <span
                                                    style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <select class="form-control fs-13" name="discount_type"
                                                    id="discountType" required>
                                                    <option value="">-- Select Discount Type --</option>
                                                    <option value="%">
                                                        %</option>
                                                    <option value="Rs"
                                                       >
                                                        Rs</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Discount Value<span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="discount_value" id="discountValue"
                                                 placeholder="Enter the Discount value">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Selling Price<span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="selling_price" id="sellingPrice" readonly
                                                 placeholder="0">
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Category Name<span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
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
                                            <label class="col-sm-3 col-form-label">Subcategory Name<span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <select class="form-control fs-13" name="sub_id" id="subcategoryName"
                                                    required>
                                                    <option value="">-- Select Subcategory --</option>
                                                    <?php if (!empty($category)) : ?>
                                                    <?php foreach ($category as $cate): ?>
                                                    <option value="<?= esc($cate->sub_Id); ?>"
                                                        <?= (isset($subcategory) && $subcategory['sub_Id'] == $cate->sub_Id) ? 'selected' : ''; ?>>
                                                        <?= esc($cate->sub_Category_Name); ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                    <?php else : ?>
                                                    <option value="">No Subcategory Available</option>
                                                    <?php endif; ?>
 

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Product Stock<span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="product_stock" id="productStock"
                                                 placeholder="Enter the Product Stock">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Product Reset Stock<span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="reset_stock" id="resetStock"
                                                 placeholder="Enter the Product Reset Stock">
                                            </div>
                                        </div>
                                     <div class="row justify-content-center">
                                        <input type="hidden" name="pr_id">
                                            <div class="button-group">
                                                <button type="button" class="btn btn-secondary"
                                                onclick="window.location.href='<?= base_url('product'); ?>'">
                                                    <i class="bi bi-x-circle"></i> Discard
                                                </button>
                                                <button type="button" class="btn btn-primary" id="productSubmit" name="productSubmit">
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