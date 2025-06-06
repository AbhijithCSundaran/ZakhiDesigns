<div class="row">
    <div class="text-center logo">
        <img class="img-align" src="<?php echo base_url().ASSET_PATH; ?>assets/images/logo.jpg" />
    </div>
    <h5 class="text-center">Login</h5>
</div>
<div id="loginError" class="text-danger text-center"></div>
<form id="loginForm" method="post">
    <div class="floating-label-group">
        <input type="email" class="form-control" id="email" name="cust_Email" placeholder=" " required />
        <label for="email">Enter the email address</label>
    </div>

    <div class="floating-label-group mb-1">
        <input type="password" class="form-control" id="password" name="cust_Password" placeholder=" " required />
        <label for="password">Enter your password</label>
    </div>
    <div class="row text-end">
        <a href="">Forgot Password?</a>
    </div>
    <div class="d-flex">
        <p> If you are a New Customer? </p>
        <a href="" class="ms-2"  id="showRegisterFromLogin">Register</a>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Login</button>
    </div>
</form>