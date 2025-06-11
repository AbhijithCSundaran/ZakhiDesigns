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
        <a href="<?= base_url('profile#orders'); ?>" class="foot-link login-check">Track Orders</a>
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
                            <li>
							<i class="bi bi-arrow-right"></i>
							<a class="foot-link" href="<?= base_url('/#top-products'); ?>">Best Sellers</a>
						</li>
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
                                    href="<?= base_url('Returnpolicy'); ?>">Return Policy</a></li>
                        </ul>
            </div>
            <div class="col-md-3">
                <h4>Store Information<h4>
                        <ul>
                            <li><i class="bi bi-geo-alt-fill"></i>Zakhi Designs Store<br />16/541P Muppathadam, Near
                                Govt: GHS School Aluva, Ernakulam</li>
                            <li><i class="bi bi-telephone-fill"></i>+91 70348 53219</li>
                            <li><i class="bi bi-envelope-fill"></i>zakhidesigns@gmail.com</li>
                        </ul>
            </div>
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
        // When "Login" is clicked inside register modal
        $(document).on('click', '#showLoginFromRegister', function (e) {
            e.preventDefault();

            $('#modalBody').load("<?= base_url('weblogin'); ?>", function () {
                $('#mainModal').modal('show');
            });
        });


        // Login form submission (delegated because it's loaded dynamically)
        $(document).on('submit', '#loginForm', function (e) {
            e.preventDefault();

            let email = $('#email').val();
            let password = $('#password').val();

            $.ajax({
                url: '<?= base_url('customerauth'); ?>',
                type: 'POST',
                data: {
                    cust_Email: email,
                    cust_Password: password
                },
                success: function (res) {
                    let data = JSON.parse(res);
                    if (data.status == 1) {
                        window.location.reload();
                    } else {
                        $('#loginError').text(data.msg);
                    }
                },
                error: function () {
                    $('#loginError').text('Something went wrong. Please try again.');
                }
            });
        });

        // Register form submission (delegated)
        $(document).on('submit', '#registerForm', function (e) {
            e.preventDefault();

            $('#regError').html(''); // clear previous messages

            const password = $('#password').val();
            const cpassword = $('#cpassword').val();
            const email = $('#email').val();
            const phone = $('#number').val();
            const name = $('#name').val();

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

            // Validate phone number (10 digits only)
            if (!/^\d{10}$/.test(phone)) {
                $('#regError').html('Phone number must be exactly 10 digits.');
                return;
            }

            // Validate name (only letters and space)
            const nameRegex = /^[a-zA-Z ]+$/;
            if (!nameRegex.test(name)) {
                $('#regError').html('Name must contain only letters and spaces.');
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
                        $('#regError').removeClass('text-danger').addClass('text-success').html(
                            response.msg);
                        $('#registerForm')[0].reset(); // reset form
                        setTimeout(function () {
                            $('#registerModal').modal('hide');
                        }, 1000);

                        // window.location.reload();
                    } else {
                        $('#regError').removeClass('text-success').addClass('text-danger').html(
                            response.msg);
                    }
                },
                error: function (xhr) {
                    $('#regError').removeClass('text-success').addClass('text-danger').html(
                        'An error occurred. Please try again.');
                }
            });
        });

    });
	
	
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

</script>

</html>