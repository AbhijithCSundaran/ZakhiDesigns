<?php $hasDefaultAddress = !empty($details['address']);
?>

<section class="hero-banner">
    <div class="container-lg">
        <h4>PLACE YOUR ORDER</h4>
        <div class="row order-box">
            <div>&nbsp;</div>

            <!-- Left Panel: Order Form -->
            <div class="col-md-7">
                <div class="mb-3">
                    <h6>Submit To Confirm And Place Your Order.</h6>
                </div>

                <div id="messageBox" class="alert" style="display: none;"></div>

                <div class="accordion mb-4" id="addressAccordion">
                    <!-- Existing Addresses -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingSelect">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSelect">
                                Select Existing Address
                            </button>
                        </h2>
                        <div id="collapseSelect" class="accordion-collapse collapse show"
                            data-bs-parent="#addressAccordion">
                            <div class="accordion-body" id="selectExistAddress">
                                <?php if (!empty($addresses)): ?>
                                    <?php foreach ($addresses as $address): ?>
                                        <div class="form-check mb-2 position-relative">
 
                                            <input type="hidden" name="edit_address_id" id="edit_address_id" value="">
                                            <input type="hidden" name="edit_product_id" id="edit_product_id" value="">
                                            <input class="form-check-input" type="radio" name="address_id"
                                                value="<?= $address['add_Id'] ?>" <?= $address['add_Default'] ? 'checked' : '' ?>
                                                data-id="<?= $address['add_Id'] ?>" data-name="<?= esc($address['add_Name']) ?>"
                                                data-phone="<?= esc($address['add_Phone']) ?>"
                                                data-building="<?= esc($address['add_BuldingNo']) ?>"
                                                data-street="<?= esc($address['add_Street']) ?>"
                                                data-landmark="<?= esc($address['add_Landmark']) ?>"
                                                data-city="<?= esc($address['add_City']) ?>"
                                                data-pincode="<?= esc($address['add_Pincode']) ?>"
                                                data-state="<?= esc($address['add_State']) ?>"
                                                onchange="renderAddressLabel(this); toggleEditLinks();  saveSelectedAddress(this);">
                                            <label class="form-check-label" id="address-label-<?= $address['add_Id'] ?>">
                                                <!-- You can add some visible address preview if needed here -->
                                                <?= esc($address['add_Name']) ?>, <?= esc($address['add_City']) ?> -
                                                <?= esc($address['add_Pincode']) ?>                                                
                                            </label>
 
                                            <a href="<?= base_url('profile#address') ?>" class="edit-link btn btn-sm btn-link"
                                                data-id="<?= $address['add_Id'] ?>"
                                                data-product-id="<?= esc($od_Id) ?>" onclick="storeEditInfo(event)"
                                                style="display:none;"><span class="edit-address-orders" style="text-decoration: none;">Edit</span></a>
 
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No saved addresses. Please add a new address.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                  
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingNew">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNew">
                                Add New Address
                            </button>
                        </h2>
                        <div id="collapseNew" class="accordion-collapse collapse" data-bs-parent="#addressAccordion">
                            <div class="accordion-body">
                                <form id="newAddressForm">
                                    <input type="hidden" name="od_Id" value="<?= esc($od_Id) ?>">

                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <input type="text" name="newName" class="form-control" placeholder="Full Name" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="email" name="newEmail" class="form-control" placeholder="Email" required>
                                        </div>
                                        
                                           <div class="col-md-6 mb-2 phn_code">
                                <input name="newPhone" id="newPhone" type="tel" class="form-control" placeholder="" required>
                            </div>
                            <!-- <small class="form-text text-muted d-block">
                                Enter your phone number exactly as shown in the placeholder (e.g., <strong>098765
                                    43210</strong>), including the country code.
                            </small> -->
                            <div id="phone_error" class="text-danger small" style="display:none;"></div>
                            <div id="phone_valid" class="text-success small" style="display:none;">Valid Number</div>
                            <input type="hidden" name="newphcode" id="newphcode">
                              <div id="phone_format" class="text-muted small mt-1"></div>
                            <div>&nbsp;</div>
                                        <div class="col-md-6 mb-2">
                                            <input type="text" name="newBuilding" class="form-control" placeholder="Building No" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="text" name="newStreet" class="form-control" placeholder="Street" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="text" name="newLandmark" class="form-control" placeholder="Landmark">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="text" name="newCity" class="form-control" placeholder="City" required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="text" name="newState" class="form-control" placeholder="State" required pattern="[A-Za-z\s]+" title="No Numeric Or Special Characters Allowed">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <input type="text" name="newPincode" class="form-control" placeholder="Pincode" maxlength="6" pattern="[1-9][0-9]{5}" required>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary mt-2">Save & Use This Address</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div>&nbsp;</div>
                    <button class="btn btn-success" id="confirmOrderBtn" data-odid="<?= esc($od_Id) ?>">Confirm
                        Order</button>

                </div>

                <!-- Confirm Button -->
            </div>

            <!-- Right Panel: Product Summary -->
            <div class="col-md-5">
                <div class="mb-3">
                    <h6>Order Details</h6>
                </div>
                <div class="row">
                    <?php
                    $decoded = json_decode($product->product_images ?? '', true);
                    $firstImage = is_array($decoded) && isset($decoded[0]['name'][0])
                        ? base_url('uploads/productmedia/' . $decoded[0]['name'][0])
                        : base_url('assets/img/no-image.png');
                    ?>
                    <div class="col-md-5">
                        <img src="<?= $firstImage ?>" style="width: 100px;" alt="Product Image" />
                    </div>
                    <div class="col-md-7">
                        <div><b><?= esc($product->pr_Name ?? '') ?></b></div>
                        <p>Product Code: <?= esc($product->pr_Code ?? '') ?></p>
                        <p>Price: ₹<?= esc($order->od_Selling_Price ?? '') ?></p>
                        <p>Quantity: <?= esc($order->od_Quantity ?? '') ?></p>
                        <p>Grand Total: ₹<?= esc($order->od_Grand_Total ?? '') ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <h6>Important Note!</h6>
                    <p>Once you submit the order form, our executive will contact you via phone or WhatsApp. Your order
                        will be dispatched after confirmation via call.</p>
                </div>
            </div>
        </div>
    </div>
</section>
