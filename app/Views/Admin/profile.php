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
                <div class="col-md-4" style="display: none;">
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
	
      

    <!-- Profile Form Start -->
    <div class="main-body">
        <div class="page-wrapper">
            <div class="row">
                <div class="col-sm-6">
                  <div class="card">
					<div class="card-header"><h5>Edit Profile</h5></div>
					  <div class="card-block">
						<?php if (session()->getFlashdata('success')): ?>
							<div class="alert alert-success" id="tog-alert"><?= session()->getFlashdata('success') ?></div>
						<?php elseif (session()->getFlashdata('error')): ?>
							<div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
						<?php endif; ?>

					  <form method="post" action="<?= base_url('admin/profile/update'); ?>">
						<div class="form-group">
							<label>Name</label>
							 <input type="text" name="us_Name" class="form-control" value="<?= $user['us_Name']; ?>" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="us_Email" class="form-control" value="<?= esc($user['us_Email'] ?? '') ?>" required>
						</div>
						<button type="submit" class="btn btn-primary">Update Profile</button>
					</form>
              </div>
          </div>
    </div>

<!-- Change Password -->
<div class="col-sm-6">
  <div class="card">
	<div class="card-header">
	  <h5>Change Password</h5>
	</div>
			<div class="card-block">
			<div class="alert alert-danger" style="display:none" id="passAlert"></div>
			  <form id="changePasswordForm" name="changePasswordForm">

				<div class="form-group" style="position: relative;">
				  <label>Current Password</label>
				  <input type="password" id="current_password" name="current_password" class="form-control" placeholder="Current Password">
				  <i class="fa fa-eye" id="toggleCurrentPassword" style="position: absolute; top: 70%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
				</div>

					<div class="form-group" style="position: relative;">
					  <label>New Password</label>
					  <input type="password" name="new_password" id="new_password" class="form-control" placeholder="New Password" required>
					  <i class="fa fa-eye" id="toggleNewPassword" style="position: absolute; top: 70%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
					</div>

				<div class="form-group" style="position: relative;">
				  <label>Confirm New Password</label>
				  <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm New Password" required>
				  <i class="fa fa-eye" id="toggleConfirmPassword" style="position: absolute; top: 70%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
				</div>

					<button type="submit" id="passUpdate" class="btn btn-primary">Change Password</button>
				  </form>
				</div>
			  </div>
			</div>

			<!-- End Change Password -->
		</div>
	</div>
</div>
</div>



