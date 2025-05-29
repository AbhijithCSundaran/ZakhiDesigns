<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Manage Profile</h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/profile'); ?>"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#">Profile</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
	
         <!-- Flash Message Start -->
		 
        <?php 
		if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php 
		
		endif;
		?>

        <?php 
		if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php 
		endif; 
		?>
        <!-- Flash Message End -->

    <!-- Profile Form Start -->
    <div class="main-body">
        <div class="page-wrapper">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
    <div class="card-header"><h5>Edit Profile</h5></div>
    <div class="card-block">
        

        <form method="post" action="<?= base_url('admin/profile/update'); ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="us_Name" class="form-control" value="<?= $user['us_Name']; ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="us_Email" class="form-control" value="<?= esc($user['us_Email'] ?? '') ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</div>
</div>

			<!-- Change Password -->
			<div class="col-sm-6">
				<div class="card">
					<div class="card-header"><h5>Change Password</h5></div>
					<div class="card-block">
						<form method="post" action="<?= base_url('admin/profile/change_password'); ?>">
							<div class="form-group">
								<label>Current Password</label>
								<input type="password" name="current_password" id="current_password" class="form-control" required>
							</div>
							<div class="form-group">
								<label>New Password</label>
								<input type="password" name="new_password"  id="new_password" class="form-control" required>
							</div>
							<div class="form-group">
								<label>Confirm New Password</label>
								<input type="password" name="confirm_password"  id="new_password" class="form-control" required>
							</div>
							<button type="submit" class="btn btn-warning">Change Password</button>
						</form>
					</div>
				</div>
			</div>
			<!-- End Change Password -->
		</div>
	</div>
</div>
</div>



