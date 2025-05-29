<section class="hero-banner">
    <div class="container-lg">
        <h4>PLACE YOUR ORDER ENQUIRY</h4>
        <div class="row order-box">
            <div class="col-md-7">
                <form id="order">
                    <div class="row">
                        <div class="col-md-12">
                            <h6>Submit the order form to place your order.</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="fname" class="form-label">Fullname</label>
                        </div>
                        <div class="col-md-9">
                           
							 <input type="text" class="form-control" id="fname" name="fname" 
               value="<?= esc($details['add_Name'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Place" class="form-label">Place</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Place"  value="<?= esc($details['add_City'] ?? '') ?>" placeholder="eg. your place, state">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="emailid" class="form-label">Email Id</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="emailid" value="<?= esc($details['add_Email'] ?? '') ?>"  placeholder="eg. ra****@mail.com">
                            <small>The order details will be sent to the provided email address.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="contactno" class="form-label">Contact No.</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="contactno" value="<?= esc($details['add_Phone'] ?? '') ?>"  placeholder="eg. +91 98********" />
                            <small>Our executive will reach out to you at this number.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="contactno" class="form-label">Delivery Address</label>
                        </div>
                        <div class="col-md-9">
							
							<textarea class="form-control" rows="5"><?=
								esc(
									($details['add_BuldingNo'] ?? '') . ', ' .
									($details['add_Street'] ?? '') . "\n" .
									($details['add_Landmark'] ?? '') . "\n" .
									($details['add_City'] ?? '') . ', ' . ($details['add_State'] ?? '') . "\n" .
									($details['add_Pincode'] ?? '') . "\n" .
									($details['add_Phone'] ?? '')
								);
							?></textarea>
                            <small>Your order will be delivered to the specified address.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-dark">Order Now</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="clearfix">&nbsp;</div>
                    <div class="col-md-12">
                        <h6>Order Details</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
					<img src="<?= base_url('uploads/productmedia/' . $details['product_images']); ?>" style="width: 100px;" />
                    </div>
                    <div class="col-md-7">
                        <div class="item-name text-left"><b><?= esc($details['pr_Name'] ?? '');?></b></div>
                        <div class="item-desc text-left">
                            <p><?= esc($details['pr_Code'] ?? '');?>
							</p>
                        </div>
                        <div class="item-price text-left">Price: <i class="bi bi-currency-rupee"></i><?= esc($details['pr_Selling_Price'] ?? '');?></div>
                        <div class="item-price text-left">Quantity: <?= esc($details['od_Quantity'] ?? '');?></div>
                        <div class="item-price text-left">Grand total : <i class="bi bi-currency-rupee"></i><?= esc($details['or_Total_Price'] ?? '');?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="clearfix">&nbsp;</div>
                    <div class="col-md-12">
                        <h6>Important Note!</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>Once you submit the order form, our executive will contact you via phone or WhatsApp.
                            Each order will be dispatched only after confirmation through a call.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>