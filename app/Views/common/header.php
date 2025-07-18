<!DOCTYPE html>
<html>

<head>
    <title>Zakhi Designs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id"
        content="980312560634-kksn59gmuu5p4rg68tnd2vaooe7lfdfu.apps.googleusercontent.com">


    <link rel="stylesheet" href="<?= base_url() . ASSET_PATH; ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() . ASSET_PATH; ?>assets/css/customstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url() . ASSET_PATH; ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?= base_url() . ASSET_PATH; ?>assets/css/custom.css">

    <link rel="stylesheet" href="<?= base_url() . ASSET_PATH; ?>assets/vendors/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="<?= base_url() . ASSET_PATH; ?>assets/vendors/owlcarousel/assets/owl.theme.default.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo base_url() . ASSET_PATH; ?>assets/images/logo.jpg">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-----------------------------Country code---------------------------------->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/css/intlTelInput.css" />


</head>

<body>
    <header>
        <div class="container-lg" style="top:0px;">
            <div class="row head-row">
                <div class="col-6 logo">
                    <a href="<?= base_url(); ?>">
                        <img src="<?= base_url() . ASSET_PATH; ?>assets/images/logo.jpg" alt="Logo" />
                    </a>
                </div>
                <?= view_cell('App\Cells\FooterCell::footerInfo') ?>


            </div>
            <div class="row">
                <div class="col-md-12">
                    <nav class="topnav" id="respTopnav">
                        <a href="<?= base_url(); ?>" class="active">Home</a>
                        <a href="<?= base_url('aboutus'); ?>">About Us</a>
                        <!-- Fashion dropdown -->
                        <div class="dropdown-wrapper a fashion-menu position-relative " style=" cursor: pointer;">
                            <span class="dropbtn">Fashion</span>
                            <div class="cat-dropdown">
                                <?php if (!empty($categories)): ?>
                                    <?php foreach (array_slice($categories, 0, 10) as $category): ?>
                                        <div class="cat-item position-relative">
                                            <a href="<?= base_url('category/catProducts/' . $category['cat_Id']) ?>"
                                                class="cat-link" data-cat-id="<?= $category['cat_Id'] ?>">
                                                <?= esc($category['cat_Name']) ?>
                                            </a>

                                            <?php if (!empty($category['subcategories'])): ?>
                                                <div class="sub-dropdown">
                                                    <?php foreach ($category['subcategories'] as $sub): ?>
                                                        <a
                                                            href="<?= base_url('subcategory/subcategoryProducts/' . $sub['sub_Id'] . '/' . $category['cat_Id']) ?>">
                                                            <?= esc($sub['sub_Category_Name']) ?>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>

                                <?php endif; ?>
                                <div class="cat-item">
                                    <a href="<?= base_url('category/category_list') ?>">All Category</a>
                                </div>
                            </div>
                        </div>
                        <a href="<?= base_url('contact'); ?>">Contact</a>

                        <?php if (session()->get('zd_uname')): ?>
                            <div class="dropdown a">
                                <div class="dropdown-toggle drop-menu p-0" href="#" role="button" id="customerDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= session()->get('zd_uname'); ?>
                                </div>
                                <ul class="dropdown-menu" aria-labelledby="customerDropdown">
                                    <li>
                                        <a class="dropdown-item small-menu-item" href="<?= base_url('profile#profile'); ?>">
                                            <i class="bi bi-person-circle me-1"></i> My Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small-menu-item" href="<?= base_url('logout') ?>">
                                            <i class="bi bi-escape me-1"></i> Logout
                                        </a>
                                    </li>
                                </ul>

                            </div>

                        <?php else: ?>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#exampleModal" id="loginBtn">Login</a>

                            <!-- <a href="#" id="registerBtn">Register</a> -->
                        <?php endif; ?>


                        <a href="javascript:void(0);" class="icon" onclick="openRespMenu()">
                            <i class="bi bi-list"></i>
                        </a>
                        <div class="searchbox"
                            style="display: flex; align-items: center; gap: 5px; position: relative; top: -5px;">
                            <input type="text" name="keyword" id="search"
                                placeholder="Search Products/Category/Sub:Cate" autocomplete="off"
                                value="<?= esc($search ?? '') ?>" style="padding: 5px; "
                                onkeydown="checkEnter(event)" />

                            <a href="javascript:void(0);" onclick="searchProduct()"
                                style="text-decoration: none; color: inherit;">
                                <i class="bi bi-search" style="position: relative; top: -6px;"></i>
                            </a>

                        </div>

                    </nav>
                </div>
            </div>
        </div>
    </header>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <!-- Modal Header: Logo + Close Icon -->
                <div class="modal-header justify-content-center position-relative border-0 pb-0">
                    <!-- Logo centered -->
                    <a href="<?= base_url(); ?>" class="mx-auto">
                        <img src="<?= base_url() . ASSET_PATH ?>assets/images/logo.jpg" alt="Zakhi Logo"
                            style="height: 40px;">
                    </a>

                    <!-- Close icon absolutely positioned to the top-right -->
                    <button type="button" class="btn-close position-absolute top-0 end-0 mt-2 me-2"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body: Login Form -->
                <div class="modal-body">
                    <div id="loginFormContainer">
                        <h5 class="text-center mb-3">Sign In</h5>

                        <div id="loginError" class="text-danger text-center" style="padding:6px;"></div>

                        <form id="loginForm" method="post">
                            <div class="floating-label-group mb-3">
                                <input type="email" class="form-control" id="cust_email" name="cust_Email" required />

                                <label for="email">Enter the email address</label>
                                <div id="emailError" class="text-danger small mt-1" style="display:none;"></div>
                            </div>

                            <div class="floating-label-group password-wrapper mb-3">
                                <div class="password-input-wrapper position-relative">
                                    <input type="password" class="form-control" id="cust_password" name="cust_Password"
                                        required />
                                    <label for="password">Enter your password</label>
                                    <i class="bi bi-eye-slash toggle-password position-absolute top-50 end-0 translate-middle-y pe-3"
                                        id="togglePassword" style="cursor:pointer;"></i>
                                </div>
                            </div>
                

                            <div class="g-recaptcha" data-sitekey="6Le-VXcrAAAAAFdEqJLtM5DxM6GoGl7cJdV6hknL"></div>
                            <div>&nbsp;</div>


                            <div>
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </div><!-- Google Sign-In -->
                            <div id="g_id_onload"
                                data-client_id="89279377857-k55fvvqvtbk9nib9mc04jfsdgb9k00gn.apps.googleusercontent.com"
                                data-context="signin"
                                data-login_uri="https://v4cstaging.co.in/zakhidesigns/google-login-callback"
                                data-auto_prompt="false">
                            </div>

                            <div class="g_id_signin mb-3" data-type="standard" data-shape="rectangular"
                                data-theme="outline" data-text="signin_with" data-size="large"
                                data-logo_alignment="left">
                            </div>

                            <div class="d-flex justify-content-end mb-2">
                                <a id="showForgotForm" class="forgot-style text-decoration-none"
                                    style="font-size: 14px;">Forgot Password?</a>
                            </div>

                            <div class="d-flex justify-content-end align-items-center gap-2 mb-2">
                                <p class="mb-0" style="font-size: 14px;">Don't have an account?</p>
                                <a href="#" class="text-decoration-none" id="showRegisterFromLogin"
                                    style="font-size: 14px;">Register</a>
                            </div>
                        </form>
                    </div>
                    <div id="registerFormContainer" style="display: none;">
                        <h5 class="text-center" style="margin-top: 5px;">Your Fashion Journey Starts Here </h5>

                        <div id="regError" class="text-danger text-center p-2" style="color:red;"></div>
                        <form id="registerForm" method="post">
                            <div class="floating-label-group">
                                <input type="text" class="form-control" id="name" name="custname" placeholder=""
                                    required />
                                <label for="name">Name</label>
                            </div>

                            <div class="floating-label-group">
                                <input type="email" class="form-control" id="useremail" name="useremail" placeholder=""
                                    required />
                                <label for="useremail">Email</label>
                            </div>



                            <div class="floating-label-group password-wrapper">
                                <div class="password-input-wrapper">
                                    <input type="password" class="form-control" id="userpassword" name="userpassword"
                                        placeholder=" " required maxlength="15" />
                                    <label for="password">Password</label>
                                    <i class="bi bi-eye-slash toggle-password" id="toggleCurrentPassword"
                                        style="cursor: pointer;"></i>
                                </div>
                            </div>
                            <div class="progress mt-2" id="password-strength-bar" style="height: 8px; display: none;">
                                <div class="progress-bar" role="progressbar" style="width: 0%;"
                                    id="password-strength-fill"></div>
                            </div>
                            <small id="password-strength-text" class="fw-bold"></small>
                            <div>&nbsp;</div>

                            <div class="floating-label-group password-wrapper">
                                <div class="password-input-wrapper">
                                    <input type="password" class="form-control" id="cpassword" name="cust_cpassword"
                                        max-length="15" placeholder=" " required />
                                    <label for="cpassword">Confirm Password</label>
                                    <i class="bi bi-eye-slash toggle-password" id="toggleConfirmPassword"></i>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Create Now</button>
                            </div>
                            <div class="d-flex mt-2">
                                <p class="mb-0">Already have an account with us?</p>
                                <a href="#" class="ms-2 text-decoration-none" id="showLoginFromRegister"
                                    style="text-decoration:none">Login</a>
                            </div>
                        </form>
                    </div>
                    <div id="forgotFormContainer" style="display: none;">
                        <h5 class="text-center" style="margin-top: 7px;">Forgot Password</h5>


                        <form id="forgotEmailForm" method="post">
                            <div class="alert p-2" id="messageBox" style="display: none;"></div>

                            <p style="text-align:center;">Enter your email address and we'll send you a link to reset
                                your password.</p>
                            <div class="floating-label-group">
                                <input type="email" class="form-control" id="forgotCustEmail" name="forgotCustEmail"
                                    placeholder=" " required />
                                <label for="email">Email</label>
                            </div>
                            <div class="d-flex mt-2 justify-content-center">
                                <button type="button" class="btn btn-primary" id="forgotEmailSending">Reset Password
                                </button>
                            </div>
                            <div class="text-end">
                                <a href="" class="ms-2" id="showLoginFromFrgt" style="text-decoration:none">Back to
                                    Login</a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Footer: Terms & Privacy -->
                <div class="modal-footer text-center flex-column">
                    <small style="font-size: 13px; color: #7d7d6cff;">
                        By continuing, you agree to ZakhiDesigns
                        <a href="<?= base_url('Termsandconditions'); ?>" class="text-decoration-none">Terms &
                            Conditions</a> of Use and
                        <a href="<?= base_url('Privacypolicy'); ?>" class="text-decoration-none">Privacy Policy</a>
                        Notice.
                    </small>
                </div>
            </div>
        </div>
    </div>




    </div>
    </div>
    </div>


    <script>
        function searchProduct() {
            const keyword = document.getElementById('search').value.trim();
            if (keyword !== '') {
                window.location.href = "<?= base_url('product/search') ?>?keyword=" + encodeURIComponent(keyword);
            }
        }

        function checkEnter(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchProduct();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
            let lastClickedLink = null;
            let tapTimeout;

            const hideAllDropdowns = () => {
                document.querySelectorAll('.sub-dropdown').forEach(drop => {
                    drop.style.display = 'none';
                });
                lastClickedLink = null;
            };

            document.querySelectorAll('.cat-link').forEach(function (link) {
                const parent = link.closest('.cat-item');
                const dropdown = parent.querySelector('.sub-dropdown');

                if (isTouchDevice) {
                    link.addEventListener('click', function (e) {
                        if (lastClickedLink !== link) {
                            e.preventDefault();
                            hideAllDropdowns();
                            if (dropdown) dropdown.style.display = 'block';

                            lastClickedLink = link;
                            clearTimeout(tapTimeout);
                            tapTimeout = setTimeout(() => {
                                lastClickedLink = null;
                            }, 1000);
                        }
                    });
                } else {
                    parent.addEventListener('mouseenter', () => {
                        hideAllDropdowns();
                        if (dropdown) dropdown.style.display = 'block';
                    });
                    parent.addEventListener('mouseleave', () => {
                        if (dropdown) dropdown.style.display = 'none';
                    });
                }
            });

            document.addEventListener('click', function (e) {
                const isClickInsideCategory = e.target.closest('.cat-item');
                if (!isClickInsideCategory) {
                    hideAllDropdowns();
                }
            });
        });


        $(document).ready(function () {
            // Show Register form from Login
            $('#showRegisterFromLogin').click(function (e) {
                e.preventDefault();
                $('#loginFormContainer').hide();
                $('#forgotFormContainer').hide();
                $('#registerFormContainer').show();
            });

            // Show Login form from Register
            $('#showLoginFromRegister').click(function (e) {
                e.preventDefault();
                $('#registerFormContainer').hide();
                $('#forgotFormContainer').hide();
                $('#loginFormContainer').show();
            });

            // Show Forgot form from Login
            $('#showForgotForm').click(function (e) {
                e.preventDefault();
                $('#loginFormContainer').hide();
                $('#registerFormContainer').hide();
                $('#forgotFormContainer').show();
            });

            // Show Login from Forgot
            $('#showLoginFromFrgt').click(function (e) {
                e.preventDefault();
                $('#registerFormContainer').hide();
                $('#forgotFormContainer').hide();
                $('#loginFormContainer').show();
            });
        });


        $(document).on('submit', '#loginForm', function (e) {
            e.preventDefault();

            let email = $('#cust_email').val();
            let password = $('#cust_password').val();

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
   
// Add this FIRST
function togglePassword(inputId, toggleId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(toggleId);

    if (!input || !icon) return;

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const toggleLogin = document.getElementById('togglePassword');
    const toggleCurrent = document.getElementById('toggleCurrentPassword');
    const toggleConfirm = document.getElementById('toggleConfirmPassword');

    if (toggleLogin) {
        toggleLogin.addEventListener('click', function () {
            togglePassword('cust_password', 'togglePassword');
        });
    }

    if (toggleCurrent) {
        toggleCurrent.addEventListener('click', function () {
            togglePassword('userpassword', 'toggleCurrentPassword');
        });
    }

    if (toggleConfirm) {
        toggleConfirm.addEventListener('click', function () {
            togglePassword('cpassword', 'toggleConfirmPassword');
        });
    }
});

    </script>