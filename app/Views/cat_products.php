<?php if (isset($cat_id)): ?>

    <section class="top-prod">
        <div class="container-lg">
            <div class="row">
                <div class="col-12" Style="padding:10px;" >
                    <h3 class="heading-left" style="padding-left:2px;"><?= esc($cat_Name) ?></h3>
                </div>
            </div>
            <?php if (empty($product)): ?>
                <div class="alert alert-warning text-center">No Category found.</div>
            <?php else: ?>
                <!-- show sub categories--->
                <?php if (!empty($subcategory)): ?>
                    <div class="swiper mySwiper" style="padding:0px;">
                        <div class="swiper-button-next" ></div>
                        <div class="swiper-wrapper">
                            <?php
                            $uniqueIds = [];
                            foreach ($subcategory as $item):
                 
                                if (in_array($item['sub_Id'], $uniqueIds)) {
                                    continue;
                                }
                                $uniqueIds[] = $item['sub_Id'];
                                $images = json_decode($item['product_images'], true);
                                $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.jpg';
                            ?>
                            <div class="swiper-slide card-slide" style="width: 120px;">
                                <div class="card text-center" style="height: 210px; max-width: 120px;">
                                    <div class="card-body p-2 position-relative"  style="overflow: hidden; z-index:2px;" >
                                        <a href="<?= base_url('subcategory/subcategoryProducts/' . $item['sub_Id'] . '/' . $cat_id); ?>">
                                            <img class="product-img img-fluid mb-2"
                                                src="<?= base_url('uploads/productmedia/') . $firstImage; ?>"
                                                alt="<?= esc($item['sub_Category_Name']); ?>"
                                                style="height: 150px; object-fit: cover;" />
                                        </a>
                                        <div class="item-name p-1" style="font-size: 11px; word-wrap: break-word; white-space: normal;">
                                            <?= esc($item['sub_Category_Name']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-prev" ></div>

                    </div>


                <?php endif; ?>
                


                 <br/>               
                <div class="row">
                    <?php
                    $uniqueIds = [];

                    foreach ($product as $item):
                        if (in_array($item['pr_Id'], $uniqueIds)) {
                            continue;
                        }
                        $uniqueIds[] = $item['cat_Id'];
                        $images = json_decode($item['product_images'], true);
                        $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.jpg';
                        ?>
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 text-center">
                                <div class="card-body">
                                    <a href="<?= base_url('product/product_details/' . $item['pr_Id']); ?>">
                                        <img class="product-img img-fluid mb-2"
                                            src="<?= base_url('uploads/productmedia/') . $firstImage; ?>"
                                            alt="<?= esc($item['pr_Name']); ?>" />
                                    </a>
                                    <div class="star-rate p-1">
                                        <?php
                                        $avg = round($item['avg_rating'] ?? 0, 1);
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
                                                <i class="bi bi-currency-rupee"></i><?= esc(data: round($item['pr_Selling_Price'])); ?>
                                            </span>
                                        <?php else: ?>
                                            <!-- Only Selling Price -->
                                            <span>
                                                <i class="bi bi-currency-rupee"></i><?= esc(round($item['pr_Selling_Price'])); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="text-center mt-2">
                                        <div class="col-md-12 text-center">
                                            <button class="order-btn"
                                                onclick="window.location.href='<?= base_url('product/product_details/' . $item['pr_Id']); ?>'"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>


        </div>
    </section>
<?php else: ?>
    <div>Category ID not found.</div>
<?php endif; ?>
<script>
 var swiper = new Swiper(".mySwiper", {
  slidesPerView: 'auto', // keep 'auto' so card width determines layout
  spaceBetween: 10.5,
  freeMode: true,
  grabCursor: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
  0: {
    slidesPerView: 3,
    spaceBetween: 6
  },
  768: {
    slidesPerView: '10',
    spaceBetween: 10
  }
}
});


</script>
