<section class="top-prod">
    <!-- <div class="d-flex justify-content-between">
    </div> -->
    <div class="container-lg">
        <div class="col-md-12">
            <div class="row">
                <h3>Top Products</h3>
            </div>
            <!-- <pre>
				<?php print_r($product); ?>
					</pre> -->
            <div class="row">
                <div class="owl-carousel" id="top-prod-owl">
                    <?php foreach ($product as $item): ?>
                    <?php
                // Decode the JSON string
                $images = json_decode($item->product_images, true);
				 $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.png'; // fallback image
			?>

                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url('uploads/productmedia/') . $firstImage; ?>"
                                alt="<?php echo $item->pr_Name; ?>" />
                            <!-- <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s1.png" /> -->
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name"><?php echo $item->pr_Description; ?></div>
                        <div class="item-price"><i
                                class="bi bi-currency-rupee"></i>&nbsp;<?php echo $item->pr_Selling_Price; ?></div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <?php endforeach; ?>

                </div>

                <div class="owl-carousel" id="top-prod-owl-two">
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s1.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s2.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s3.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s4.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s1.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s2.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s3.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s4.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s1.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s2.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                    <div class="item">
                        <div class="col-md-12">
                            <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/slides/s3.png" />
                        </div>
                        <div class="star-rate">
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill gold"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="item-name">Lorem Ipsum</div>
                        <div class="item-price"><i class="bi bi-currency-rupee"></i>&nbsp;1000</div>
                        <div class="col-md-12 text-center"><button class="order-btn"></button></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>