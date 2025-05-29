<!DOCTYPE html>
<html>

<head>
    <title>Zakhi Designs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url().ASSET_PATH;?>assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url().ASSET_PATH; ?>assets/css/customstyle.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo base_url().ASSET_PATH; ?>assets/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url().ASSET_PATH; ?>assets/css/custom.css">
	
    <link rel="stylesheet"
        href="<?php echo base_url().ASSET_PATH;?>assets/vendors/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url().ASSET_PATH; ?>assets/vendors/owlcarousel/assets/owl.theme.default.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <header>
        <div class="container-lg">
            <div class="row head-row">
                <div class="col-6 logo">
                    <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/logo.jpg" />
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
                    <div class="topnav" id="respTopnav">
                      <a href="<?= base_url();?>" class="active">Home</a>
                      <a href="<?= base_url('aboutus');  ?>">About Us</a>
                        <a href="#contact">Fashion</a>
                        <a href="<?= base_url('/Contact');?>">Contact</a>

                        <?php if (session()->get('zd_uname')): ?>
                        <a class="drop">
                            <a class="btn dropdown-toggle drop-menu" href="#" role="button" id="customerDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <?= session()->get('zd_uname'); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="customerDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('customer/profile') ?>">
                                        <i class="bi bi-person-circle"></i> My Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                        <i class="bi bi-escape"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </a>
                        <?php else: ?>
                        <!-- Show login/register links if not logged in -->
                        <a href="" id="loginBtn">Login</a>
                        <a href="" id="registerBtn">Register</a>
                        <?php endif; ?>



                        <a href="javascript:void(0);" class="searchbox">
                            <input type="text" name="keyword" id="search" placeholder="Search products"
                                autocomplete="off" value="<?= esc($search ?? '') ?>" />
                        </a>
                        <a href="javascript:void(0);" onclick="searchProduct()">
                            <i class="bi bi-search"></i>
                        </a>
                        <a href="javascript:void(0);" class="icon" onclick="openRespMenu()">
                            <i class="bi bi-list"></i>
                        </a>
                    </div>
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
    </script>