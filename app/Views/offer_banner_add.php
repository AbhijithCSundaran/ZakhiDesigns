<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Add Home Banner</h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Add Home Banner</a>
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
                                    <form name="banner_add" id="banner_add" method="post" enctype="multipart/form-data">
                                       <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Banner File Name<span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" name="file_name" value="" id="fileName"
                                                 placeholder="Enter the Banner Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Upload the Image<span
                                            style="color: red;">*</span></label>
                                            <div class="col-sm-7">
                                                <input type="file" name="banner_image" id="banner_image" value="" class="form-control">
                                            <?php if (isset($banner) && !empty($banner['the_Home_Banner'])): ?>
												<img id="preview"
													 src="<?= base_url('/public/uploads/' . $banner['the_Home_Banner']); ?>"
													 alt="Image Preview"
													 style="max-height: 50px; margin-top: 10px; display: block;" />
											<?php else: ?>
												<img id="preview"
													 src="#"
													 alt="Image Preview"
													 style="max-height: 50px; margin-top: 10px; display: none;" />
											<?php endif; ?></div>
											
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
                                                </select>
                                                <small id="noSubcategoryMsg" class="text-danger" style="display: none;">
                                                    This category has no subcategory.
                                                </small>
                                            </div>

                                        </div>
										<div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Description</label>
                                            <div class="col-sm-7">
                                                <input type="text" class="form-control" value="" name="description" id="description"
                                                 placeholder="Enter the description">
                                            </div>
                                        </div>
                                        
                                        <div class="row justify-content-center">
                                            <input type="hidden" name="the_id" value="">
                                            <div class="button-group">
                                                <button type="button" class="btn btn-secondary"
                                                    onclick="window.location.href='<?= base_url('banner'); ?>'">
                                                    <i class="bi bi-x-circle"></i> Discard
                                                </button>
                                                <button type="button" class="btn btn-primary" id="imageSubmit"
                                                    name="imageSubmit">
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