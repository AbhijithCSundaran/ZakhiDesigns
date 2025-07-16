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
                            <li><i class="bi bi-arrow-right"></i>
                                <a href="<?= base_url('profile#address'); ?>" class="foot-link login-check">Address</a>
                            </li>
                            <li><i class="bi bi-arrow-right"></i>
                                <a href="<?= base_url('profile#orders'); ?>" class="foot-link login-check">Track
                                    Orders</a>
                            </li>
                        </ul>

            </div>
            <div class="col-md-3">
                <h4>Products<h4>
                        <ul>
                            <li><i class="bi bi-arrow-right"></i><a class="foot-link" href="<?= base_url('product/product_list'); ?>">Price Drop</li>
                            <li><i class="bi bi-arrow-right"></i><a class="foot-link" href="<?= base_url('product/product_list'); ?>">Products</a></li>
                            <li><i class="bi bi-arrow-right"></i><a class="foot-link" href="<?= base_url('/#top-products'); ?>">Best Sellers</a></li>
                            <li><i class="bi bi-arrow-right"></i><a class="foot-link" href="<?= base_url(); ?>">Sitemap</a></li>
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




<!-- <script src="<?php echo base_url() . ASSET_PATH; ?>assets/js/jquery-3.7.1.min.js"></script> -->
<!-- <script src="<?php echo base_url() . ASSET_PATH; ?>assets/vendors/owlcarousel/owl.carousel.js"></script> -->
<!-- <script src="<?php echo base_url() . ASSET_PATH; ?>assets/js/bootstrap.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

    $(document).ready(function () {

        // Load login form into modal
        $('#loginBtn').on('click', function (e) {
            e.preventDefault();
            $('#modalBody').load("<?= base_url('weblogin'); ?>", function () {
                $('#mainModal').modal('show');
            });
        });

        // Load register form into modal
        $('#registerBtn').on('click', function (e) {
            e.preventDefault();
            $('#modalBody').load("<?= base_url('webreg'); ?>", function () {
                $('#mainModal').modal('show');
            });
        });

        // When "Register" is clicked inside login modal
        $(document).on('click', '#showRegisterFromLogin', function (e) {
            e.preventDefault();

            // Load register form in the same modal
            $('#modalBody').load("<?= base_url('webreg'); ?>", function () {
                $('#mainModal').modal('show');
            });
        });

        //when forgot password Clicked inside login modal
        $(document).on('click', '#showForgotForm', function (e) {
            e.preventDefault();

            // Load Forgot form in the same modal
            $('#modalBody').load("<?= base_url('webforgot'); ?>", function () {
                $('#mainModal').modal('show');
            });
        });

        // When "Login" is clicked inside register modal
        $(document).on('click', '#showLoginFromRegister', function (e) {
            e.preventDefault();

            $('#modalBody').load("<?= base_url('weblogin'); ?>", function () {
                $('#mainModal').modal('show');
            });
        });

        $(document).on('click', '#showLoginFromFrgt', function (e) {
            e.preventDefault();

            $('#modalBody').load("<?= base_url('weblogin'); ?>", function () {
                $('#mainModal').modal('show');
            });
        });




        // Login form submission (delegated because it's loaded dynamically)
        // $(document).on('submit', '#loginForm', function (e) {
        //     e.preventDefault();

        //     let email = $('#email').val();
        //     let password = $('#password').val();

        //     $.ajax({
        //         url: '<?= base_url('customerauth'); ?>',
        //         type: 'POST',
        //         data: {
        //             cust_Email: email,
        //             cust_Password: password
        //         },
        //         success: function (res) {
        //             let data = JSON.parse(res);
        //             if (data.status == 1) {
        //                 window.location.reload();
        //             } else {
        //                 $('#loginError').text(data.msg);
        //             }
        //         },
        //         error: function () {
        //             $('#loginError').text('Something went wrong. Please try again.');
        //         }
        //     });
        // });
        $(document).on('submit', '#loginForm', function (e) {
        e.preventDefault();

        // Clear any existing errors
        $('#loginError').text('');

        // Get form input values
        let email = $('#email').val().trim();
        let password = $('#password').val().trim();

        // Get reCAPTCHA response
        let recaptchaResponse = grecaptcha.getResponse();

        // Validate inputs
        if (!email || !password) {
            $('#loginError').text('Email and Password are required.');
            return;
        }

        if (!recaptchaResponse) {
            $('#loginError').text('Please complete the reCAPTCHA.');
            return;
        }

        // Send AJAX login request
        $.ajax({
            url: '<?= base_url('customerauth'); ?>',
            type: 'POST',
            data: {
                cust_Email: email,
                cust_Password: password,
                'g-recaptcha-response': recaptchaResponse
            },
            success: function (res) {
                let data;
                try {
                    data = JSON.parse(res);
                } catch (e) {
                    $('#loginError').text('Invalid server response.');
                    return;
                }

                if (data.status == 1) {
                    // Success — reload or redirect
                    location.reload();
                } else {
                    // Display error message
                    $('#loginError').text(data.msg);
                    grecaptcha.reset(); // Reset the reCAPTCHA for retry
                }
            },
            error: function () {
                $('#loginError').text('Something went wrong. Please try again.');
                grecaptcha.reset(); // Reset reCAPTCHA in case of failure
            }
        });
    });

     

    });

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

</html>