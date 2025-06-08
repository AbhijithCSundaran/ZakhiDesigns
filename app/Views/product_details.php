<?php
$decoded = json_decode($product['product_images'], true); // decode image JSON
$imageList = [];

if (is_array($decoded) && isset($decoded[0]['name']) && is_array($decoded[0]['name'])) {
	$imageList = $decoded[0]['name']; // array of image names
}
?>


	<?php $zd_uid = session()->get('zd_uid'); ?>
	<section class="hero-banner">
		<div class="container-lg">
			<div class="row">
				<div class="col-md-6">
					<div class="clearfix">
						<div class="pics clearfix">
							<!-- Thumbnails -->
							<div class="thumbs d-flex flex-column flex-wrap gap-2 mb-3">	
								<?php 	
								foreach ($imageList as $imgName): ?>
									<div class="prod-preview">
										<a href="#" class="thumb-link" data-type="image"
											data-src="<?= base_url('uploads/productmedia/' . $imgName); ?>"
											data-title="<?= esc($product['pr_Name']); ?>">
											<img src="<?= base_url('uploads/productmedia/' . $imgName); ?>" alt="" />
										</a>
									</div>
								<?php endforeach; ?>
								<!-- Video Thumbnails -->

								<!-- Single Video Thumbnail -->
								<?php if (!empty($videoName)): ?>
									<div class="prod-preview">
										<a href="#" class="thumb-link" data-type="video"
											data-src="<?= base_url('uploads/productmedia/' . $videoName); ?>">
											<video src="<?= base_url('uploads/productmedia/' . $videoName); ?>" muted
												preload="metadata">
											</video>
										</a>
									</div>
								<?php endif; ?>
							</div>
							<div id="main-preview">
								<!-- Main image display -->
								<?php if (!empty($imageList)): ?>
									<!-- <a href="<?= base_url('ordernow/product/' . $product['pr_Id']); ?>" class="full" id="main-image-link" title="<?= esc($product['pr_Name']); ?>"> -->
									<img id="main-image"
										src="<?= base_url(relativePath: 'uploads/productmedia/' . $imageList[0]); ?>"
										alt="<?= esc($product['pr_Name']); ?>" />
									<!-- </a> -->
								<?php elseif (!empty($videoName)): ?>
									<!-- <img id="main-image"
									src="<?= base_url('assets/img/video-placeholder.jpg'); ?>" 
									alt="Video Placeholder"
									style="width: 100%; max-height: 600px; object-fit: contain;" /> -->
									<video src="<?= base_url('uploads/productmedia/' . $videoName); ?>" controls
										autoplay></video>
								<?php endif; ?>
							</div>

						</div>
					</div>

				</div>
				<div class="col-md-6 prod-detail-block">
					<div class="row">
					<form action="<?= base_url('product/submit') ?>" method="post" id="orderNowForm">
						<div class="clearfix">&nbsp;</div>
						<div id="messageBox" class="alert" style="display: none;"></div>
						<div class="col-md-12">
							<div class="prod-name"><?= esc($product['pr_Name']); ?></div>
							<div class="star-rate text-left">
		
								<?php 
								$avg = round($product['avg_rating'] ?? 0, 1);
								for ($i = 1; $i <= 5; $i++) {
									if ($avg >= $i) {
										echo '<i class="bi bi-star-fill gold"></i>';
									} elseif ($avg >= ($i - 0.5)) {
										echo '<i class="bi bi-star-half gold"></i>';
									} else {
										echo '<i class="bi bi-star"></i>';
									}
								}
								?>
				
							</div>
							<?php if (!empty($product['pr_Description'])): ?>
								<div class="col-md-12">
									<p><?= esc($product['pr_Description']); ?></p>
								</div>
							<?php endif; ?>

							<?php if (!empty($product['pr_Fabric'])): ?>
								<div class="col-md-12">
									<b>Fabric</b>
									<span>: <?= esc($product['pr_Fabric']); ?></span>
								</div>
							<?php endif; ?>

							<?php if (!empty($product['pr_Sleeve_Style'])): ?>
								<div class="col-md-12">
									<b>Sleeve</b>
									<span>: <?= esc($product['pr_Sleeve_Style']); ?></span>
								</div>
							<?php endif; ?>

							<?php if (!empty($product['pr_Stitch_Type'])): ?>
								<div class="col-md-12">
									<b>Stitch Type</b>
									<span>: <?= esc($product['pr_Stitch_Type']); ?></span>
								</div>
							<?php endif; ?>
							<div class="col-md-12"><b>Size</b></div>
							<?php $sizes = explode(',', $product['pr_Size']); ?>
							<select name="size" id="size" style="width: 100px;" required>
								<option value="">Size</option> <!-- Add this -->
								<?php foreach ($sizes as $size): ?>
									<option value="<?= esc(trim($size)) ?>" <?= trim($size) == ($selectedSize ?? '') ? 'selected' : '' ?>>
										<?= esc(trim($size)) ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-md-12 colorblock">
							<b>Color</b>
						</div>
						<input type="hidden" name="selected_color" id="selected_color">

						<?php
						$colors = explode(',', $product['pr_Aval_Colors']); // Assuming pr_Color is the DB field
						?>

						<div class="col-md-12 color-box">
							<?php foreach ($colors as $color): ?>
								<div class="col-md-1 cpicker" name="selected_color" id="selected_color"
									style="background-color:<?= esc(trim($color)); ?> "
									onclick="selectColor('<?= trim($color); ?>', this)">&nbsp;</div>
							<?php endforeach; ?>
						</div>
						<div class="col-md-12 price-block">
							<span class="actualprice"><i
									class="bi bi-currency-rupee"></i><?= esc($product['mrp']); ?></span>
							<span class="offerprice"><i
									class="bi bi-currency-rupee"></i><?= esc($product['pr_Selling_Price']); ?></span>
						</div>


						<?php if ($product['pr_Stock'] > 0): ?>
							<div class="col-md-12 stock-block">
								<select name="qty" id="qty">
									<option value="">Quantity</option>
									<?php
									// Limit to 5 if more than 5 in stock, otherwise allow up to stock count
									$maxQty = ($product['pr_Stock'] > 5) ? 5 : $product['pr_Stock'];
									for ($i = 1; $i <= $maxQty; $i++): ?>
										<option value="<?= $i; ?>"><?= $i; ?></option>
									<?php endfor; ?>
								</select>

								<input type="hidden" name="pr_Id" value="<?= $product['pr_Id']; ?>">
								<input type="hidden" name="cust_Id" value="<?= $zd_uid; ?>">

								<button class="btn btn-dark" name="orderNowBtn" id="orderNowBtn">Order Now</button>
							</div>
						<?php else: ?>
							<div class="col-md-12">
								<span class="badge badge-danger">Out of stock</span>
								<div class="text-danger mt-2">This product is currently out of stock.</div>
							</div>
						<?php endif; ?>

						<!-- Stock status badge (always shown) -->
						<?php if ($product['pr_Stock'] > 1): ?>
							<div class="col-md-12"><span class="badge badge-success">In stock</span></div>
						<?php elseif ($product['pr_Stock'] == 1): ?>
							<div class="col-md-12"><span class="badge badge-warning" style="padding:10px;">Only 1 left in
									stock</span></div>
						<?php endif; ?>

					</form>

						<div class="col-md-12">
							<div class="clearfix">&nbsp;</div>
							<div class="col-md-12 imp-text">
								<i class="bi bi-shield-check"></i> Secure Transaction
							</div>
							<div class="col-md-12 imp-text">
								<i class="bi bi-truck"></i> Free Delivery
							</div>
							<div class="col-md-12 imp-text">
								<i class="bi bi-arrow-return-left"></i> 7 Days Replacement
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		</div>
	</section>
	<section>
			<div class="container-lg">
				<div class="row">

					<h4 class="mb-3">Similar Products</h4>
					<div class="owl-carousel" id="similar-carousel">
						<?php 
						if (!empty($similar)): ?>
							<?php foreach ($similar as $item): ?>
							 <?php
							 if (!empty($item['product_images'])) {
								
								$decoded = json_decode($item['product_images'], true);
								$firstImage = is_array($decoded) && isset($decoded[0]['name'][0])
									? base_url('uploads/productmedia/' . $decoded[0]['name'][0])
									: base_url('assets/img/no-image.png');		
							 }
                
							?>
								<div class="item">
									<div class="col-md-5">
											<img src="<?= $firstImage ?>" style="width: 100px;" alt="Product Image" />
										</div>
									<div class="star-rate">
										<?php 
											$fullStars = round($item['ratings']);
											for ($i = 1; $i <= 5; $i++): ?>
												<i class="bi bi-star-fill <?= $i <= $fullStars ? 'gold' : '' ?>"></i>
										<?php endfor; ?>
									</div>
									<div class="item-name"><?= esc($item['pr_Name']) ?></div>
									<div class="item-price">
									</div>
									<div class="col-md-12 text-center">
										<button onclick="location.href='<?= site_url('product-details/' . $item['pr_Id']) ?>'" class="order-btn">
											Order Now
										</button>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<p>No similar products found.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
		


<script>
	function selectColor(color, element) {
		document.getElementById('selected_color').value = color;

		// Remove highlight from all
		document.querySelectorAll('.cpicker').forEach(el => el.style.border = 'none');

		// Highlight selected
		element.style.border = '3px solid #000';
	}
</script>