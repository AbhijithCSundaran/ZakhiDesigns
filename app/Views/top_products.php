<?php
$latestProducts = $product ?? [];
$first20 = array_slice($latestProducts, 0, 20);
$next20 = array_slice($latestProducts, 20, 20);
?>

<section class="top-prod">
    <div class="container-lg">
        <div class="col-md-12">
            <div class="row">
                <h3>Top Products</h3>
            </div>

            <!-- First 20 products -->
            <div class="row mb-4">
                <div class="owl-carousel" id="top-prod-owl">
                    <?php foreach ($first20 as $item): ?>
                        <?php
                        $images = json_decode($item['product_images'], true);
                        $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.png';
                        ?>
                        <div class="item">
                            <div class="col-md-12">
                                <a href="<?= base_url('product/product_details/' . $item['pr_Id']); ?>">
                                    <img class="product-img" src="<?= base_url('uploads/productmedia/' . $firstImage); ?>" alt="<?= esc($item['pr_Name']); ?>" />
                                </a>
                            </div>
                            <div class="star-rate p-1">
                                <i class="bi bi-star-fill gold"></i>
                                <i class="bi bi-star-fill gold"></i>
                                <i class="bi bi-star-fill gold"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="item-name p-1"><?= esc($item['pr_Name']); ?></div>
                            <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;<?= esc($item['pr_Selling_Price']); ?></div>
                            <div class="col-md-12 text-center">
                                <button class="order-btn" onclick="window.location.href='<?= base_url('ordernow?pr_Id=' . $item['pr_Id']); ?>'"></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Next 20 products -->
            <div class="row">
                <div class="owl-carousel" id="top-prod-owl-two">
                    <?php foreach ($next20 as $item): ?>
                        <?php
                        $images = json_decode($item['product_images'], true);
                        $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.png';
                        ?>
                        <div class="item">
                            <div class="col-md-12">
                                <a href="<?= base_url('product/product_details/' . $item['pr_Id']); ?>">
                                    <img class="product-img" src="<?= base_url('uploads/productmedia/' . $firstImage); ?>" alt="<?= esc($item['pr_Name']); ?>" />
                                </a>
                            </div>
                            <div class="star-rate p-1">
                                <i class="bi bi-star-fill gold"></i>
                                <i class="bi bi-star-fill gold"></i>
                                <i class="bi bi-star-fill gold"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="item-name p-1"><?= esc($item['pr_Name']); ?></div>
                            <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;<?= esc($item['pr_Selling_Price']); ?></div>
                            <div class="col-md-12 text-center">
                                <button class="order-btn" onclick="window.location.href='<?= base_url('ordernow?pr_Id=' . $item['pr_Id']); ?>'"></button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
$(document).ready(function(){
    $('#top-prod-owl, #top-prod-owl-two').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        responsive: {
            0: { items: 1 },
            576: { items: 2 },
            768: { items: 3 },
            992: { items: 4 },
            1200: { items: 5 }
        }
    });
});
</script>
