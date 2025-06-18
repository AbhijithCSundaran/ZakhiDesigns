<div class="row">
    <div class="text-center logo">
        <img class="img-align" src="<?php echo base_url().ASSET_PATH; ?>assets/images/logo.jpg" />
    </div>
    <!-- <h5 class="text-center">Login</h5> -->
</div>
<div id="loginError" class="text-danger text-center" style="padding:6px;"></div>
<form id="loginForm" method="post">
    <div class="floating-label-group">
        <input type="email" class="form-control" id="email" name="cust_Email" placeholder=" " required />
        <label for="email">Enter the email address</label>
    </div>

   <div class="floating-label-group password-wrapper">
        <div class="password-input-wrapper">
             <input type="password" class="form-control" id="password" name="cust_Password" placeholder=" " required />
         <label for="password">Enter your password</label>
         <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
        </div>
    </div>


     <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>

    
    <div class="or-divider"><hr/><span>OR</span><hr/></div>
    <div class="d-flex" style="padding-bottom:8px;">
        <a id="showForgotForm" class="forgot-style">Forgot Password?</a> 
        <div class="d-flex ms-auto" >
            <p class="mb-0"> Don't have an acount? </p>
            <a href="" class="ms-2"  id="showRegisterFromLogin">Register</a>
        </div>
    </div>

   
</form>
<script>
    $(document).ready(function() {
        $('#togglePassword').on('click', function () {
            const passwordField = $('#password');
            const icon = $(this);
            
            // Toggle input type
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);

            // Toggle icon class
            icon.toggleClass('bi-eye bi-eye-slash');
        });
    });
</script>