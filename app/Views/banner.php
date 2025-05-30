<section class="hero-banner">
    <div class="container-lg">
        <div class="row">
            <!-- <div class="col-md-12 banner">
                <img src="<?php echo base_url().ASSET_PATH;?>assets/images/banner.jpg" />
            </div> -->

            <div class="col-md-12 banner">
                <?php
    if (!empty($themes['theme_Section1'])) {
        $section1 = json_decode($themes['theme_Section1'], true);
        if (!empty($section1[0]['image'])) {
            $imagePath = base_url('public/uploads/themes/' . $section1[0]['image']);
            echo '<a href="' . esc($section1[0]['link']) . '">';
            echo '<img src="' . $imagePath . '" alt="Theme Banner" class="img-fluid">';
            echo '</a>';
        } else {
            // Fallback to static image if 'image' is empty
            echo '<img src="' . base_url(ASSET_PATH . 'assets/images/banner.jpg') . '" alt="Default Banner" class="img-fluid">';
        }
    } else {
        // Fallback to static image if theme_Section1 is empty
        echo '<img src="' . base_url(ASSET_PATH . 'assets/images/banner.jpg') . '" alt="Default Banner" class="img-fluid">';
    }
    ?>
            </div>


        </div>



        <div class="row">
            <div class="col-md-12 highlightrow">
                <div class="row">
                    <div class="col-md-4 text-center highlights"><i class="bi bi-person-circle"></i>24x7 Free Support
                    </div>
                    <div class="col-md-4 text-center highlights"><i class="bi bi-wallet"></i>Money Back Gurantee</div>
                    <div class="col-md-4 text-center highlights"><i class="bi bi-truck"></i>Free Worldwide Shipping
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>