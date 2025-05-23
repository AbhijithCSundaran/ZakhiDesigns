<div class="pcoded-content">
    <!-- Page-header start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="page-header-title">
                        <h5 class="m-b-10"><?= isset($banner) ? 'Update Theme' : 'Add Theme'; ?></h5>
                        <p class="m-b-0">Welcome to Zakhi Designs</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <ul class="breadcrumb-title">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('dashboard'); ?>"> <i class="fa fa-home"></i> </a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!"><?= isset($banner) ? 'Update Theme' : 'Add Theme'; ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    <div class="pcoded-inner-content">
        <!-- Main-body start -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div id="messageBox" class="alert alert-success" style="display: none;"></div>
                                    </div>
									
                                </div>
                                <div class="card-block">
                                   <form name="theme_add" id="theme_add" method="post" enctype="multipart/form-data">

									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Name<span style="color: red;">*</span></label>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="theme_name"
												value="<?= isset($banner) ? $banner['theme_Name'] : '' ?>" id="theme_name" maxlength="20"
												placeholder="Enter the Name" required>
										</div>
									</div>

									<div class="form-group row">
											<label class="col-sm-3 col-form-label">Description<span style="color: red;">*</span></label>
											<div class="col-sm-7">
												<input type="text" class="form-control"
													value="<?= isset($banner) ? ($banner['theme_Description']) : '' ?>" name="description"
													id="description" placeholder="Enter the description">
											</div>
										</div>

										<!-- Accordion Section -->
										<div class="form-group row">
											<label class="col-sm-3 col-form-label">Theme Sections</label>
											<div class="col-sm-7">
												<div class="accordion" id="themeAccordion">
													<!-- Section 1 -->
													<div class="card">
														<div class="card-header p-2">
															<button class="btn btn-link p-0" type="button" data-toggle="collapse" data-target="#sectionOne">
																Section 1 - Main Banner and Link
															</button>
														</div>
														<div id="sectionOne" class="collapse" data-parent="#themeAccordion">
															<div class="card-body p-2" id="section1">
																<div id="section1-entries">
																	<?php if (!empty($banner['theme_Section1'])): ?>
																		<?php foreach ($banner['theme_Section1'] as $entry): ?>
																			<div class="entry form-row align-items-end mb-2">
																				<div class="col-6">
																					<input type="text" class="form-control" name="section1_link[]" value="<?= esc($entry['link'] ?? '') ?>" placeholder="Link">
																				</div>
																				<div class="col-6">
																					<input type="file" class="form-control" name="section1_image[]" accept="image/*" onchange="previewImage(this)">
																					<input type="hidden" name="section1_image_old[]" value="<?= esc($entry['image'] ?? '') ?>">
																				</div>
																				<div class="col-12">
																					<?php if (!empty($entry['image'])): ?>
																						<img src="<?= base_url('/public/uploads/themes/' . $entry['image']) ?>" class="preview img-thumbnail" style="width: 100px; height: 100px;">
																					<?php endif; ?>
																				</div>
																			</div>
																		<?php endforeach; ?>
																	<?php else: ?>
																		<div class="entry form-row align-items-end mb-2">
																			<div class="col-6">
																				<input type="text" class="form-control" name="section1_link[]" placeholder="Link">
																			</div>
																			<div class="col-6">
																				<input type="file" class="form-control" name="section1_image[]" accept="image/*" onchange="previewImage(this)">
																			</div>
																			<div class="col-12 mt-2">
																				<img class="preview img-thumbnail" style="width: 100px; height: 100px; display: none;">
																			</div>
																		</div>
																	<?php endif; ?>
																</div>
																<div class="text-end mt-2">
																	<button type="button" class="btn btn-success btn-sm" onclick="addEntry('section1')">+</button>
																	<button type="button" class="btn btn-danger btn-sm" onclick="removeEntry('section1')">−</button>
																</div>
															</div>
														</div>
													</div>

													<!-- Section 2 -->
													<div class="card mt-2">
														<div class="card-header p-2">
															<button class="btn btn-link p-0" type="button" data-toggle="collapse" data-target="#sectionTwo">
																Section 2 - Carousel Images and Links
															</button>
														</div>
														<div id="sectionTwo" class="collapse" data-parent="#themeAccordion">
															<div class="card-body p-2" id="section2">
																<div id="section2-entries">
																	<?php if (!empty($banner['theme_Section2'])): ?>
																		<?php foreach ($banner['theme_Section2'] as $entry): ?>
																			<div class="entry form-row align-items-end mb-2">
																				<div class="col-6">
																					<input type="text" class="form-control" name="section2_link[]" value="<?= esc($entry['link'] ?? '') ?>" placeholder="Link">
																				</div>
																				<div class="col-6">
																					<input type="text" class="form-control" name="section2_name[]" value="<?= esc($entry['name'] ?? '') ?>" placeholder="Name">
																				</div>
																				<div class="col-12 mt-2">
																					<input type="file" class="form-control" name="section2_image[]" accept="image/*" onchange="previewImage(this)">
																					<input type="hidden" name="section2_image_old[]" value="<?= esc($entry['image'] ?? '') ?>">
																				</div>
																				<div class="col-12">
																					<?php if (!empty($entry['image'])): ?>
																						<img src="<?= base_url('/public/uploads/themes/' . $entry['image']) ?>" class="preview img-thumbnail" style="width: 100px; height: 100px;">
																					<?php endif; ?>
																				</div>
																			</div>
																		<?php endforeach; ?>
																	<?php else: ?>
																		<div class="entry form-row align-items-end mb-2">
																			<div class="col-6">
																				<input type="text" class="form-control" name="section2_name[]" placeholder="Name">
																			</div>
																			<div class="col-6">
																				<input type="text" class="form-control" name="section2_link[]" placeholder="Link">
																			</div>
																			<div class="col-12 mt-2">
																				<input type="file" class="form-control" name="section2_image[]" accept="image/*" onchange="previewImage(this)">
																			</div>
																			<div class="col-12">
																				<img class="preview img-thumbnail" style="width: 100px; height: 100px; display: none;">
																			</div>
																		</div>
																	<?php endif; ?>
																</div>
																<div class="text-end mt-2">
																	<button type="button" class="btn btn-success btn-sm" onclick="addEntry('section2')">+</button>
																	<button type="button" class="btn btn-danger btn-sm" onclick="removeEntry('section2')">−</button>
																</div>
															</div>
														</div>
													</div>

													<!-- Section 3 -->
													<div class="card mt-2">
														<div class="card-header p-2">
															<button class="btn btn-link p-0" type="button" data-toggle="collapse" data-target="#sectionThree">
																Section 3 - Bottom Image and Link
															</button>
														</div>
														<div id="sectionThree" class="collapse" data-parent="#themeAccordion">
															<div class="card-body p-2" id="section3">
																<div id="section3-entries">
																	<?php if (!empty($banner['theme_Section3'])): ?>
																		<?php foreach ($banner['theme_Section3'] as $entry): ?>
																			<div class="entry form-row align-items-end mb-2">
																				<div class="col-6">
																					<input type="text" class="form-control" name="section3_link[]" value="<?= esc($entry['link'] ?? '') ?>" placeholder="Link">
																				</div>
																				<div class="col-6">
																					<input type="file" class="form-control" name="section3_image[]" accept="image/*" onchange="previewImage(this)">
																					<input type="hidden" name="section3_image_old[]" value="<?= esc($entry['image'] ?? '') ?>">
																				</div>
																				<div class="col-12">
																					<?php if (!empty($entry['image'])): ?>
																						<img src="<?= base_url('/public/uploads/themes/' . $entry['image']) ?>" class="preview img-thumbnail" style="width: 100px; height: 100px;">
																					<?php endif; ?>
																				</div>
																			</div>
																		<?php endforeach; ?>
																	<?php else: ?>
																		<div class="entry form-row align-items-end mb-2">
																			<div class="col-6">
																				<input type="text" class="form-control" name="section3_link[]" placeholder="Link">
																			</div>
																			<div class="col-6">
																				<input type="file" class="form-control" name="section3_image[]" accept="image/*" onchange="previewImage(this)">
																			</div>
																			<div class="col-12 mt-2">
																				<img class="preview img-thumbnail" style="width: 100px; height: 100px; display: none;">
																			</div>
																		</div>
																	<?php endif; ?>
																</div>
																<div class="text-end mt-2">
																	<button type="button" class="btn btn-success btn-sm" onclick="addEntry('section3')">+</button>
																	<button type="button" class="btn btn-danger btn-sm" onclick="removeEntry('section3')">−</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											
											</div>
										</div>

										<!-- Hidden inputs to hold JSON -->
										<input type="hidden" name="theme_Section1" id="theme_Section1">
										<input type="hidden" name="theme_Section2" id="theme_Section2">
										<input type="hidden" name="theme_Section3" id="theme_Section3">

										<!-- Buttons -->
										<div class="row justify-content-center">
											<input type="hidden" name="theme_id"
												value="<?= isset($banner) ? $banner['theme_Id'] : '' ?>">
											<div class="button-group">
												<button type="button" class="btn btn-secondary"
													onclick="window.location.href='<?= base_url('themes'); ?>'">
													<i class="bi bi-x-circle"></i> Discard
												</button>
												<button type="button" class="btn btn-primary" id="main_home_submit" name="main_home_submit">
													<i class="bi bi-check-circle"></i> <?= isset($banner) ? 'Update' : 'Save'; ?>
												</button>
											</div>
										</div>
									</form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
            <div id="styleSelector"> </div>
        </div>
    </div>
</div>

