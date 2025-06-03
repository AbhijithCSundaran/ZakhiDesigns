<section class="hero-banner">
    <div class="container-lg">
        <h4>PLACE YOUR ORDER ENQUIRY</h4>
        <div class="row order-box">
		<div> &nbsp;</div>
            <!-- Left Panel: Order Form -->
            <div class="col-md-7">
                <div class="mb-3">
                    <h6>Submit the order form to place your order.</h6>
                </div>
                <form id="order" method="post" action="<?= base_url('ordernow/submit') ?>">
                    <div id="messageBox" class="alert" style="display: none;"></div>

                    <!-- Default Address Section -->
                 <!-- Accordion Starts -->
<div class="accordion mt-4" id="addressAccordion">

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
    <input type="text" id="fname" class="form-control" name="fname" value="<?= esc($details['add_Name'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label>Place</label>
    <input type="text" id="Place" class="form-control" name="place" value="<?= esc($details['add_City'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" id="emailid" class="form-control" name="email" value="<?= esc($details['add_Email'] ?? '') ?>">
  </div>
  <div class="mb-3">
    <label>Contact No.</label>
    <input type="text" id="contactno" class="form-control" name="phone" value="<?= esc($details['add_Phone'] ?? '') ?>">
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

  <!-- Choose Existing Address Section -->
  <div class="accordion-item">
   <h2 class="accordion-header" id="headingExisting">
  <div class="d-flex justify-content-between align-items-center w-100">
 <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExisting" aria-expanded="false" aria-controls="collapseExisting">
        Choose Existing Address
      </button>
  
   
  </div>
</h2>

    <div id="collapseExisting" class="accordion-collapse collapse" aria-labelledby="headingExisting" data-bs-parent="#addressAccordion">
      <div class="accordion-body">
        <h6>Select an address</h6>
        <?php foreach ($addresses as $addr): ?>
          <div class="card mb-2 p-2">
            <input type="radio" name="selectedAddress" value="<?= $addr['add_Id'] ?>" onclick="loadAddress(<?= $addr['add_Id'] ?>)">
            <?= esc($addr['add_Name']) ?>, <?= esc($addr['add_City']) ?>, <?= esc($addr['add_Phone']) ?>
          </div>
        <?php endforeach; ?>
      </div>
	  <button id="useSelectedAddressBtn" onclick="useSelectedAddress()" class="btn btn-primary">
      Use This Address
    </button>
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
	  <form id="orderaddress" method="post" >
        <div class="mb-2"><input type="text" class="form-control" name="newName" placeholder="Full Name"></div>
        <div class="mb-2"><input type="email" class="form-control" name="newEmail" placeholder="Email"></div>
        <div class="mb-2"><input type="text" class="form-control" name="newPhone" placeholder="Phone"></div>
        <div class="mb-2"><input type="text" class="form-control" name="newBuilding" placeholder="Building No."></div>
        <div class="mb-2"><input type="text" class="form-control" name="newStreet" placeholder="Street"></div>
        <div class="mb-2"><input type="text" class="form-control" name="newLandmark" placeholder="Landmark"></div>
        <div class="mb-2"><input type="text" class="form-control" name="newCity" placeholder="City"></div>
        <div class="mb-2"><input type="text" class="form-control" name="newState" placeholder="State"></div>
        <div class="mb-2"><input type="text" class="form-control" name="newPincode" placeholder="Pincode"></div>
        <div class="mb-2">
          <label><input type="checkbox" name="setAsDefault" value="1"> Set as default</label>
        </div>
		<button type="button" class="btn btn-link" onclick="saveAndSetAddress();">Add New Address</button>

		</form>
      </div>
    </div>
  </div>

</div>
<!-- Accordion Ends -->

				</form>
				<div id="messageBox" class="alert" style="display: none;"></div>
				<div id="responseMsg" style="margin-top: 20px; color: green;"></div>
                    
                    <div class="row">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-9">
							<button type="submit" class="btn btn-dark" id="orderNowBtn">Order Now</button>
						</div>
                    </div>
					<input type="hidden" name="od_Id" value="<?= $details['od_Id'] ;?>">
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
					$firstImage = '';

					if (is_array($decoded) && isset($decoded[0]['name'][0])) {
						$firstImage = base_url('uploads/productmedia/' . $decoded[0]['name'][0]);
					} else {
						$firstImage = base_url('assets/img/no-image.png'); // fallback image
					}
					?>

					<div class="col-md-5">
						<img src="<?= $firstImage ?>" style="width: 100px;" alt="Product Image" />
					</div>
                    <div class="col-md-7">
                        <div class="item-name text-left"><b><?= esc($details['pr_Name'] ?? '');?></b></div>
                        <div class="item-desc text-left">
                            <p>Product Code: <?= esc($details['pr_Code'] ?? '');?>
							</p>
                        </div>
                        <div class="item-price text-left">
								Price: <i class="bi bi-currency-rupee"></i> <?= esc($details['od_Selling_Price'] ?? ''); ?>
							</div>

							<div class="item-price text-left">
								Quantity: <?= esc($details['od_Quantity'] ?? ''); ?>
							</div>

							<div class="item-price text-left">
								Grand total: <i class="bi bi-currency-rupee"></i> <?= esc($details['od_Grand_Total'] ?? ''); ?>
							</div>
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
