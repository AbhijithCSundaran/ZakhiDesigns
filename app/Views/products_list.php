<section class="top-prod">
    <div class="container-lg">
        <div class="col-md-12">
            <div class="row">
                <h3>Products</h3>
            </div>

            <?php if (empty($product)): ?>
                <div class="alert alert-warning text-center">No products found.</div>
            <?php endif; ?>
            <?php if (count($product)>4): ?>
                <div class="row">
                <div class="product-carousel owl-carousel" id="top-prod-owl">
                        <?php
                            $uniqueIds = []; // To store already displayed product IDs
                        ?>
                        <?php foreach ($product as $item): ?>
                            <?php
                                if (in_array($item['pr_Id'], $uniqueIds)) {
                                    continue; // Skip duplicates
                                }
                                $uniqueIds[] = $item['pr_Id'];

                                $images = json_decode($item['product_images'], true);
                                $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.png';
                            ?>
                            <div class="product-item">
                                <div class="col-md-12">
                                    <a href="<?= base_url('product/product_details/'.$item['pr_Id']); ?>">
                                        <img class="product-img"
                                            src="<?= base_url('uploads/productmedia/') . $firstImage; ?>"
                                            alt="<?= esc($item['pr_Name']); ?>" />
                                    </a>
                                </div>
                                <div class="star-rate p-1">
                                    <i class="bi bi-star-fill gold"></i>
                                    <i class="bi bi-star-fill gold"></i>
                                    <i class="bi bi-star-fill gold"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="item-name">
                                    <a href="<?= base_url('product/product_details/'. $item['pr_Id']); ?>"><?= esc($item['pr_Name']); ?></a>
                                </div>
                                <div class="item-price">
                                    <i class="bi bi-currency-rupee"></i>&nbsp;<?= esc($item['pr_Selling_Price']); ?>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="order-btn" onclick="window.location.href='<?= base_url('ordernow?pr_Id=' . $item['pr_Id']); ?>'"></button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (count($product)<=4): ?>
                <div class="row">
                <div class="product-carousel d-flex gap-2">
                        <?php
                            $uniqueIds = []; // To store already displayed product IDs
                        ?>
                        <?php foreach ($product as $item): ?>
                            <?php
                                if (in_array($item['pr_Id'], $uniqueIds)) {
                                    continue; // Skip duplicates
                                }
                                $uniqueIds[] = $item['pr_Id'];

                                $images = json_decode($item['product_images'], true);
                                $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.png';
                            ?>
                            <div class="owl-item product-item">
                                <div class="col-md-12">
                                    <a href="<?= base_url('product/product_details/'.$item['pr_Id']); ?>">
                                        <img class="product-img"
                                            src="<?= base_url('uploads/productmedia/') . $firstImage; ?>"
                                            alt="<?= esc($item['pr_Name']); ?>" />
                                    </a>
                                </div>
                                <div class="star-rate p-1">
                                    <i class="bi bi-star-fill gold"></i>
                                    <i class="bi bi-star-fill gold"></i>
                                    <i class="bi bi-star-fill gold"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="item-name">
                                    <a href="<?= base_url('product/product_details/'. $item['pr_Id']); ?>"><?= esc($item['pr_Name']); ?></a>
                                </div>
                                <div class="item-price">
                                    <i class="bi bi-currency-rupee"></i>&nbsp;<?= esc($item['pr_Selling_Price']); ?>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button class="order-btn" onclick="window.location.href='<?= base_url('ordernow?pr_Id=' . $item['pr_Id']); ?>'"></button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
