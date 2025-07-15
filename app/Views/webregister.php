<div class="row">
    <div class="text-center logo ">
        <a href="">
        <img class="img-align" src="<?php echo base_url() . ASSET_PATH; ?>assets/images/logo.jpg" />
        </a>
    </div>
    <h5 class="text-center">Your Fashion Journey Starts Here  </h5>
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

    <div class="floating-label-group phn_code">
        <input type="tel" class="form-control" id="phn_number" name="mobile" placeholder="" maxlength="15" minlength="7" required pattern="^\d{7,20}$"
            oninvalid="this.setCustomValidity('Phone Number Must Be Minimum of 7 Digits.')"
            oninput="this.setCustomValidity('')" />
        <!-- <label for="phn_number">Phone Number</label> -->
    </div>


    <div class="floating-label-group password-wrapper">
        <div class="password-input-wrapper">
            <input type="password" class="form-control" id="password" name="password" placeholder=" " required />
            <label for="password">Password</label>
            <i class="bi bi-eye-slash toggle-password" id="toggleCurrentPassword"></i>
        </div>
    </div>

    <div class="floating-label-group password-wrapper">
        <div class="password-input-wrapper">
            <input type="password" class="form-control" id="cpassword" name="cust_cpassword" placeholder=" " required />
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
<style>
    .iti.iti--allow-dropdown.iti--separate-dial-code label {
        margin-left: 35px;
    }
</style>

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
    $(document).ready(function () {
        const phoneInput = document.querySelector("#phn_number");
        if (phoneInput) {
            iti = window.intlTelInput(phoneInput, {
                separateDialCode: true,
                initialCountry: "in",
                nationalMode: false,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
            });
            // debugger;
            // const label = $('label[for="phn_number"]');
            const label = '<label for="phn_number">Phone Number</label>';
            const itiWrapper = $(phoneInput).closest('.iti');
            if (itiWrapper.length && label.length) {
                itiWrapper.append(label); // move label to same level
                // itiWrapper.parent().append(label); // move label to same level
            }
            setTimeout(() => {
                $(phoneInput).attr('placeholder', '')
            }, 10);
        }
    });
    $(document).ready(function () {
        $('#phn_number').on('input', function () {
            const sanitized = $(this).val().replace(/[^\d\s-]/g, '');
            $(this).val(sanitized);
        });
 
        $('#phn_number').on('paste', function (e) {
            const pastedData = e.originalEvent.clipboardData.getData('text');
            if (!/^[\d\s-]+$/.test(pastedData)) {
                e.preventDefault();
            }
        });
    });
    $(document).ready(function () {
        // Register form submission (delegated)
        $(document).on('submit', '#registerForm', function (e) {
            e.preventDefault();
 
            $('#regError').html(''); // clear previous messages
 
            const password = $('#password').val();
            const cpassword = $('#cpassword').val();
            const email = $('#email').val();
            const name = $('#name').val();
            const phone = iti.getNumber(); // get full international number like +919876543210
            const nationalPhone = iti.getNumber(intlTelInputUtils.numberFormat.NATIONAL); // e.g., 9876543210
 
            // Validate password match
            if (password !== cpassword) {
                $('#regError').html('Passwords do not match.');
                return;
            }
 
            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                $('#regError').html('Please enter a valid email address.');
                return;
            }
 
            // Validate phone number (international format with +)
            if (!/^\+\d{7,20}$/.test(phone)) {
                $('#regError').html('Phone Number Must Be Minimum of 7 Digits.');
                return;
            }
 
            // Validate name
            const nameRegex = /^[a-zA-Z ]+$/;
            if (!nameRegex.test(name)) {
                $('#regError').html('Name Must Contain Only Letters And Spaces.');
                return;
            }
 
            // Manually set the full number in form (if needed)
            $('#phn_number').val(phone); // updates hidden input value for form serialization
 
            // Submit via AJAX
            $.ajax({
                url: '<?= base_url('admin/customer/save') ?>',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response.status === 1) {
                        $('#regError')
                            .removeClass('text-danger')
                            .addClass('text-success')
                            .html(response.msg)
                            .fadeIn(); // make sure it's visible
 
                        $('#registerForm')[0].reset();
 
                        setTimeout(function () {
                            $('#registerModal').modal('hide');
                        }, 1000);
 
                        // Fade out the message after 3 seconds and remove success class
                        setTimeout(function () {
                            $('#regError').fadeOut('slow', function () {
                                $(this).removeClass('text-success').html('').show(); // Reset content and show again if needed later
                            });
                        }, 3000);
 
                    } else {
                        $('#regError')
                            .removeClass('text-success')
                            .addClass('text-danger')
                            .html(response.msg)
                            .fadeIn(); // ensure error is visible
                    }
 
                },
                error: function () {
                    $('#regError').removeClass('text-success').addClass('text-danger').html('An error occurred. Please try again.');
                }
            });
        });
    });
 
</script>
