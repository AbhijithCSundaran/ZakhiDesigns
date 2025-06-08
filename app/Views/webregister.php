<div class="row">
    <div class="text-center logo ">
        <img class="img-align" src="<?php echo base_url() . ASSET_PATH; ?>assets/images/logo.jpg" />
    </div>
    <h5 class="text-center">Register</h5>
</div>
<div id="regError" class="text-danger text-center"></div>
<form id="registerForm" method="post">
    <div class="floating-label-group">
        <input type="text" class="form-control" id="name" name="custname" placeholder=" " required />
        <label for="name">Name</label>
    </div>

    <div class="floating-label-group">
        <input type="email" class="form-control" id="email" name="custemail" placeholder=" " required />
        <label for="email">Email</label>
    </div>

    <div class="floating-label-group">
        <input type="text" class="form-control" id="number" name="mobile" placeholder=" " required />
        <label for="number">Phone Number</label>
    </div>


    <div class="floating-label-group password-wrapper">
        <div class="password-input-wrapper">
            <input type="password" class="form-control" id="password" name="password" placeholder=" " required />
            <label for="password">Password</label>
            <i class="bi bi-eye toggle-password" id="toggleCurrentPassword"></i>
        </div>
    </div>

    <div class="floating-label-group password-wrapper">
        <div class="password-input-wrapper">
            <input type="password" class="form-control" id="cpassword" name="cust_cpassword" placeholder=" " required />
            <label for="cpassword">Confirm Password</label>
            <i class="bi bi-eye toggle-password" id="toggleConfirmPassword"></i>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Register</button>
    </div>
    <div class="d-flex mt-2">
        <p> Already have an account with us ? </p>
        <a href="" class="ms-2" id="showLoginFromRegister">Login</a>
    </div>

</form>

<script>
    function togglePassword(id, iconId) {
        const input = document.getElementById(id);
        const icon = document.getElementById(iconId);

        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }

    document.getElementById('toggleCurrentPassword').addEventListener('click', function () {
        togglePassword('password', 'toggleCurrentPassword');
    });

    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        togglePassword('cpassword', 'toggleConfirmPassword');
    });
</script>
