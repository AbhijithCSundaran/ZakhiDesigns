<div class="row">
    <div class="text-center logo">
    <img class="img-align" src="<?php echo base_url().ASSET_PATH; ?>assets/images/logo.jpg" />
    </div>
     <h5 class="text-center">Login </h5>
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

   <div id="g_id_onload"
        data-client_id="YOUR_GOOGLE_CLIENT_ID"
        data-context="signin"
        data-login_uri="https://v4cstaging.co.in/google-login-callback.php"
        data-auto_prompt="false">
    </div>
 
    <div class="g_id_signin"
        data-type="standard"
        data-shape="rectangular"
        data-theme="outline"
        data-text="signin_with"
        data-size="large"
        data-logo_alignment="left">
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
  
 function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log("ID: " + profile.getId());
    console.log("Name: " + profile.getName());
    console.log("Email: " + profile.getEmail());

    // Optional: Send this data to server via AJAX
  }

</script>