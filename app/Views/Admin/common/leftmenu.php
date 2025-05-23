
<div class="pcoded-main-container">
              <div class="pcoded-wrapper">
                  <nav class="pcoded-navbar">
                      <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                      <div class="pcoded-inner-navbar main-menu">
                          <div class="">
						   
                              <div class="main-menu-header">
                                  <img class="img-80 img-radius" src="<?php echo base_url().ASSET_PATH; ?>Admin/assets/images/avatar-4.jpg" alt="User-Profile-Image">
                                 
                                  <div class="user-details">
                                    
                                      <span id="more-details"><i class="fa fa-caret"></i></span>
                                  </div>
                              </div>
                              <div class="main-menu-content">
                          
                              </div>
                          </div>    
                          <div class="p-15 p-b-0">
                             
                          </div>
                          <div class="pcoded-navigation-label" data-i18n="nav.category.navigation"></div>
                          <?php
                          $uri = service('uri');
                          $segment = $uri->getSegment(2); // Gets the first segment of the URI
                          ?>
                          <ul class="pcoded-item pcoded-left-item">
                          <li class="<?= ($segment == 'dashboard') ? 'active' : '' ?>">
                                  <a href="<?php echo base_url('admin/dashboard') ?>" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                      <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                      <span class="pcoded-mcaret"></span>
                                  </a>
                              </li>
                              <li class="<?= ($segment == 'staff') ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/staff') ?>" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="bi bi-person-add"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Staff</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?= ($segment == 'customer') ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('admin/customer') ?>" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="bi bi-people"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Customer</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                          </ul>
                          <ul class="pcoded-item pcoded-left-item">
                          <li class="<?= ($segment == 'category') ? 'active' : '' ?>">
                                  <a href="<?php echo base_url('admin/category') ?>" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="bi bi-bookmark"></i><b>D</b></span>
                                      <span class="pcoded-mtext" data-i18n="nav.dash.main">Category</span>
                                      <span class="pcoded-mcaret"></span>
                                  </a>
                              </li>
                              
                              <li class="<?= ($segment == 'subcategory') ? 'active' : '' ?>">
                                <a href="<?php echo base_url('admin/subcategory') ?>" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="bi bi-bookmark-plus"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Sub Category</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="<?= ($segment == 'product') ? 'active' : '' ?>">
                                <a href="<?php echo base_url('admin/product') ?>" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="bi bi-box-seam"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Products</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                           
                            <!-- <li class="<?= ($segment == 'banner') ? 'active' : '' ?>">
                                <a href="<?php echo base_url('admin/banner') ?>" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="bi bi-bounding-box-circles"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Banners</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
							  <li class="<?= ($segment == 'offer_banner') ? 'active' : '' ?>">
                                <a href="<?php echo base_url('offer_banner') ?>" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="bi bi-bounding-box"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Offer Banners</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li> -->
							<li class="<?= ($segment == 'themes') ? 'active' : '' ?>">
                                <a href="<?php echo base_url('admin/themes') ?>" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Themes</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                          </ul>
                     
                          
                  </nav>