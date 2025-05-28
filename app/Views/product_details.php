	<?php
$images = json_decode($product['product_images'], true);
$firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.png';
?>
	<section class="hero-banner">
			<div class="container-lg">
				<div class="row">
					<div class="col-md-6">
						<div class="clearfix">
							<div class="pics clearfix">
								<div class="thumbs">
									<?php foreach ($images as $img): ?>
										<div class="preview">
											<a href="#"
											   data-full="<?= base_url('uploads/productmedia/' . $img['name'][0]); ?>"
											   data-title="<?= esc($product['pr_Name']); ?>">
												<img src="<?= base_url('uploads/productmedia/' . $img['name'][0]); ?>" />
											</a>
										</div>
									<?php endforeach; ?>
								</div>

								<!-- Main image display -->
								<a href="#" class="full" id="main-image-link" title="<?= esc($product['pr_Name']); ?>">
									<img id="main-image" src="<?= base_url('uploads/productmedia/' . $images[0]['name'][0]); ?>" alt="">
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-6 prod-detail-block">
						<div class="row">
							<div class="clearfix">&nbsp;</div>
							<div class="col-md-12">
								<div class="prod-name"><?= esc($product['pr_Name']); ?></div>
								<div class="star-rate text-left">
									<i class="bi bi-star-fill gold"></i>
									<i class="bi bi-star-fill gold"></i>
									<i class="bi bi-star-fill gold"></i>
									<i class="bi bi-star-fill"></i>
									<i class="bi bi-star-fill"></i>
									0 Reviews
								</div>
								<div class="col-md-12">
									<p><?= esc($product['pr_Description']); ?></p>
								</div>
								<div class="col-md-12">
									<b>Size</b>
								</div>
								<?php
									$sizes = explode(',', $product['pr_Size']); // Assuming pr_Size holds "S,M,L,XL,XXL"
								?>

								<div class="col-md-12 size">
									<select>
										<?php foreach ($sizes as $size): ?>
											<option><?= esc(trim($size)); ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-12 colorblock">
									<b>Color</b>
								</div>
								<?php
									$colors = explode(',', $product['pr_Aval_Colors']); // Assuming pr_Color is the DB field
								?>

								<div class="col-md-12 color-box">
									<?php foreach ($colors as $color): ?>
										<div class="col-md-1 cpicker" style="background-color:<?= esc(trim($color)); ?>">&nbsp;</div>
									<?php endforeach; ?>
								</div>
								 <div class="col-md-12 price-block">
									<span class="actualprice"><i class="bi bi-currency-rupee"></i><?= esc($product['mrp']); ?></span>
									<span class="offerprice"><i class="bi bi-currency-rupee"></i><?= esc($product['pr_Selling_Price']); ?></span>
								</div>
								
								<div class="col-md-12 stock-block">
									<select>
										<option value="">Quantity</option>
										<?php for ($i = 1; $i <= 5; $i++): ?>
											<option value="<?= $i; ?>"><?= $i; ?></option>
										<?php endfor; ?>
									</select>
									<input type="hidden" name="pr_Id" value="<?= $product['pr_Id'] ;?>">
									<button class="btn btn-dark" onclick="window.location.href='<?= base_url('ordernow?pr_Id=' . $product['pr_Id']); ?>'">Order Now</button>
								</div>
								<div class="col-md-12">
									<?php if ($product['pr_Stock'] > 1): ?>
										<span class="badge badge-success">In stock</span>
									<?php elseif ($product['pr_Stock'] == 1): ?>
										<span class="badge badge-warning" style="padding:10px;">Only 1 left in stock</span>
									<?php else: ?>
										<span class="badge badge-danger">Out of stock</span>
									<?php endif; ?>
								</div>

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