<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css"/>


<style>
    #password-strength-bar {
        border-radius: 5px;
    }
 
    #password-strength-fill {
        transition: width 0.3s ease;
    }
 
    #password-strength-text {
        font-weight: bold;
        transition: color 0.3s ease;
    }
 
    .progress .progress-bar {
        height: 100%
    }
</style>
<div class="row">
    <div class="text-center logo ">
        <a href="">
        <img class="img-align" src="<?php echo base_url() . ASSET_PATH; ?>assets/images/logo.jpg" />
        </a>
    </div>
    <h5 class="text-center" style="margin-top: 5px;">Your Fashion Journey Starts Here  </h5>
</div>
<div id="regError" class="text-danger text-center p-2" style="color:red;"></div>
<form id="registerForm" method="post">
    <div class="floating-label-group">
        <input type="text" class="form-control" id="name" name="custname" placeholder="" required />
        <label for="name">Name</label>
    </div>

    <div class="floating-label-group">
        <input type="email" class="form-control" id="email" name="custemail" placeholder="" required />
        <label for="email">Email</label>
    </div>

    <!-- <div class="floating-label-group phn_code">
       <input type="tel" class="form-control" id="phn_number" name="mobile" placeholder=""
    maxlength="15" minlength="7" required pattern="^\+?\d{7,20}$"
    oninvalid="this.setCustomValidity('Phone Number must be at least 7 digits in valid format.')"
    oninput="this.setCustomValidity('')" /> -->

        <!-- <label for="phn_number">Phone Number</label> -->
    <!-- </div> -->


    <!-- <div class="floating-label-group password-wrapper">
        <div class="password-input-wrapper">
            <input type="password" class="form-control" id="password" name="password" placeholder=" " required />
            <label for="password">Password</label>
            <i class="bi bi-eye-slash toggle-password" id="toggleCurrentPassword"></i>
        </div>
    </div> -->
<!-- <div class="floating-label-group" style="width: 100%;">
 <input type="tel" id="phone" class="form-control" name="cust_Phone" placeholder="81234 56789" required>
<input type="hidden" name="phcode" id="phcode">
<small id="phone-valid-msg" class="text-success d-none">Valid</small>
<small id="phone-error-msg" class="text-danger d-none">Invalid</small>

</div> -->

<input type="hidden" name="phcode" id="phcode">


    <div class="floating-label-group password-wrapper">
        <div class="password-input-wrapper">
            <input type="password" class="form-control" id="password" name="password" placeholder=" " required
                maxlength="15" />
            <label for="password">Password</label>
            <i class="bi bi-eye-slash toggle-password" id="toggleCurrentPassword"></i>
        </div>
    </div>
    <div class="progress mt-2" id="password-strength-bar" style="height: 8px; display: none;">
        <div class="progress-bar" role="progressbar" style="width: 0%;" id="password-strength-fill"></div>
    </div>
    <small id="password-strength-text" class="fw-bold"></small>
    <div>&nbsp;</div>

    <div class="floating-label-group password-wrapper">
        <div class="password-input-wrapper">
            <input type="password" class="form-control" id="cpassword" name="cust_cpassword" max-length="15" placeholder=" " required />
            <label for="cpassword">Confirm Password</label>
            <i class="bi bi-eye-slash toggle-password" id="toggleConfirmPassword"></i>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary">Create Now</button>
    </div>
    <div class="d-flex mt-2">
        <p class="mb-0">Already have an account with us?</p>
        <a href="#" class="ms-2 text-decoration-none" id="showLoginFromRegister" style="text-decoration:none">Login</a>
    </div>
    <div class="text-center mt-2 px-3">
        <small style="font-size: 13px; color: #6c757d;">
            By continuing, you agree to ZakhiDesigns
            <a href="Termsandconditions" class="text-decoration-none">Terms & Conditions</a> of Use and
            <a href="Privacypolicy" class="text-decoration-none"> Privacy Policy </a> Notice.
        </small>
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
    
let iti = null;

$(document).ready(function () {

    // Submit Handler
  $(document).on('submit', '#registerForm', function (e) {
    e.preventDefault();
    $('#regError').stop(true, true).hide().removeClass('text-danger text-success').html('');

    const password = $('#password').val().trim();
    const cpassword = $('#cpassword').val().trim();
    const email = $('#email').val().trim();
    const name = $('#name').val().trim();

    // Validate email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError('Please enter a valid email address.');
        return;
    }

    // Validate passwords
    if (password !== cpassword) {
        showError('Passwords do not match.');
        return;
    }

    // Submit via AJAX
    $.ajax({
        url: '<?= base_url('admin/customer/save') ?>',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function (response) {
            if (response.status === 1) {
                $('#regError').removeClass('text-danger').addClass('text-success').html(response.msg).fadeIn();
                $('#registerForm')[0].reset();

                setTimeout(() => $('#registerModal').modal('hide'), 1000);
                setTimeout(() => {
                    $('#regError').fadeOut('slow', function () {
                        $(this).removeClass('text-success').html('').show();
                    });
                }, 3000);
            } else {
                showError(response.msg);
            }
        },
        error: function () {
            showError('An error occurred. Please try again.');
        }
    });
});

    function showError(message) {
        $('#regError')
            .removeClass('text-success')
            .addClass('text-danger')
            .html(message)
            .fadeIn();

        setTimeout(() => {
            $('#regError').fadeOut('slow', function () {
                $(this).removeClass('text-danger').html('').show();
            });
        }, 3000);
    }
});

</script>
<script>
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthFill = document.getElementById('password-strength-fill');
    const strengthText = document.getElementById('password-strength-text');

    $(document).on('input', '#password', function () {
    const value = this.value;
    const result = calculatePasswordStrength(value);

    if (value.length > 0) {
        $('#password-strength-bar').show();
        $('#password-strength-fill')
            .css('width', result.percent + '%')
            .removeClass()
            .addClass('progress-bar bg-' + result.color);

        $('#password-strength-text')
            .text(result.label)
            .css('color', getTextColor(result.color));
    } else {
        $('#password-strength-bar').hide();
        $('#password-strength-fill').css('width', '0%');
        $('#password-strength-text').text('').css('color', '');
    }
});
$('#registerModal').on('hidden.bs.modal', function () {
    $('#password-strength-bar').hide();
    $('#password-strength-fill').css('width', '0%').removeClass();
    $('#password-strength-text').text('');
});

 
    function calculatePasswordStrength(password) {
        let score = 0;
 
        if (password.length >= 8) score++;                  // ✔️ Proper length
        if (/[A-Z]/.test(password)) score++;                // ✔️ Uppercase
        if (/[a-z]/.test(password)) score++;                // ✔️ Lowercase
        if (/\d/.test(password)) score++;                   // ✔️ Number
        if (/[^A-Za-z0-9]/.test(password)) score++;         // ✔️ Special character
 
        switch (score) {
            case 0:
            case 1:
                return { percent: 20, color: 'danger', label: 'Very Weak' };
            case 2:
                return { percent: 40, color: 'warning', label: 'Weak' };
            case 3:
                return { percent: 60, color: 'info', label: 'Moderate' };
            case 4:
                return { percent: 80, color: 'primary', label: 'Strong' };
            case 5:
                return { percent: 100, color: 'success', label: 'Very Strong' };
            default:
                return { percent: 0, color: 'secondary', label: '' };
        }
    }
 
 
    // Match Bootstrap contextual colors to text hex codes
    function getTextColor(color) {
        switch (color) {
            case 'danger': return '#dc3545';   // red
            case 'warning': return '#ffc107';  // yellow
            case 'info': return '#17a2b8';     // light blue
            case 'primary': return '#007bff';  // blue
            case 'success': return '#28a745';  // green
            default: return '#6c757d';         // gray (secondary)
        }
    }
    

    $('#registerModal').on('shown.bs.modal', function () {
    const value = passwordInput.value;
    if (value.length > 0) {
        strengthBar.style.display = 'block';
        const result = calculatePasswordStrength(value);

        strengthFill.style.width = result.percent + '%';
        strengthFill.className = 'progress-bar bg-' + result.color;
        strengthText.innerText = result.label;
        strengthText.style.color = getTextColor(result.color);
    } else {
        strengthBar.style.display = 'none';
        strengthText.innerText = '';
        strengthText.style.color = '';
    }
});

</script>



