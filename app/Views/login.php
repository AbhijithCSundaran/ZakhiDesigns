<!DOCTYPE html>
<html lang="en">
<head>
    <title>Mega Able bootstrap admin template by codedthemes </title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- Meta -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="Mega Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
      <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
      <meta name="author" content="codedthemes" />
	  <!-----------Eye icon toggle style------------>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
      <!-- Favicon icon -->

      <link rel="icon" href="<?php echo base_url().ASSET_PATH; ?>assets/images/favicon.ico" type="image/x-icon">
      <!-- Google font-->     
      <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url().ASSET_PATH; ?>assets/css/bootstrap/css/bootstrap.min.css">
      <!-- waves.css -->
      <link rel="stylesheet" href="<?php echo base_url().ASSET_PATH; ?>assets/pages/waves/css/waves.min.css" type="text/css" media="all">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url().ASSET_PATH; ?>assets/icon/themify-icons/themify-icons.css">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url().ASSET_PATH; ?>assets/icon/icofont/css/icofont.css">
      <!-- Font Awesome -->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url().ASSET_PATH; ?>assets/icon/font-awesome/css/font-awesome.min.css">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url().ASSET_PATH; ?>assets/css/style.css">
  </head>

  <body themebg-pattern="theme1">
  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
            
              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Pre-loader end -->
  <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <form class="md-float-material form-material" id="form-id" name="form-id">
					
                        <div class="text-center">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/logo.png" alt="logo.png">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
							<span class="alrt-msg" id="alertbox" style="display:none;"></span>
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center txt-primary">Please Login</h3>
                                    </div>
                                </div>                               
                                <div class="form-group form-primary">
                                    <input type="text" name="email" id="email" class="form-control" autocomplete="off" required>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Your Email Address</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
										<div class="form-group form-primary position-relative">
											<input type="password" name="password" id="password" class="form-control" autocomplete="off" required>
											<span class="form-bar"></span>
											<label class="float-label">Password</label>
											
											<!-- Eye icon positioned inside input -->
											<i class="fa-solid fa-eye toggle-password" id="togglePassword" 
											   style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></i>
										</div>
									</div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="button" name="submitBtn" id="submitBtn" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20">Sign In</button>
                                    </div>
                                </div>
                                <hr/>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
	<!--------alert box script------------>
	
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
	
	<script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Warning Section Starts -->
    <!-- Older IE warning message -->
	<!-- Warning Section Ends -->
	<!-- Required Jquery -->
    <script type="text/javascript" src="<?php echo base_url().ASSET_PATH; ?>assets/js/jquery/jquery.min.js"></script>     
	<script type="text/javascript" src="<?php echo base_url().ASSET_PATH; ?>assets/js/jquery-ui/jquery-ui.min.js "></script>    
	<script type="text/javascript" src="<?php echo base_url().ASSET_PATH; ?>assets/js/popper.js/popper.min.js"></script>     
	<script type="text/javascript" src="<?php echo base_url().ASSET_PATH; ?>assets/js/bootstrap/js/bootstrap.min.js "></script>
	<!-- waves js -->
	<script src="<?php echo base_url().ASSET_PATH; ?>assets/pages/waves/js/waves.min.js"></script>
	<!-- jquery slimscroll js -->
	<script type="text/javascript" src="<?php echo base_url().ASSET_PATH; ?>assets/js/jquery-slimscroll/jquery.slimscroll.js "></script>
	<!-- modernizr js -->
		<!-- <script type="text/javascript" src="<?php echo base_url().ASSET_PATH; ?>assets/js/SmoothScroll.js"></script>      -->
		<script src="<?php echo base_url().ASSET_PATH; ?>assets/js/jquery.mCustomScrollbar.concat.min.js "></script>
	<!-- i18next.min.js 
	<script type="text/javascript" src="bower_components/i18next/js/i18next.min.js"></script>
	<script type="text/javascript" src="bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
	<script type="text/javascript" src="bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
	<script type="text/javascript" src="bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url().ASSET_PATH; ?>assets/js/common-pages.js"></script>
</body>
<script>
function authenticate() {

    var url = '<?php echo base_url('Auth'); ?>';
    $.post(url, $('#form-id').serialize(), function(data) {
        if (data.status == 1) {
            window.location.href = "<?php echo base_url('dashboard'); ?>";
        } else {
            $('#alertbox')
                .html('<div>' + data.msg + '</div>')
                .removeClass('success')
                .addClass('error')
                .show();
            setTimeout(function() {
                $('#alertbox').empty().hide();
            }, 2000);
        }
    }, 'json');
}

$(document).ready(function() {
    $('#submitBtn').click(function(event) {
        event.preventDefault();
        authenticate();
    });
});
  </script>
<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const icon = this;

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>
</html>
