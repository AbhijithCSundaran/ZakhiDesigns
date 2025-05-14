<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Product</h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Product</a>
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
                                            <div id="message" style="display:none;"></div>
                                            <div id="messageBox" class="alert" style="display: none;"></div>

                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex justify-content-end p-2">
                                                    <a href="<?= base_url('product/add'); ?>" class="btn btn-primary">
                                                        Add Product
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <div class="card">

                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table table-hover" id="productList">
                                                    <thead>
                                                        <tr>
                                                            <th>Slno</th>
                                                            <th>Product Name</th>
                                                            <th>MRP</th>
                                                            <th>Selling Price</th>
                                                            <!-- <th>Discount Type</th> -->
                                                            <th>Discount Value</th>
                                                            <th>Product Stock</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach($product as $index => $prod) : ?>
                                                        <tr>
                                                            <td><?= $index + 1; ?></td>
                                                            <td><?= ucwords($prod->pr_Name); ?></td>
                                                            <td><?= ucwords($prod->mrp); ?></td>
                                                            <td><?= $prod->pr_Selling_Price; ?></td>
                                                            <!-- <td><?= $prod->pr_Discount_Type; ?></td> -->
                                                            <td><?= $prod->pr_Discount_Value; ?></td>
                                                            <td><?= $prod->pr_Stock; ?></td>
                                                            <td>
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input checkactive"
                                                                        type="checkbox"
                                                                        id="statusSwitch-<?= $prod->pr_Id; ?>"
                                                                        value="<?= $prod->pr_Id; ?>"
                                                                        <?= ($prod->pr_Status == 1) ? 'checked' : ''; ?>>
                                                                    <label class="form-check-label pl-0 label-check"
                                                                        for="statusSwitch-<?= $prod->pr_Id; ?>">
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                 <a href="<?= base_url('product/edit/'. $prod->pr_Id); ?>">
																<i class="bi bi-pencil-square p-2"></i>
															</a> 

                                                                 <i class="bi bi-trash text-danger icon-clickable"
                                                                    onclick="confirmDelete(<?= $prod->pr_Id; ?>)">
                                                                </i>


                                                                <img class="img-size open-image-modal"
                                                                    src="<?php echo base_url().ASSET_PATH; ?>assets/images/image_add.ico"
                                                                    alt="Image-add"  data-toggle="modal" data-target="#exampleModal"
                                                                    data-product-id="<?= $prod->pr_Id; ?>"
                                                                    data-product-name="<?= $prod->pr_Name; ?>"
                                                                    onclick="openProductModal(<?= $prod->pr_Id ?>, '<?= $prod->pr_Name ?>')"
                                                                    style="cursor: pointer;">

                                                                  <img class="img-size open-video-modal"
                                                                    src="<?php echo base_url().ASSET_PATH; ?>assets/images/video_add.ico"
                                                                    alt="video-add"  data-toggle="modal" data-target="#videoModal"
                                                                    data-product-id="<?= $prod->pr_Id; ?>"
                                                                    data-product-name="<?= $prod->pr_Name; ?>"
                                                                    onclick="openvideoModal(<?= $prod->pr_Id ?>, '<?= $prod->pr_Name ?>')"
                                                                    style="cursor: pointer;">

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
