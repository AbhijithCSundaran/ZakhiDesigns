<?php
$decoded = json_decode($product['product_images'], true);
$imageList = [];

if (is_array($decoded) && isset($decoded[0]['name']) && is_array($decoded[0]['name'])) {
    $imageList = $decoded[0]['name'];
}

if (empty($imageList)) {
    $imageList[] = 'default.jpg';
}

$zd_uid = session()->get('zd_uid');
?>

<section class="hero-banner">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-6">
                <div class="clearfix">
                    <div class="pics clearfix">
                        <!-- Thumbnails -->
                        <div class="thumbs d-flex flex-column flex-wrap gap-2 mb-3">
                            <?php foreach ($imageList as $imgName): ?>
                                <div class="prod-preview">
                                    <a href="#" class="thumb-link" data-type="image"
                                       data-src="<?= base_url('uploads/productmedia/' . $imgName); ?>"
                                       data-title="<?= esc($product['pr_Name']); ?>">
                                        <img src="<?= base_url('uploads/productmedia/' . $imgName); ?>" alt="" />
                                    </a>
                                </div>
                            <?php endforeach; ?>

                            <?php if (!empty($videoName)): ?>
                                <div class="prod-preview">
                                    <a href="#" class="thumb-link" data-type="video"
                                       data-src="<?= base_url('uploads/productmedia/' . $videoName); ?>">
                                        <video src="<?= base_url('uploads/productmedia/' . $videoName); ?>" muted preload="metadata"></video>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div id="main-preview">
                            <?php if (!empty($imageList)): ?>
                                <img id="main-image"
                                     src="<?= base_url('uploads/productmedia/' . $imageList[0]); ?>"
                                     alt="<?= esc($product['pr_Name']); ?>" />
                            <?php elseif (!empty($videoName)): ?>
                                <video src="<?= base_url('uploads/productmedia/' . $videoName); ?>" controls autoplay></video>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6 prod-detail-block">
                <div class="row">
				 <div id="messageBox" class="alert" style="display: none;"></div>
                    <form action="<?= base_url('product/submit') ?>" method="post" id="orderNowForm">
                        <div class="clearfix">&nbsp;</div>
                       
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
								<a href="#reviewsSection">
									<i class="bi bi text-warning"></i>
									<?= $total_reviews_count ?> Review<?= $total_reviews_count != 1 ? 's' : '' ?>
								</a>
                            </div>

                            <?php if (!empty($product['pr_Description'])): ?>
                                <div class="col-md-12">
                                    <p><?= esc($product['pr_Description']); ?></p>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($product['pr_Fabric'])): ?>
                                <div class="col-md-12"><b>Fabric</b><span>: <?= esc($product['pr_Fabric']); ?></span></div>
                            <?php endif; ?>

                            <?php if (!empty($product['pr_Sleeve_Style'])): ?>
                                <div class="col-md-12"><b>Sleeve</b><span>: <?= esc($product['pr_Sleeve_Style']); ?></span></div>
                            <?php endif; ?>

                            <?php if (!empty($product['pr_Stitch_Type'])): ?>
                                <div class="col-md-12"><b>Stitch Type</b><span>: <?= esc($product['pr_Stitch_Type']); ?></span></div>
                            <?php endif; ?>

                            <div class="col-md-12"><b>Size</b></div>
                            <?php $sizes = explode(',', $product['pr_Size']); ?>
                            <select name="size" id="size" style="width: 100px;" required>
                                <option value="">Size</option>
                                <?php foreach ($sizes as $size): ?>
                                    <option value="<?= esc(trim($size)) ?>" <?= trim($size) == ($selectedSize ?? '') ? 'selected' : '' ?>>
                                        <?= esc(trim($size)) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-12 colorblock"><b>Color</b></div>
                        <input type="hidden" name="selected_color" id="selected_color">

                        <?php $colors = explode(',', $product['pr_Aval_Colors']); ?>
                        <div class="col-md-12 color-box">
                            <?php foreach ($colors as $color): ?>
                                <div class="col-md-1 cpicker"
                                     style="background-color:<?= esc(trim($color)); ?>"
                                     onclick="selectColor('<?= trim($color); ?>', this)">&nbsp;
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="col-md-12 price-block">
							<?php if (!empty($product['pr_Discount_Value']) && $product['pr_Discount_Value'] > 0): ?>
								<!-- MRP with strikethrough -->
								<span class="actualprice text-muted" style="text-decoration: line-through;">
									<i class="bi bi-currency-rupee"></i><?= esc($product['mrp']); ?>
								</span>

								<!-- Selling Price -->
								<span class="offerprice">
									<i class="bi bi-currency-rupee"></i><?= esc($product['pr_Selling_Price']); ?>
								</span>

								<!-- Discount Value -->
								<span class="offer text-success ms-2">
									<?= esc($product['pr_Discount_Value']); ?><?= esc($product['pr_Discount_Type']); ?> off
								</span>
							<?php else: ?>
								<!-- Only Selling Price if no discount -->
								<span class="offerprice fw-bold text-danger">
									<i class="bi bi-currency-rupee"></i><?= esc($product['pr_Selling_Price']); ?>
								</span>
							<?php endif; ?>
						</div>


                        <?php
							$resetStock = $product['pr_Reset_Stock'];
							$currentStock = $product['pr_Stock'];
							$isOutOfStock = ($resetStock == $currentStock) || ($resetStock > $currentStock);
							?>

							<?php if (!$isOutOfStock && $currentStock > 0): ?>
                            <div class="col-md-12 stock-block">
                                <select name="qty" id="qty">
                                    <option value="">Quantity</option>
                                    <?php
										$maxQty = ($currentStock > 5) ? 5 : $currentStock;
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
								<button class="btn btn-secondary" disabled>Out of Stock</button>
								<div class="text-danger mt-2">This product is currently out of stock.</div>
							</div>
						<?php endif; ?>


                      <?php if (!$isOutOfStock): ?>
						<?php if ($currentStock > 1): ?>
							<div class="col-md-12"><span class="badge bg-success">In stock</span></div>
						<?php elseif ($currentStock == 1): ?>
							<div class="col-md-12"><span class="badge bg-warning text-dark" style="padding:10px;">Only 1 left in stock</span></div>
						<?php endif; ?>
					<?php endif; ?>
                    </form>

                    <div class="col-md-12">
                        <div class="clearfix">&nbsp;</div>
                        <div class="col-md-12 imp-text"><i class="bi bi-shield-check"></i> Secure Transaction</div>
                        <div class="col-md-12 imp-text"><i class="bi bi-truck"></i> Free Delivery</div>
                        <div class="col-md-12 imp-text"><i class="bi bi-arrow-return-left"></i> 7 Days Replacement</div>
                    </div>
					

</div>
                </div>
				
				
				
            </div>
        </div>
    </div>
</section>

<section class="hero-banner">
    <div id="reviewsSection" class="mt-5">
        <div class="container-lg">
            <h5>Customer Ratings and Reviews</h5>
            <div class="row order-box">
                <div class="col-md-12">
				<div>&nbsp; </div>
                    <?php if (!empty($reviews)): ?>
                        <?php foreach (array_chunk($reviews, 2) as $reviewPair): ?>
                            <div class="row mb-4">
                                <?php foreach ($reviewPair as $rev): ?>
                                    <div class="col-md-6">
                                     
                                            <h6 class="card-title mb-1"><?= esc($rev['name']) ?></h6>
                                            <div class="mb-2 text-warning" style="font-size: 1.2em;">
                                                <?= str_repeat('★', (int) $rev['rating']) . str_repeat('☆', 5 - (int) $rev['rating']) ?>
												<span style="font-size:12px; color:#000;">Posted on <?= date('d M Y', strtotime($rev['created_at'])) ?></span>

                                            </div>
                                            <p class="card-text"><?= esc($rev['review']) ?></p>
                                       
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-muted">No reviews yet.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<div>&nbsp; </div>



<section class="top-prod">
    <div class="container-lg">
        <div class="col-md-12">
            <div class="row">
                <h3>Similar Products</h3>
            </div>
            <div class="row mb-4">
                <?php if (!empty($similar)): ?>
                    <?php if (count($similar) > 4): ?>
                        <!-- Use carousel only if more than 4 products -->
                        <div class="owl-carousel" id="top-prod-owl-one">
                            <?php foreach ($similar as $item):
                                $firstImage = base_url('uploads/productmedia/default.jpg');
                                if (!empty($item['product_images'])) {
                                    $decoded = json_decode($item['product_images'], true);
                                    if (is_array($decoded) && isset($decoded[0]['name'][0])) {
                                        $firstImage = base_url('uploads/productmedia/' . $decoded[0]['name'][0]);
                                    }
                                }
                            ?>
                                <div class="item d-flex flex-column align-center h-100">
                                    <div class="col-md-12 m-auto">
                                        <a href="<?= base_url('product/product_details/' . $item['pr_Id']); ?>">
                                            <img src="<?= $firstImage ?>" alt="<?= esc($item['pr_Name']); ?>" />
                                        </a>
                                    </div>
                                    <div class="star-rate p-1">
                                        <?php
                                        $avg = intval($item['avg_rating'] ?? 0);
                                        for ($i = 1; $i <= 5; $i++):
                                            echo '<i class="' . ($i <= $avg ? 'bi bi-star-fill gold' : 'bi bi-star') . '"></i>';
                                        endfor;
                                        ?>
                                    </div>
                                    <div class="item-name p-1"><?= esc($item['pr_Name']); ?></div>
                                    <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;<?= esc($item['pr_Selling_Price']); ?></div>
                                    <div class="col-md-12 text-center">
                                        <button class="order-btn" onclick="window.location.href='<?= base_url('product/product_details/' . $item['pr_Id']); ?>'"></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <!-- Just show items in grid if 4 or fewer -->
                        <div class="row">
                            <?php foreach ($similar as $item):
                                $firstImage = base_url('uploads/productmedia/default.jpg');
                                if (!empty($item['product_images'])) {
                                    $decoded = json_decode($item['product_images'], true);
                                    if (is_array($decoded) && isset($decoded[0]['name'][0])) {
                                        $firstImage = base_url('uploads/productmedia/' . $decoded[0]['name'][0]);
                                    }
                                }
                            ?>
                                <div class="col-md-3 mb-3">
                                    <div class="item d-flex flex-column align-center h-100">
                                        <a class="m-auto" href="<?= base_url('product/product_details/' . $item['pr_Id']); ?>">
                                            <img src="<?= $firstImage ?>" alt="<?= esc($item['pr_Name']); ?>" class="img-fluid" />
                                        </a>
                                        <div class="star-rate p-1">
                                            <?php
                                            $avg = intval($item['avg_rating'] ?? 0);
                                            for ($i = 1; $i <= 5; $i++):
                                                echo '<i class="' . ($i <= $avg ? 'bi bi-star-fill gold' : 'bi bi-star') . '"></i>';
                                            endfor;
                                            ?>
                                        </div>
                                        <div class="item-name p-1"><?= esc($item['pr_Name']); ?></div>
                                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;<?= esc($item['pr_Selling_Price']); ?></div>
                                        <button class="order-btn mx-auto" onclick="window.location.href='<?= base_url('product/product_details/' . $item['pr_Id']); ?>'"></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
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
        document.querySelectorAll('.cpicker').forEach(el => el.style.border = 'none');
        element.style.border = '3px solid #000';
    }
</script>
