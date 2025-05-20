<div class="pcoded-main-container">
              <div class="pcoded-wrapper">
                  <nav class="pcoded-navbar">
                      <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                      <div class="pcoded-inner-navbar main-menu">
                          <div class="">
						   
                              <div class="main-menu-header">
                                  <img class="img-80 img-radius" src="<?php echo base_url().ASSET_PATH; ?>assets/images/avatar-4.jpg" alt="User-Profile-Image">
                                 
                                  <div class="user-details">
                                    
                                      
                                  </div>
                              </div>
                              <div class="main-menu-content">
                                  <ul>
                                     
                                  </ul>
                              </div>
                          </div>    
                          <div class="p-15 p-b-0">
                             
                          </div>
                          <div class="pcoded-navigation-label" data-i18n="nav.category.navigation"></div>
                          <?php
                          $uri = service('uri');
                          $segment = $uri->getSegment(1); // Gets the first segment of the URI
                          ?>
                          <ul class="pcoded-item pcoded-left-item">
                          <li class="<?= ($segment == 'dashboard') ? 'active' : '' ?>">
                                  <a href="<?php echo base_url('dashboard') ?>" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                      <span class="pcoded-mtext" data-i18n="nav.dash.main">Dashboard</span>
                                      <span class="pcoded-mcaret"></span>
                                  </a>
                              </li>

                              
                              <li class="<?= ($segment == 'staff') ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('staff') ?>" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Staff</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="<?= ($segment == 'customer') ? 'active' : '' ?>">
                                    <a href="<?php echo base_url('customer') ?>" class="waves-effect waves-dark">
                                        <span class="pcoded-micon"><i class="ti-layers"></i><b>FC</b></span>
                                        <span class="pcoded-mtext" data-i18n="nav.form-components.main">Customer</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                          </ul>
                          <ul class="pcoded-item pcoded-left-item">
                          <li class="<?= ($segment == 'category') ? 'active' : '' ?>">
                                  <a href="<?php echo base_url('category') ?>" class="waves-effect waves-dark">
                                      <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                      <span class="pcoded-mtext" data-i18n="nav.dash.main">Category</span>
                                      <span class="pcoded-mcaret"></span>
                                  </a>
                              </li>
                              
                              <li class="<?= ($segment == 'subcategory') ? 'active' : '' ?>">
                                <a href="<?php echo base_url('subcategory') ?>" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Sub Category</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="<?= ($segment == 'product') ? 'active' : '' ?>">
                                <a href="<?php echo base_url('product') ?>" class="waves-effect waves-dark">
                                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Products</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            
                          </ul>
                  </nav>