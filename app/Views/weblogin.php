<div class="row">
    <div class="text-center logo">
    <img class="img-align" src="<?php echo base_url().ASSET_PATH; ?>assets/images/logo.jpg" />
    </div>
     <h5 class="text-center">Sign in or create account </h5>
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
    </div >


   <div id="g_id_onload"
        data-client_id="89279377857-k55fvvqvtbk9nib9mc04jfsdgb9k00gn.apps.googleusercontent.com"
        data-context="signin"
        data-login_uri="https://v4cstaging.co.in/zakhidesigns/google-login-callback"
        data-auto_prompt="false">
    </div><br/>
 
    <div class="g_id_signin"
        data-type="standard"
        data-shape="rectangular"
        data-theme="outline"
        data-text="signin_with"
        data-size="large"
        data-logo_alignment="left">
    </div> 
   
    <div style="padding-bottom:8px;">
        <div class="d-flex justify-content-end" style="margin-bottom: 2px;">
            <a id="showForgotForm" class="forgot-style text-decoration-none"
                style="font-size: 14px; margin-top: 10px; ">Forgot Password?</a>
        </div>
        <div class="d-flex justify-content-end align-items-center" style="gap: 5px;">
            <p class="mb-0" style="font-size: 14px;">Don't have an account?</p>
            <a href="#" class="text-decoration-none" id="showRegisterFromLogin" style="font-size: 14px;">Register</a>
        </div>
        <div class="text-center mt-2 px-3">
            <small style="font-size: 13px; color: #6c757d;">
                By continuing, you agree to ZakhiDesigns
                <a href="<?= base_url('Termsandconditions'); ?>" class="text-decoration-none">Terms & Conditions</a> of
                Use and
                <a href="<?= base_url('Privacypolicy'); ?>" class="text-decoration-none">Privacy Policy</a> Notice.
            </small>
        </div>
    </div>


</div>


   
</form>
<!-- google sign  -->
    <script src="https://accounts.google.com/gsi/client" async defer></script>

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
  
 function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log("ID: " + profile.getId());
    console.log("Name: " + profile.getName());
    console.log("Email: " + profile.getEmail());

    // Optional: Send this data to server via AJAX
  }

</script>