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
                            <a href="<?= base_url('dashboard'); ?>"> <i class="fa fa-home"></i> </a>
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
                                <div class="card-block">
                                <div class="card">
                                            <div class="card-block table-border-style">
											<div id="message" style="display:none;"></div>
											<div id="messageBox" class="alert" style="display: none;"></div>
                                                <div class="table-responsive">
                                                    <table class="table table-hover" id="customerList">
                                                        <thead>
                                                            <tr>
                                                                <th>Sl.No.</th>
                                                                <th>Name</th>
																<th>Email</th>
																<th>Contact Number</th>
																<th>Status</th>
																<th>Action</th>
                                                            </tr>
                                                        </thead>
														 <tbody>
                                                       <?php
															$slno = 1;
															foreach ($user as $row) { ?>
																<tr>
																	<td><?= $slno++; ?></td>
																	<td><?= wordwrap(esc($row['cust_Name']), 20, '<br>'); ?></td>
																	<td><?= wordwrap(esc($row['cust_Email']), 20, '<br>') ;?> </td>
																	<td><?= wordwrap(esc($row['cust_Phone']), 20, '<br>') ;?> </td> 
																	<td>
																	 <div class="form-check form-switch">
                                                                    <input class="form-check-input checkactive"
                                                                        type="checkbox"
                                                                        id="statusSwitch-<?= $row['cust_Id']; ?>"
                                                                        value="<?= $row['cust_Id']; ?>"
                                                                        <?= ($row['cust_Status'] == 1) ? 'checked' : ''; ?>>
                                                                    <label class="form-check-label pl-0 label-check"
                                                                        for="statusSwitch-<?= $row['cust_Id']; ?>">
                                                                        
                                                                    </label>
                                                                </div>
																</td>
																	<td>
																	  <a href="<?= base_url('customer/location/' . $row['cust_Id']); ?>">
																		<i class="bi bi-geo-alt text-primary ms-2"></i>
																	  </a>&nbsp;
																		<a href="<?= base_url('customer/view/'. $row['cust_Id']); ?>">
																			<i class="bi bi-pencil-square"></i>
																		</a>   &nbsp;                                                  
																			<i class="bi bi-trash text-danger icon-clickable" onclick="confirmDelete(<?= $row['cust_Id']; ?>)"></i>
																	</td>                                                  
																</tr>
															<?php } ?>
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
                        <p class="text-center">
                            Are you sure you want to delete the Customer?</p>
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