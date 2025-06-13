<section class="top-prod">
    <div class="container-lg">
        <div class="row">
            <div class="col-12">
                <h3>Products</h3>
            </div>
        </div>

        <?php if (empty($product)): ?>
            <div class="alert alert-warning text-center">No products found.</div>
        <?php else: ?>
            <div class="row">
                <?php
                    $uniqueIds = [];

                    foreach ($product as $item):
                        if (in_array($item['pr_Id'], $uniqueIds)) {
                            continue;
                        }
                        $uniqueIds[] = $item['pr_Id'];

                        $images = json_decode($item['product_images'], true);
                        $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.jpg';
                ?>
                <div class="col-md-3 mb-4">
                    <div class="product-item text-center border p-3 h-100">
                        <a href="<?= base_url('product/product_details/' . $item['pr_Id']); ?>">
                            <img class="product-img img-fluid mb-2"
                                src="<?= base_url('uploads/productmedia/') . $firstImage; ?>"
                                alt="<?= esc($item['pr_Name']); ?>" />
                        </a>
							    <div class="star-rate p-1">
									<?php
										$avg = isset($item['ratings']) ? round($item['ratings']) : 0;
										for ($i = 1; $i <= 5; $i++):
									?>
										<i class="<?= $i <= $avg ? 'bi bi-star-fill gold' : 'bi bi-star' ?>"></i>
									<?php endfor; ?>
									<!-- Show numeric average -->
									
								</div>

                        <div class="item-name p-1"><?= esc($item['pr_Name']); ?></div>
                        <div class="item-price">
    <?php if (!empty($item['pr_Discount_Value']) && $item['pr_Discount_Value'] > 0): ?>
        <!-- MRP with strikethrough -->
        <span style="color: #999;">
            <del>
                <i class="bi bi-currency-rupee"></i><?= esc($item['mrp']); ?>
            </del>
        </span>
        &nbsp;
        <!-- Selling Price -->
        <span>
            <i class="bi bi-currency-rupee"></i><?= esc($item['pr_Selling_Price']); ?>
        </span>
    <?php else: ?>
        <!-- Only Selling Price -->
        <span>
            <i class="bi bi-currency-rupee"></i><?= esc($item['pr_Selling_Price']); ?>
        </span>
    <?php endif; ?>
</div>

                        <div class="text-center mt-2">
                             <div class="col-md-12 text-center">
                                    <button class="order-btn" onclick="window.location.href='<?= base_url('product/product_details/' . $item['pr_Id']); ?>'"></button>
                                </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>























 