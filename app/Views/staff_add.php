<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Add User</h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="index.html"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Add User</a>
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
                                        <div class="col-md-2">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex justify-content-end p-2">
                                                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-block">
                                    <form name="createstaff" id="createstaff">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="staffname" id="staffname" class="form-control"
                                                    placeholder="Enter the staff name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="staffemail" id="staffemail"
                                                    placeholder="Enter the mail id">
                                            </div>
                                        </div>
										 <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Alternate Email</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="staffotemail" id="staffotemail"
                                                    placeholder="Enter alternate mailid">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" name="password" id="password" placeholder="Password">
                                            </div>
                                        </div>
										
                                        <div class="row justify-content-center">
										<input type="hidden" name="us_id" value="<?php echo (isset($us_id) && $us_id!="" ? $us_id : 0); ?>" />
                                            <div class="button-group">
                                                <button type="button" class="btn btn-secondary">
												  <a href="<?= base_url('staff'); ?>"> 
                                                   
                                                    <i class="bi bi-x-circle"></i> Discard
													</a>
                                                </button>
                                                <button type="button" class="btn btn-primary" id="staffSubmit" name="staffSubmit">
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