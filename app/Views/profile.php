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
            <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab">Update Password</a>
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
                            <input type="text" name="profilename" id="profilename" class="form-control"
                                value="<?= esc($user['cust_Name']) ?>" />
                            <div>&nbsp;</div>
                            <input type="email" name="email" id="email" class="form-control"
                                value="<?= esc($user['cust_Email']) ?>" />
                            <div>&nbsp;</div>
                            <div class="phn_code">
                                <input id="phone" name="phone" type="tel" class="form-control" placeholder=""
                                    value="<?= esc($user['cust_Phone']) ?>" required>
                            </div>
                            <!-- <small class="form-text text-muted d-block">
                                Enter your phone number exactly as shown in the placeholder (e.g., <strong>098765
                                    43210</strong>), including the country code.
                            </small> -->
                            <div id="phone_error" class="text-danger small" style="display:none;"></div>
                            <div id="phone_valid" class="text-success small" style="display:none;">Valid Number</div>
                            <input type="hidden" name="cust_phcode" id="cust_phcode">
                            <div id="phone_format" class="text-muted small mt-1"></div>
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



            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert alert-success" id="flashMessage">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif; ?>

            <div id="addressList">
                <div class="row">
                    <?php if (!empty($addresses)): ?>
                        <div class="row">
                            <?php foreach ($addresses as $addr): ?>
                                <div class="col-md-6 mb-3">
                                    <div class="card p-3 h-100">
                                        <strong><?= esc($addr['add_Name']) ?></strong><br>
                                        <?= esc($addr['add_BuldingNo']) ?>, <?= esc($addr['add_Street']) ?><br>
                                        <?= esc($addr['add_Landmark']) ?><br>
                                        <?= esc($addr['add_City']) ?>, <?= esc($addr['add_State']) ?> -
                                        <?= esc($addr['add_Pincode']) ?><br>
                                        Phone: <?= esc($addr['add_Phone']) ?> | Email: <?= esc($addr['add_Email']) ?><br>
                                        <div class="mt-2">
                                            <a href="javascript:void(0)" onclick="editAddress(<?= $addr['add_Id'] ?>)">Edit</a>
                                            |
                                            <a href="#" onclick="openDeleteModal(<?= $addr['add_Id'] ?>)">Remove</a>
                                            <?php if (!empty($addr['add_Default']) && $addr['add_Default'] == 1): ?>
                                                | <span>Default</span>
                                            <?php else: ?>
                                                | <a href="javascript:void(0);"
                                                    onclick="setDefaultAddress(<?= $addr['add_Id'] ?>)">Set as Default</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-12">
                        <button class="btn btn-success mb-2" onclick="openAddAddressForm()">+ Add Address</button>

                        <!-- <a href="#" style="text-align:right;">Continue...</a> -->
                    </div>

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
                                <div class="mb-2"><input type="email" class="form-control" id="newEmail" name="newEmail"
                                        placeholder="Email" required></div>
                                <div class="mb-2 phn_code">



                                    <input type="tel" class="form-control" id="newPhone" name="newPhone" placeholder=""
                                        required>
                                    <!-- <small class="form-text text-muted d-block">
                                        Enter your phone number exactly as shown in the placeholder (e.g.,
                                        <strong>098765 43210</strong>), including the country code.
                                    </small> -->
                                    <div id="newPhone_error" class="text-danger small" style="display:none;"></div>
                                    <div id="newPhone_valid" class="text-success small" style="display:none;">Valid
                                        Number</div>
                                    <div id="newPhone_format" class="text-muted small mt-1"></div>
                                    <input type="hidden" name="new_phcode" id="new_phcode">
                                </div>

                                <div class="mb-2"><input type="text" class="form-control" id="newBuilding"
                                        name="newBuilding" placeholder="Building No." required></div>
                                <div class="mb-2"><input type="text" class="form-control" id="newStreet"
                                        name="newStreet" placeholder="Street" required></div>
                                <div class="mb-2"><input type="text" class="form-control" id="newLandmark"
                                        name="newLandmark" placeholder="Landmark" required></div>
                                <div class="mb-2"><input type="text" class="form-control" id="newCity" name="newCity"
                                        placeholder="City" required></div>
                                <div class="mb-2"><input type="text" class="form-control" id="newState" name="newState"
                                        placeholder="State" required></div>
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
                            <div>&nbsp;</div>
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
                                    <?php
                                    $statusMap = [
                                        1 => 'New',
                                        2 => 'Confirmed',
                                        3 => 'Packed',
                                        4 => 'Dispatched'
                                    ];
                                    ?>
                                    <b>Status:</b> <?= esc($statusMap[$order['od_Status']] ?? 'Unknown') ?><br>
                                    <?php if ($order['od_Status'] == 4): ?>
                                        <b>Track your product:</b> <a href="<?= esc($order['tracker_Link']) ?>"
                                            target="_blank"><?= esc($order['tracker_Link']) ?></a><br>
                                    <?php endif; ?>
                                    <a href="<?= base_url('review/' . $order['cus_Id'] . '/' . $order['pr_Id']) ?>"
                                        class="btn btn-link p-0 mt-2" style="text-decoration:none;">Add Feedback</a>

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
                                maxlength="15" placeholder="Old Password">
                            <i class="toggle-password fa fa-eye-slash position-absolute"
                                style="top: 12px; right: 10px; cursor: pointer;" data-target="oldPassword"></i>
                        </div>
                        <div class="mb-2 position-relative">
                            <input type="password" name="newPassword" id="newPassword" class="form-control"
                                maxlength="15" placeholder="New Password">
                            <i class="toggle-password fa fa-eye-slash position-absolute"
                                style="top: 12px; right: 10px; cursor: pointer;" data-target="newPassword"></i>
                        </div>
                        <div class="progress mt-2" id="new-password-strength-bar" style="height: 8px; display: none;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;"
                                id="new-password-strength-fill">
                            </div>
                        </div>
                        <small id="new-password-strength-text" class="fw-bold"></small>

                        <div class="mb-2 position-relative">
                            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control"
                                maxlength="15" placeholder="Confirm Password">
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

<!-- Edit Address Modal -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editAddressForm" class="modal-content">
            <div class="modal-header">
                <!------------   <img src="<?= base_url('assets/logo.png') ?>" alt="Site Logo" height="30" class="me-2">------------>
                <h5 class="modal-title" id="editAddressModalLabel">Update Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="editAlert"></div>
                <input type="hidden" name="add_Id" id="add_Id" />
                <input type="hidden" name="add_CustId" id="add_CustId" />
                <input type="text" name="add_Name" id="add_Name" class="form-control" placeholder="Full Name" required>
                <div>&nbsp</div>
                <div class="phn_code">
                    <input type="tel" maxlength="15" minlength="7" name="add_Phone" id="add_Phone" class="form-control"
                        placeholder="" required>
                    <!-- <small class="form-text text-muted d-block">
                        Enter your phone number exactly as shown in the placeholder (e.g., <strong>098765
                            43210</strong>), including the country code.
                    </small> -->
                    <div id="add_Phone_error" class="text-danger small" style="display:none;"></div>
                    <div id="add_Phone_valid" class="text-success small" style="display:none;">Valid Number</div>
                    <div id="add_Phone_format" class="text-muted small mt-1"></div>
                    <input type="hidden" name="add_phcode" id="add_phcode">
                </div>
                <div>&nbsp</div>
                <input type="email" name="add_Email" id="add_Email" class="form-control" placeholder="Email" required>
                <div>&nbsp</div>
                <input type="text" name="add_BuldingNo" id="add_BuldingNo" class="form-control"
                    placeholder="Building No" required>
                <div>&nbsp</div>
                <input type="text" name="add_Street" id="add_Street" class="form-control" placeholder="Street" required>
                <div>&nbsp</div>
                <input type="text" name="add_Landmark" id="add_Landmark" class="form-control" placeholder="Landmark">
                <div>&nbsp</div>
                <input type="text" name="add_City" id="add_City" class="form-control" placeholder="City" required>
                <div>&nbsp</div>
                <input type="text" name="add_State" id="add_State" class="form-control" placeholder="State" required>
                <div>&nbsp</div>
                <input name="add_Pincode" id="add_Pincode" class="form-control" placeholder="Pincode" maxlength="6"
                    pattern="[1-9][0-9]{5}" required>
                <div>&nbsp</div>
                <input type="checkbox" class="form-check-input" id="is_default" name="add_Default"> &nbsp; Default
                <input type="hidden" name="display_add_Id" id="display_add_Id" />
                <input type="hidden" name="pr_Id" id="pr_Id" />
                <div class="modal-footer">

                    <button type="submit" class="btn btn-info mt-2">Update Address</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Bootstrap Modal -->

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog" style="max-width: 500px; margin: 10px auto;">
        <div class="modal-content text-center p-4">
            <div class="modal-body">
                <h4 class="mb-3"><b>Are You Sure?</b></h4>
                <i class="fa fa-trash fa-5x animated-icon mb-3" style="color: gray;"></i>
                <p class="mb-4">Do you want to delete the address </p>
                <form method="post" action="<?= base_url('profile/deleteAddress') ?>">
                    <input type="hidden" id="delete_add_id" name="add_Id">
                    <div class="d-flex justify-content-center gap-2">
                        <button type="submit" onclick="confirmDeleteAddress()" class="btn btn-primary px-4">Yes</button>
                        <button type="button" class="btn px-4" style="background-color: black; color: white;"
                            data-bs-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>