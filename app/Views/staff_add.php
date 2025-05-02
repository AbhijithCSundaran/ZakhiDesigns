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
                            <a href="<?php echo base_url('dashboard') ?>"> <i class="fa fa-home"></i> </a>
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
								<div id="messageBox" class="alert alert-success" style="display: none;"></div>
								
                                    <form name="createstaff" id="createstaff" method="post">
									
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="staffname" id="staffname" class="form-control"
                                                    value="<?= isset($staff) ? ($staff['us_Name']) : '' ?>" placeholder="Enter the staff name" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-6">
                                                <input type="email" class="form-control" name="staffemail" id="staffemail"
                                                  value="<?= isset($staff) ? esc($staff['us_Email']) : '' ?>"   placeholder="Enter the mail id" required>
                                            </div>
                                        </div>
										 <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Alternate Email</label>
                                            <div class="col-sm-6">
                                                <input type="email" class="form-control" name="staffotemail" id="staffotemail"
                                                  value="<?= isset($staff) ? ($staff['us_Email2']) : '' ?>"   placeholder="Enter alternate mailid" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-6">
                                                <input type="Password" class="form-control" name="password" id="password"value="<?= isset($staff) ? ($staff['us_Password']) : '' ?>"  placeholder="Password" required>
                                            </div>
                                        </div>
										
                                        <div class="row justify-content-center">
										<input type="hidden" name="us_id" value="<?= isset($staff['us_Id']) ? esc($staff['us_Id']) : '' ?>">
                                            <div class="button-group">
											 <button type="button" class="btn btn-secondary" onclick="window.location.href='<?= base_url('staff'); ?>'">
                                                    <i class="bi bi-x-circle"></i> Discard
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