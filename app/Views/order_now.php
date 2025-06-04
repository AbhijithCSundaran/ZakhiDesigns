<section class="hero-banner">
    <div class="container-lg">
        <h4>PLACE YOUR ORDER ENQUIRY</h4>
        <div class="row order-box">
            <div>&nbsp;</div>

            <!-- Left Panel: Order Form -->
            <div class="col-md-7">
                <div class="mb-3">
                    <h6>Submit the order form to place your order.</h6>
                </div>

                <form id="orderNowForm" method="post">
                    <div id="messageBox" class="alert" style="display: none;"></div>

                    <!-- Accordion Starts -->
                    <div class="accordion mt-4" id="addressAccordion">
						<form id="orderNowForm" name="orderNowForm" method="post" >
                        <!-- Default Address Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDefault">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDefault" aria-expanded="true" aria-controls="collapseDefault">
                                    Use Default Address
                                </button>
                            </h2>
                            <div id="collapseDefault" class="accordion-collapse collapse show" aria-labelledby="headingDefault" data-bs-parent="#addressAccordion">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label>Full Name</label>
                                        <input type="text" id="fname" class="form-control" name="fname" value="<?= esc($details['add_Name'] ?? '') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Place</label>
                                        <input type="text" id="Place" class="form-control" name="place" value="<?= esc($details['add_City'] ?? '') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" id="emailid" class="form-control" name="email" value="<?= esc($details['add_Email'] ?? '') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Contact No.</label>
                                        <input type="text" id="contactno" class="form-control" name="phone" value="<?= esc($details['add_Phone'] ?? '') ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Delivery Address</label>
                                        <textarea id="deliveryAddress" class="form-control" rows="5" name="address" readonly><?= esc(
                                            ($details['add_BuldingNo'] ?? '') . ', ' .
                                            ($details['add_Street'] ?? '') . "\n" .
                                            ($details['add_Landmark'] ?? '') . "\n" .
                                            ($details['add_City'] ?? '') . ', ' . ($details['add_State'] ?? '') . "\n" .
                                            ($details['add_Pincode'] ?? '') . "\n" .
                                            ($details['add_Phone'] ?? '')
                                        ) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
						</form>

                        <!-- Choose Existing Address Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingExisting">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExisting" aria-expanded="false" aria-controls="collapseExisting">
                                    Choose Existing Address
                                </button>
                            </h2>
                            <div id="collapseExisting" class="accordion-collapse collapse" aria-labelledby="headingExisting" data-bs-parent="#addressAccordion">
                                <div class="accordion-body">
                                    <h6>Select an address</h6>
                                    <?php foreach ($addresses as $addr): ?>
                                        <div class="card mb-2 p-2">
                                            <input type="radio" name="selectedAddress" value="<?= $addr['add_Id'] ?>">
                                            <?= esc($addr['add_Name']) ?>, <?= esc($addr['add_City']) ?>, <?= esc($addr['add_Phone']) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="text-end px-3 pb-3">
								
                                    <button type="button" id="useSelectedAddressBtn" class="btn btn-primary" disabled onclick="useSelectedAddress()">
                                        Use This Address
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Add New Address Section -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingNew">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNew" aria-expanded="false" aria-controls="collapseNew">
                                    Add New Address
                                </button>
                            </h2>
                            <div id="collapseNew" class="accordion-collapse collapse" aria-labelledby="headingNew" data-bs-parent="#addressAccordion">
                                <div class="accordion-body">
                                    <form id="orderAddressForm" >
                                        <div class="mb-2"><input type="text" class="form-control" id="newName" name="newName" placeholder="Full Name" required></div>
                                        <div class="mb-2"><input type="text" class="form-control" id="newEmail" name="newEmail" placeholder="Email" required></div>
                                        <div class="mb-2"><input type="text" class="form-control" id="newPhone" name="newPhone" placeholder="Phone" required></div>
                                        <div class="mb-2"><input type="text" class="form-control" id="newBuilding" name="newBuilding" placeholder="Building No." required></div>
                                        <div class="mb-2"><input type="text" class="form-control" id="newStreet" name="newStreet" placeholder="Street" required></div>
                                        <div class="mb-2"><input type="text" class="form-control" id="newLandmark" name="newLandmark" placeholder="Landmark" required></div>
                                        <div class="mb-2"><input type="text" class="form-control" id="newCity" name="newCity" placeholder="City" required></div>
                                        <div class="mb-2"><input type="text" class="form-control" id="newState" name="newState" placeholder="State" required></div>
                                        <div class="mb-2"><input type="text" class="form-control" id="newPincode" name="newPincode" placeholder="Pincode" required></div>
                                        <div class="mb-2">
                                            <label><input type="checkbox" id="newDefault" name="setAsDefault" value="1"> Set as default</label>
                                        </div>				
										<input type="hidden" name="od_Id" value="<?= esc($details['od_Id'] ?? '') ;?>">
                                        <div class="text-end">
                                            <button type="submit" onclick="saveAndSetAddress(event);" class="btn btn-primary">Add New Address</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Accordion Ends -->

                    <div class="mt-4 text-end">
                        <input type="hidden" name="od_Id" value="<?= esc($details['od_Id'] ?? '') ;?>">
                        <button type="submit" class="btn btn-dark" id="orderNowBtn">Order Now</button>
                    </div>
                </form>
            </div>

            <!-- Right Panel: Product Summary -->
            <div class="col-md-5">
                <div class="mb-3">
                    <h6>Order Details</h6>
                </div>
                <div class="row">
                    <?php
                        $decoded = json_decode($details['product_images'], true);
                        $firstImage = is_array($decoded) && isset($decoded[0]['name'][0])
                            ? base_url('uploads/productmedia/' . $decoded[0]['name'][0])
                            : base_url('assets/img/no-image.png');
                    ?>
                    <div class="col-md-5">
                        <img src="<?= $firstImage ?>" style="width: 100px;" alt="Product Image" />
                    </div>
                    <div class="col-md-7">
                        <div><b><?= esc($details['pr_Name'] ?? '') ?></b></div>
                        <p>Product Code: <?= esc($details['pr_Code'] ?? '') ?></p>
                        <p>Price: ₹<?= esc($details['od_Selling_Price'] ?? '') ?></p>
                        <p>Quantity: <?= esc($details['od_Quantity'] ?? '') ?></p>
                        <p>Grand Total: ₹<?= esc($details['od_Grand_Total'] ?? '') ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <h6>Important Note!</h6>
                    <p>Once you submit the order form, our executive will contact you via phone or WhatsApp. Your order will be dispatched after confirmation via call.</p>
                </div>
            </div>
        </div>
    </div>
</section>
