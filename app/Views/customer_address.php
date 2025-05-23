
<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Manage Customer Address</h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="#"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Customer Address</a>
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
					<?php if (!empty($user)) : ?>
						<h5>Delivery Address By <?= esc($user[0]['cust_Name']); ?></h5>
					<?php endif; ?>
				  <div class="row">	
				  <div class="col-xl-4">
						
							<!-- Tooltip style 2 card start -->
							<div class="card o-visible">
								<div class="card-header">
									
								</div>
								<div class="card-block">
								
									<p>
									</p>
										<div class="card-block d-flex justify-content-center align-items-center" style="height: 140px;">
											<a href="<?= base_url('customer_address/view/' . $add_CustId); ?>" class="btn btn-outline-primary">
												<i class="fa fa-plus"></i> Add Address
											</a>
										</div>
										
									</div>
								</div>
								
								<!-- Tooltip style 2 card end -->
						</div>
				  <?php foreach ($user as $rows){ ?>
						<div class="col-xl-4">
						
							<!-- Tooltip style 2 card start -->
							<div class="card o-visible">
								<div class="card-header">
									<h5><?= esc($rows['add_Name']); ?></h5>
								</div>
								<div class="card-block">
									<p><?= esc($rows['add_Name']); ?> <br>
										<?= esc($rows['add_BuldingNo']); ?> , <?= esc($rows['add_Landmark']); ?><br>
										<?= esc($rows['add_Street']); ?> , <?= esc($rows['add_City']); ?><br>
										<?= esc($rows['add_State']); ?> , <?= esc($rows['add_Pincode']); ?><br>
										<?= esc($rows['add_Phone']); ?>
									</p>
									<input type="hidden" name="cust_id" value=<?= esc($rows['add_CustId']);?>>
												<a href="<?= base_url('customer_address/view/' . esc($rows['cust_Id']) . '/' . esc($rows['add_Id'])); ?>">
												<i class="bi bi-pencil-square"></i></a>
												<i class="icofont icofont-bag-alt"></i></span></a>&nbsp;&nbsp;   |   &nbsp;&nbsp;
												<i class="bi bi-trash text-danger icon-clickable" onclick="confirmDelete(<?= $rows['add_Id']; ?>)"></i>
									</div>
								</div>
								
								<!-- Tooltip style 2 card end -->
						</div>
							<?php } 
								?>
					</div>
				</div>
            </div>
                <!-- Page-body end -->
        </div>
            <div id="styleSelector"> </div>
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
                            Are you sure you want to delete the Address?</p>
                    </div>

                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="deleteaddress"
                    onclick="deleteAddress()">Delete</button>
            </div>
        </div>
    </div>
</div>
</div>