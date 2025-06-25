			<div class="container mt-4">
			    <ul class="nav nav-tabs" id="profileTabs" role="tablist">
			        <li class="nav-item">
			            <a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab">Profile</a>
			        </li>
			        <li class="nav-item">
			            <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address" role="tab">Address</a>
			        </li>
			        <li class="nav-item">
			            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab">Orders</a>
			        </li>
			        <li class="nav-item">
			            <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab">Change
			                Password</a>
			        </li>
			    </ul>

			    <div class="tab-content" id="profileTabContent">
			        <div id="messageBox" class="alert" style="display: none;"></div>
			        <div> &nbsp; </div>
			        <!-- Profile Tab -->
			        <div class="tab-pane fade show active" id="profile" role="tabpanel">
			            <div class="row">
			                <div class="col-md-6">
			                    <form id="profileForm" method="post">
			                        <?php if (!empty($user)): ?>
			                        <div>&nbsp;</div>
			                        <input type="text" name="name" id="name" class="form-control"
			                            value="<?= esc($user['cust_Name']) ?>" />
			                        <div>&nbsp;</div>
			                        <input type="email" name="email" id="email" class="form-control"
			                            value="<?= esc($user['cust_Email']) ?>" />
			                        <div>&nbsp;</div>
			                        <input type="tel" name="phone" id="phone" class="form-control"
										value="<?= esc($user['cust_Phone']) ?>"
										pattern="^\d{7,15}$" maxlength="15" required
										oninvalid="this.setCustomValidity('Phone number must be between 7 to 15 digits.')"
										oninput="this.setCustomValidity('')" />
			                        <div>&nbsp;</div>
			                        <?php else: ?>
			                        <div class="alert alert-danger">User information not found.</div>
			                        <?php endif; ?>
			                        <div class="text-end">
			                            <button class="btn btn-primary mt-2" type="submit">Update</button>
			                        </div>
			                        <div>&nbsp;</div>
			                    </form>

			                    <div>&nbsp;</div>
			                </div>
			            </div>
			        </div>

			        <!-- Address Tab -->
			        <div class="tab-pane fade" id="address" role="tabpanel">
			            <div>&nbsp;</div>

			            <div id="addressList">
			                <div class="row">
			                    <div class="col-md-6">
			                        <?php foreach ($addresses as $addr): ?>
			                        <div class="card p-2 mb-2">
			                            <strong><?= esc($addr['add_Name']) ?></strong><br>
			                            <?= esc($addr['add_BuldingNo']) ?>, <?= esc($addr['add_Street']) ?><br>
			                            <?= esc($addr['add_Landmark']) ?><br>
			                            <?= esc($addr['add_City']) ?>, <?= esc($addr['add_State']) ?> -
			                            <?= esc($addr['add_Pincode']) ?><br>
			                            Phone: <?= esc($addr['add_Phone']) ?> | Email: <?= esc($addr['add_Email']) ?><br>

			                            <div class="mt-2">
			                                <a href="javascript:void(0)" onclick="editAddress(<?= $addr['add_Id'] ?>)">Edit</a> |
			                                <a href="javascript:void(0)"
			                                    onclick="deleteAddress(<?= $addr['add_Id'] ?>)">Remove</a>
			                                <?php if (!empty($addr['add_Default']) && $addr['add_Default'] == 1): ?>
			                                | <span>Default</span>
			                                <?php else: ?>
			                                | <a href="javascript:void(0);"
			                                    onclick="setDefaultAddress(<?= $addr['add_Id'] ?>)">Set as Default</a>
			                                <?php endif; ?>
			                            </div>
			                        </div>
			                        <div> &nbsp; </div>
			                        <?php endforeach; ?>
			                        <button class="btn btn-success mb-2" onclick="openAddAddressForm()">+ Add Address</button>

			                    </div>
			                    <div id="addressFormContainer" style="display:none">
			                        <div class="row">
			                            <div class="col-md-6">
			                                <form id="addressForm">
			                                    <input type="hidden" name="id" id="addressId" />
			                                    <div class="mb-2">
			                                        <input type="text" class="form-control" id="newName" name="newName"
			                                            placeholder="Full Name" required>
			                                    </div>
			                                    <div class="mb-2"><input type="email" class="form-control" id="newEmail"
			                                            name="newEmail" placeholder="Email" required></div>
			                                   <div class="mb-2">
												<input type="tel" class="form-control" id="newPhone" name="newPhone"
													placeholder="Phone" maxlength="15" minlength="7"
													pattern="^\d{7,15}$" required>
													<small id="phoneError" style="color:red;">Phone Number Must Be Minimum 7 Digit</small>
											</div>
			                                    <div class="mb-2"><input type="text" class="form-control" id="newBuilding"
			                                            name="newBuilding" placeholder="Building No." required></div>
			                                    <div class="mb-2"><input type="text" class="form-control" id="newStreet"
			                                            name="newStreet" placeholder="Street" required></div>
			                                    <div class="mb-2"><input type="text" class="form-control" id="newLandmark"
			                                            name="newLandmark" placeholder="Landmark" required></div>
			                                    <div class="mb-2"><input type="text" class="form-control" id="newCity"
			                                            name="newCity" placeholder="City" required></div>
			                                    <div class="mb-2"><input type="text" class="form-control" id="newState"
			                                            name="newState" placeholder="State" required></div>
			                                    <div class="mb-2">
			                                        <input type="text" class="form-control" id="newPincode" name="newPincode"
			                                            placeholder="Pincode" maxlength="6" pattern="[1-9][0-9]{5}" required>
			                                    </div>

			                                    <label><input type="checkbox" name="is_default" /> Default</label>
			                                    <div class="text-end">
			                                        <button class="btn btn-secondary mt-2 me-2" type="button"
			                                            onclick="discardAddressForm()">Discard</button>
			                                        <button class="btn btn-success mt-2" type="submit">Save Address</button>
			                                    </div>
			                                </form>
			                            </div>
			                        </div>
			                    </div>
			                </div>
			            </div>
			        </div>
			        <!-- Orders Tab -->
			        <div class="tab-pane fade" id="orders" role="tabpanel">
			            <div>&nbsp;</div>
			            <div class="row">
			                <?php foreach ($orders as $order): ?>
			                <?php
								$decoded = json_decode($order['product_images'], true);
								$firstImage = is_array($decoded) && isset($decoded[0]['name'][0])
									? base_url('uploads/productmedia/' . $decoded[0]['name'][0])
									: base_url('assets/img/no-image.png');
							?>
			                <div class="col-md-6 mb-4">
			                    <div class="card p-3 shadow-sm h-100">
			                        <div class="row g-3 align-items-center">
			                            <div class="col-md-4">
			                                <a href="<?= base_url('product/product_details/' . $order['pr_Id']); ?>">
			                                    <img src="<?= esc($firstImage) ?>" class="img-fluid rounded"
			                                        style="max-width: 100%;" alt="Product Image" />
			                                </a>
			                            </div>
			                            <div class="col-md-8">
			                                <a href="<?= base_url('product/product_details/' . $order['pr_Id']); ?>"
			                                    class="text-decoration-none text-dark">
			                                    <strong><?= esc($order['pr_Name']) ?></strong><br>
			                                </a>
			                                Date: <?= date('d M Y', strtotime($order['od_createdon'])) ?><br>
			                                Size: <?= esc($order['od_Size']) ?><br>
			                                Quantity: <?= esc($order['od_Quantity']) ?><br>
			                                <b>Track your product:</b> <?= esc($order['tracker_Link']) ?><br>
			                                <a href="<?= base_url('review/' . $order['cus_Id'] . '/' . $order['pr_Id']) ?>"
			                                    class="btn btn-link p-0 mt-2">Write Review</a>

			                            </div>
			                        </div>
			                    </div>
			                </div>
			                <?php endforeach; ?>
			            </div>

			        </div>
			        <!-- Change Password Tab -->
			        <div class="tab-pane fade" id="password" role="tabpanel">
			            <div>&nbsp;</div>
			            <div class="row">
			                <div class="col-md-6">
			                    <form id="changePasswordForm" method="post">
			                        <div class="mb-2 position-relative">
			                            <input type="password" name="oldPassword" id="oldPassword" class="form-control"
			                                  maxlength="15"  placeholder="Old Password">
			                            <i class="toggle-password fa fa-eye-slash position-absolute"
			                                style="top: 12px; right: 10px; cursor: pointer;" data-target="oldPassword"></i>
			                        </div>
			                        <div class="mb-2 position-relative">
			                            <input type="password" name="newPassword" id="newPassword" class="form-control"
			                                  maxlength="15" placeholder="New Password">
			                            <i class="toggle-password fa fa-eye-slash position-absolute"
			                                style="top: 12px; right: 10px; cursor: pointer;" data-target="newPassword"></i>
			                        </div>
			                        <div class="mb-2 position-relative">
			                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control"
			                                  maxlength="15"  placeholder="Confirm Password">
			                            <i class="toggle-password fa fa-eye-slash position-absolute"
			                                style="top: 12px; right: 10px; cursor: pointer;" data-target="confirmPassword"></i>
			                        </div>
			                        <div class="text-end">
			                            <button class="btn btn-primary mt-2" type="submit">Update Password</button>
			                        </div>
			                        <div id="passwordResponse" class="mt-2"></div>
			                    </form>
			                </div>
			            </div>
			        </div>

			    </div>
			</div>
			<div>&nbsp; </div>
			</div>
			</div>
			</div>
			<!-- Edit Address Modal -->
			<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel"
			    aria-hidden="true">
			    <div class="modal-dialog">
			        <form id="editAddressForm" class="modal-content">
			            <div class="modal-header">
			                <!------------   <img src="<?= base_url('assets/logo.png') ?>" alt="Site Logo" height="30" class="me-2">------------>
			                <h5 class="modal-title" id="editAddressModalLabel">Update Address</h5>
			                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			            </div>
			            <div class="modal-body">
			                <input type="hidden" name="add_Id" id="add_Id" />							
			                <input type="hidden" name="add_CustId" id="add_CustId" />			             
							<input type="text" name="add_Name" id="add_Name" class="form-control" placeholder="Full Name" required>
							<div>&nbsp</div>
							<input type="tel" maxlength="10" pattern="[0-9]{10}" name="add_Phone" id="add_Phone" class="form-control" placeholder="Phone" required>
			                <div>&nbsp</div>
							<input type="email" name="add_Email" id="add_Email" class="form-control" placeholder="Email" required>
			               <div>&nbsp</div>
							<input type="text" name="add_BuldingNo" id="add_BuldingNo" class="form-control" placeholder="Building No"
			                    required>
			                <div>&nbsp</div>
								<input type="text" name="add_Street" id="add_Street" class="form-control" placeholder="Street" required>
			               <div>&nbsp</div>
								<input type="text" name="add_Landmark" id="add_Landmark" class="form-control" placeholder="Landmark">
			               <div>&nbsp</div>
								<input type="text" name="add_City" id="add_City" class="form-control" placeholder="City" required>
			                <div>&nbsp</div>
								<input type="text" name="add_State" id="add_State" class="form-control" placeholder="State" required>
			                <div>&nbsp</div>
								<input name="add_Pincode" id="add_Pincode" class="form-control" placeholder="Pincode" maxlength="6" pattern="[1-9][0-9]{5}"  required>
			                <div>&nbsp</div>
								<input type="checkbox" class="form-check-input" id="is_default" name="add_Default">
			                <div class="modal-footer">
			                    <button type="submit" class="btn btn-info mt-2">Update Address</button>
			                </div>
			            </div>
			        </form>
			    </div>
			</div>