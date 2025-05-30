<?php
$decoded = json_decode($product['product_images'], true); // decode image JSON
$imageList = [];

if (is_array($decoded) && isset($decoded[0]['name']) && is_array($decoded[0]['name'])) {
    $imageList = $decoded[0]['name']; // array of image names
}
?>
<form action="<?= base_url('product/submit') ?>" method="post" id="orderNowForm">

<?php $zd_uid = session()->get('zd_uid'); ?>
	<section class="hero-banner">
			<div class="container-lg">
				<div class="row">
					<div class="col-md-6">
    <div class="clearfix">
        <div class="pics clearfix">
            <!-- Thumbnails -->
            <div class="thumbs d-flex flex-column flex-wrap gap-2 mb-3">
                <?php foreach ($imageList as $imgName): ?>
                    <div class="prod-preview" >
                        <a href="#"
                           class="thumb-link"
                           data-full="<?= base_url('uploads/productmedia/' . $imgName); ?>"
                           data-title="<?= esc($product['pr_Name']); ?>">
                            <img src="<?= base_url('uploads/productmedia/' . $imgName); ?>"
                                 alt="" />
                        </a>
                    </div>
                <?php endforeach; ?>
				   <!-- Video Thumbnails -->
          
					<!-- Single Video Thumbnail -->
					<?php if (!empty($videoName)): ?>
						<div class="prod-preview" >
							<a href="#"
							   class="thumb-link"
							   data-type="video"
							   data-src="<?= base_url('uploads/productmedia/' . $videoName); ?>">
								<video
									src="<?= base_url('uploads/productmedia/' . $videoName); ?>"
									muted preload="metadata">
								</video>
							</a>
						</div>
					<?php endif; ?>
            </div>
			
			 <div id="main-preview">
            <!-- Main image display -->
            <?php if (!empty($imageList)): ?>
                <a href="<?= base_url('ordernow/product/'. $product['pr_Id']); ?>" class="full" id="main-image-link" title="<?= esc($product['pr_Name']); ?>">
                    <img id="main-image"
                         src="<?= base_url('uploads/productmedia/' . $imageList[0]); ?>"
                         alt="<?= esc($product['pr_Name']); ?>" />
                </a>
				<?php elseif (!empty($videoName)): ?>
					<img id="main-image"
						 src="<?= base_url('assets/img/video-placeholder.jpg'); ?>" 
						 alt="Video Placeholder"
						 style="width: 100%; max-height: 600px; object-fit: contain;" />
				<?php endif; ?>
				</div>

        </div>
    </div>
	
</div>

					<div class="col-md-6 prod-detail-block">
						<div class="row">
							<div class="clearfix">&nbsp;</div>
							<div id="messageBox" class="alert" style="display: none;"></div>
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
								<div class="col-md-12"><b>Size</b></div>
								<?php $sizes = explode(',', $product['pr_Size']); ?>
								<div class="col-md-12 size">
									<select name="size" id="size" class="form-control" required>
										<option value="">Size</option> <!-- Add this -->
										<?php foreach ($sizes as $size): ?>
											<option value="<?= esc(trim($size)) ?>"
												<?= trim($size) == ($selectedSize ?? '') ? 'selected' : '' ?>>
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
										<div class="col-md-1 cpicker" name="selected_color" id="selected_color" style="background-color:<?= esc(trim($color)); ?> " onclick="selectColor('<?= trim($color); ?>', this)">&nbsp;</div>
									<?php endforeach; ?>
								</div>
								 <div class="col-md-12 price-block">
									<span class="actualprice"><i class="bi bi-currency-rupee"></i><?= esc($product['mrp']); ?></span>
									<span class="offerprice"><i class="bi bi-currency-rupee"></i><?= esc($product['pr_Selling_Price']); ?></span>
								</div>
								
								<div class="col-md-12 stock-block">
									<select name="qty" id="qty">
										<option value="">Quantity</option>
										<?php for ($i = 1; $i <= 5; $i++): ?>
											<option value="<?= $i; ?>"><?= $i; ?></option>
										<?php endfor; ?>
									</select>
									
									<input type="hidden" name="pr_Id" value="<?= $product['pr_Id'] ;?>">
									<input type="hidden" name="cust_Id" value="<?= $zd_uid; ?>">
									<button class="btn btn-dark" name="orderNowBtn" id="orderNowBtn" >
											Order Now
										</button>
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
	</form>
<script>
function selectColor(color, element) {
    document.getElementById('selected_color').value = color;

    // Remove highlight from all
    document.querySelectorAll('.cpicker').forEach(el => el.style.border = 'none');

    // Highlight selected
    element.style.border = '3px solid #000';
}
</script>
