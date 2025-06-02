<section class="hero-banner">
    <div class="container-lg">
        <h4>PLACE YOUR ORDER ENQUIRY</h4>
        <div class="row order-box">
            <div class="col-md-7">
                <form id="order" method="post" action="<?= base_url('ordernow/submit') ?>">
				<div id="messageBox" class="alert" style="display: none;"></div>
				<div id="responseMsg" style="margin-top: 20px; color: green;"></div>
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
                            <input type="text" class="form-control" id="fname">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="Place" class="form-label">Place</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="Place" placeholder="eg. your place, state">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="emailid" class="form-label">Email Id</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="emailid" placeholder="eg. ra****@mail.com">
                            <small>The order details will be sent to the provided email address.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="contactno" class="form-label">Contact No.</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="contactno" placeholder="eg. +91 98********" />
                            <small>Our executive will reach out to you at this number.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="contactno" class="form-label">Delivery Address</label>
                        </div>
                        <div class="col-md-9">
                            <textarea class="form-control"></textarea>
                            <small>Your order will be delivered to the specified address.</small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">&nbsp;</div>
                        <div class="col-md-9">
							<button type="submit" class="btn btn-dark" id="orderNowBtn">Order Now</button>
						</div>
                    </div>
					<input type="hidden" name="od_Id" value="<?= $details['od_Id'] ;?>">
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
                        <div class="item-name text-left"><b>Lorem Ipsum</b></div>
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