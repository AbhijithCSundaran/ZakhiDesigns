<?php $hasDefaultAddress = !empty($details['address']); 
?>

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

                <div id="messageBox" class="alert" style="display: none;"></div>

              <div class="accordion mb-4" id="addressAccordion">
        <!-- Existing Addresses -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingSelect">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSelect">
                    Select Existing Address
                </button>
            </h2>
            <div id="collapseSelect" class="accordion-collapse collapse show" data-bs-parent="#addressAccordion">
                <div class="accordion-body">
                    <?php if (!empty($addresses)): ?>
                        <?php foreach ($addresses as $address): ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="address_id" value="<?= $address['add_Id'] ?>" <?= $address['add_Default'] ? 'checked' : '' ?>>
                               <label class="form-check-label">
                                    <?= esc($address['add_Name']) ?> - <?= esc($address['add_Phone']) ?><br>
                                    <?= esc($address['add_BuldingNo']) ?>,
                                    <?= esc($address['add_Street']) ?>,
                                    <?= esc($address['add_Landmark']) ?>,<br>
                                    <?= esc($address['add_City']) ?> - <?= esc($address['add_Pincode']) ?><br>
                                    <?= esc($address['add_State']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No saved addresses. Please add a new address.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- New Address -->
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
                            <div class="col-md-6 mb-2"><input type="text" name="newName" class="form-control" placeholder="Full Name" required></div>
                            <div class="col-md-6 mb-2"><input type="email" name="newEmail" class="form-control" placeholder="Email" required></div>
                            <div class="col-md-6 mb-2"><input type="tel" maxlength="10" pattern="[0-9]{10}" name="newPhone" class="form-control" placeholder="Phone" required></div>
                            <div class="col-md-6 mb-2"><input type="text" name="newBuilding" class="form-control" placeholder="Building No" required></div>
                            <div class="col-md-6 mb-2"><input type="text" name="newStreet" class="form-control" placeholder="Street" required></div>
                            <div class="col-md-6 mb-2"><input type="text" name="newLandmark" class="form-control" placeholder="Landmark"></div>
                            <div class="col-md-6 mb-2"><input type="text" name="newCity" class="form-control" placeholder="City" required></div>
                            <div class="col-md-6 mb-2"><input type="text" name="newState" class="form-control" placeholder="State" required pattern="[A-Za-z\s]+" title="No Numeric Or Special Characters Allowed"></div>
                            <div class="col-md-6 mb-2"><input type="text" name="newPincode" class="form-control" placeholder="Pincode" maxlength="6" pattern="[1-9][0-9]{5}" required></div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Save & Use This Address</button>
                    </form>
                </div>
            </div>
        </div>
		<div>&nbsp;</div>
   <button class="btn btn-success" id="confirmOrderBtn" data-odid="<?= esc($od_Id) ?>">Confirm Order</button>
		
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
                        <p>Quantity: <?= esc($order->od_Quantity?? '') ?></p>
                        <p>Grand Total: ₹<?= esc($order->od_Grand_Total ?? '') ?></p>
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

<style>
.accordion-button {
    font-weight: bold;
    font-size: 1.1rem;
    color: #000;
    transition: all 0.3s ease;
}

.accordion-button:not(.collapsed) {
    color: goldenrod;
}
</style>
