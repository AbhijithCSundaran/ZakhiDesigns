<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Manage Customer</h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Customer</a>
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
                                                    <a href="<?= base_url('customer/view/'); ?>" class="btn btn-primary">
                                                        Add Customer
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
								<div class="card-block table-border-style">
								<div id="message" style="display:none;"></div>
								<div id="messageBox" class="alert" style="display: none;"></div>
								<?php foreach ($user as $row){ ?>
									 <div class="col-xl-4">
								<!-- Tooltip style 9 card start -->
											<div class="card o-visible">
												<div class="card-header">
													<h5><?= esc($row['cust_Name']); ?></h5>
												</div>
												<div class="card-block">
													<p><?= esc($row['add_Name']); ?> <br>
														<?= esc($row['add_BuldingNo']); ?> , <?= esc($row['add_Landmark']); ?><br>
														<?= esc($row['add_Street']); ?> , <?= esc($row['add_City']); ?><br>
														<?= esc($row['add_State']); ?> , <?= esc($row['add_Pincode']); ?><br>
														<?= esc($row['add_Phone']); ?>
														
													</p><a href="">Edit<span class="tooltip-content2"><i class="icofont icofont-bag-alt"></i></span></a>&nbsp;&nbsp;   |   &nbsp;&nbsp;
													<a href="#">Remove<span class="tooltip-content2"><i class="icofont icofont-bag-alt"></i></span></a>
												</div>
											</div>
											<!-- Tooltip style 9 card end -->
										</div>  
								<?php } 
								?>
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
                        <p class="text-center">
                            Are you sure you want to delete the Staff?</p>
                    </div>

                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="deleteStaff"
                    onclick="deleteStaff()">Delete</button>
            </div>
        </div>
    </div>
</div>
</div>