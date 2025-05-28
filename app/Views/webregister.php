<div class="row">
    <h5 class="text-center">Register</h5>
</div>
<div id="regError" class="text-danger text-center p-3"></div>
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

<div class="floating-label-group">
    <input type="password" class="form-control" id="password" name="password" placeholder=" " required />
    <label for="password">Password</label>
</div>

<div class="floating-label-group">
    <input type="password" class="form-control" id="cpassword" name="cust_cpassword" placeholder=" " required />
    <label for="cpassword">Confirm Password</label>
</div>
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
