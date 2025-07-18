<footer>

    <div class="container-lg">
        <div class="row">
            <div class="col-md-3">
                <h4>Your Account<h4>
                        <ul>
                            <li><i class="bi bi-arrow-right"></i>
                                <a href="<?= base_url('profile#profile'); ?>" class="foot-link login-check">Profile</a>
                            </li>
                            <li><i class="bi bi-arrow-right"></i>
                                <a href="<?= base_url('profile#orders'); ?>" class="foot-link login-check">My Orders</a>
                            </li>
                            <?php if (!empty($pr_Id)): ?>
                                <li><i class="bi bi-arrow-right"></i>
                                    <a href="<?= base_url('profile?pr_Id=' . $pr_Id . '#address'); ?>"
                                        class="foot-link login-check">Address</a>
                                </li>
                            <?php else: ?>
                                <li><i class="bi bi-arrow-right"></i>
                                    <a href="<?= base_url('profile#address'); ?>" class="foot-link login-check">Address</a>
                                </li>
                            <?php endif; ?>

                            <li><i class="bi bi-arrow-right"></i>
                                <a href="<?= base_url('profile#orders'); ?>" class="foot-link login-check">Track
                                    Orders</a>
                            </li>
                        </ul>

            </div>
            <div class="col-md-3">
                <h4>Products<h4>
                        <ul>
                            <li><i class="bi bi-arrow-right"></i><a class="foot-link"
                                    href="<?= base_url('product/product_list'); ?>">Price Drop</li>
                            <li><i class="bi bi-arrow-right"></i><a class="foot-link"
                                    href="<?= base_url('product/product_list'); ?>">Products</a></li>
                            <li><i class="bi bi-arrow-right"></i><a class="foot-link"
                                    href="<?= base_url('/#top-products'); ?>">Best Sellers</a></li>
                            <li><i class="bi bi-arrow-right"></i><a class="foot-link"
                                    href="<?= base_url(); ?>">Sitemap</a></li>
                        </ul>
            </div>
            <div class="col-md-3">
                <h4>Our Company<h4>
                        <ul>
                            <li><i class="bi bi-arrow-right"></i> <a class="foot-link"
                                    href="<?= base_url('delivery'); ?>">Delivery</a></li>
                            <li><i class="bi bi-arrow-right"></i> <a class="foot-link"
                                    href="<?= base_url('Privacypolicy'); ?>">Privacy Policy</a></li>
                            <li><i class="bi bi-arrow-right"></i> <a class="foot-link"
                                    href="<?= base_url('Termsandconditions'); ?>">Terms & Conditions</a></li>
                            <li><i class="bi bi-arrow-right"></i> <a class="foot-link"
                                    href="<?= base_url('Return_refundpolicy'); ?>">Return and Refund Policy</a></li>
                        </ul>
            </div>
            <?= view_cell('App\Cells\FooterCell::storeInfo') ?>

        </div>
        <div class="row">
            <div class="col-md-12 text-center social-ico">
                <i class="bi bi-facebook"></i>
                <i class="bi bi-twitter"></i>
                <i class="bi bi-instagram"></i>
                <i class="bi bi-youtube"></i>
            </div>
        </div>
    </div>
</footer>
</body>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!-- intlTelInput CSS -->
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/js/intlTelInput.min.js"></script>


<!-- intlTelInput JS -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script> -->
<!-- Utility script for validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>


<!-- <script src="<?php echo base_url() . ASSET_PATH; ?>assets/js/jquery-3.7.1.min.js"></script> -->
<!-- <script src="<?php echo base_url() . ASSET_PATH; ?>assets/vendors/owlcarousel/owl.carousel.js"></script> -->
<!-- <script src="<?php echo base_url() . ASSET_PATH; ?>assets/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script>


    function openRespMenu() {
        var x = document.getElementById("respTopnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
    $(document).ready(function () {
        $('.bi-search').click(function () {
            $('.searchbox').find('input').toggle({
                right: '250px'
            });
        });

        var topowl = $('#top-prod-owl,#top-prod-owl-two');
        topowl.owlCarousel({
            margin: 10,
            loop: true,
            nav: true, // Enables navigation
            navText: ["<", ">"], // Custom navigation text/icons

            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        });
    });
    //Login form open





    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');

            // Skip if href is exactly '#' or empty
            if (href === '#' || href.length < 2) {
                return;
            }

            e.preventDefault();

            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            const tooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);
            if (tooltip) {
                tooltip.dispose();
            }
        });
    });


</script>
<script>
 


    let iti = null;

    $(document).ready(function () {

        // Submit Handler
      $(document).on('submit', '#registerForm', function (e) {
    e.preventDefault();
    $('#regError').stop(true, true).hide().removeClass('text-danger text-success').html('');

    const password = $('#userpassword').val().trim();
    const cpassword = $('#cpassword').val().trim();
    const email = $('#useremail').val().trim();
    const name = $('#name').val().trim();

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showError('Please enter a valid email address.');
        return;
    }

    if (password !== cpassword) {
        showError('Passwords do not match.');
        return;
    }

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
    const passwordInput = document.getElementById('userpassword');
    const strengthBar = document.getElementById('password-strength-bar');
    const strengthFill = document.getElementById('password-strength-fill');
    const strengthText = document.getElementById('password-strength-text');

    $(document).on('input', '#userpassword', function () {
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

</html>