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
                        $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.png';
                ?>
                <div class="col-md-3 mb-4">
                    <div class="product-item text-center border p-3 h-100">
                        <a href="<?= base_url('product/product_details/' . $item['pr_Id']); ?>">
                            <img class="product-img img-fluid mb-2"
                                src="<?= base_url('uploads/productmedia/') . $firstImage; ?>"
                                alt="<?= esc($item['pr_Name']); ?>" />
                        </a>
                        <div class="star-rate p-1">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name p-1"><?= esc($item['pr_Name']); ?></div>
                        <div class="item-price">
                            <i class="bi bi-currency-rupee"></i>&nbsp;<?= esc($item['pr_Selling_Price']); ?>
                        </div>
                        <div class="text-center mt-2">
                             <div class="col-md-12 text-center">
                                    <button class="order-btn" onclick="window.location.href='<?= base_url('ordernow?pr_Id=' . $item['pr_Id']); ?>'"></button>
                                </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>























 