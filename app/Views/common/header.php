<!DOCTYPE html>
<html>

<head>
    <title>Zakhi Designs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-signin-client_id" content="980312560634-kksn59gmuu5p4rg68tnd2vaooe7lfdfu.apps.googleusercontent.com">

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
    <link rel="icon" href="<?php echo base_url().ASSET_PATH; ?>assets/images/logo.jpg" >
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Swiper CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <!-- Swiper JS -->
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


</head>

<body>
    <header>
        <div class="container-lg" style="top:0px;">
            <div class="row head-row">
                <div class="col-6 logo">
                    <img src="<?= base_url() . ASSET_PATH; ?>assets/images/logo.jpg" alt="Logo" />
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-12 callnow tel-ico">
                            <i class="bi bi-telephone-fill"></i>
                            <span>Call Us Now</span><br />
                            <small>+91 70348 53219</small>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <nav class="topnav" id="respTopnav">
                        <a href="<?= base_url(); ?>" class="active">Home</a>
                        <a href="<?= base_url('aboutus'); ?>">About Us</a>
                        <!-- Fashion dropdown -->
                        <div class="dropdown-wrapper a fashion-menu position-relative " style = " cursor: pointer;">
                            <span class="dropbtn" >Fashion</span>
                            <div class="cat-dropdown">
                                <?php if (!empty($categories)): ?>
                                <?php foreach (array_slice($categories , 0,10) as $category): ?>
                                <div class="cat-item position-relative">
                                    <a href="<?= base_url('category/catProducts/' . $category['cat_Id']) ?>">
                                        <?= esc($category['cat_Name']) ?>
                                    </a>

                                    <?php if (!empty($category['subcategories'])): ?>
                                    <div class="sub-dropdown">
                                        <?php foreach ($category['subcategories'] as $sub): ?>
                                        <a href="<?= base_url('subcategory/subcategoryProducts/'. $sub['sub_Id'] . '/' . $category['cat_Id'])  ?>">

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
                                <li><a class="dropdown-item" href="<?= base_url('profile#profile'); ?>"><i
                                            class="bi bi-person-circle"></i> My Profile</a></li>
                                <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i
                                            class="bi bi-escape"></i> Logout</a></li>
                            </ul>
                        </div>


                        <?php else: ?>
                        <a href="#" id="loginBtn">Login</a>
                        <a href="#" id="registerBtn">Register</a>
                        <?php endif; ?>

                        <a href="javascript:void(0);" class="searchbox">
                            <input type="text" name="keyword" id="search" placeholder="Search products"
                                autocomplete="off" value="<?= esc($search ?? '') ?>" style="padding:5px;"
                                onkeydown="checkEnter(event)" />
                            <a href="javascript:void(0);" onclick="searchProduct()">
                                <i class="bi bi-search"></i>
                            </a>
                        </a>
                        <a href="javascript:void(0);" class="icon" onclick="openRespMenu()">
                            <i class="bi bi-list"></i>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <!-- Modal Skeleton -->
    <div class="modal fade" id="mainModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- AJAX content will load here -->
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
            event.preventDefault(); // Optional
            searchProduct();
        }
    }



    document.addEventListener('DOMContentLoaded', function () {
        const fashionMenu = document.querySelector('.dropdown-wrapper');
        if (!fashionMenu) return;

        const catDropdown = fashionMenu.querySelector('.cat-dropdown');

        fashionMenu.addEventListener('mouseenter', () => {
            if (catDropdown) catDropdown.style.display = 'flex';
        });
        fashionMenu.addEventListener('mouseleave', () => {
            if (catDropdown) catDropdown.style.display = 'none';
        });
    });

    </script>