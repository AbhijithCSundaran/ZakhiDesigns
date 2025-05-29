<div class="row">
    <h5 class="text-center">Login</h5>
</div>
<div id="loginError" class="text-danger text-center p-3"></div>
<form id="loginForm" method="post">
    <div class="floating-label-group">
        <input type="email" class="form-control" id="email" name="cust_Email" placeholder=" " required />
        <label for="email">Enter the email address</label>
    </div>

    <div class="floating-label-group">
        <input type="password" class="form-control" id="password" name="cust_Password" placeholder=" " required />
        <label for="password">Enter your password</label>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
