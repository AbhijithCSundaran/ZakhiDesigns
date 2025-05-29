<!-- <section class="category-promo">
    <div class="container-lg">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/c1.jpg" />
                    <div class="col-md-12 cat-title">New Women Style</div>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/c2.jpg" />
                    <div class="col-md-12 cat-title">Best Women Shopping</div>
                </div>
                <div class="col-md-4">
                    <img src="<?php echo base_url().ASSET_PATH; ?>assets/images/c3.jpg" />
                    <div class="col-md-12 cat-title">Top Women Collection</div>
                </div>
            </div>
        </div>
    </div>
</section> -->

<section class="category-promo">
    <div class="container-lg">
        <div class="col-md-12">
            <div class="row">
                <?php
                if (!empty($themes['theme_Section2'])) {
                    $section2 = json_decode($themes['theme_Section2'], true);
                    // Display up to 3 images from section2
                    for ($i = 0; $i < 3; $i++) {
                        if (!empty($section2[$i]['image'])) {
                            $imagePath = base_url('public/uploads/themes/' . $section2[$i]['image']);
                            $title = !empty($section2[$i]['name']) ? $section2[$i]['name'] : 'Category';
                            $link = !empty($section2[$i]['link']) ? $section2[$i]['link'] : '#';
                            echo '<div class="col-md-4">';
                            echo '<a href="' . esc($link) . '">';
                            echo '<img src="' . $imagePath . '" class="img-fluid"/>';
                            echo '<div class="col-md-12 cat-title">' . esc($title) . '</div>';
                            echo '</a>';
                            echo '</div>';
                        } else {
                            // Fallback for missing images
                            $fallbackImage = base_url(ASSET_PATH . 'assets/images/c' . ($i + 1) . '.jpg');
                            $fallbackTitle = ['New Women Style', 'Best Women Shopping', 'Top Women Collection'][$i];
                            echo '<div class="col-md-4">';
                            echo '<img src="' . $fallbackImage . '" class="img-fluid"/>';
                            echo '<div class="col-md-12 cat-title">' . $fallbackTitle . '</div>';
                            echo '</div>';
                        }
                    }
                } else {
                    // Full fallback to static if theme_Section2 is empty
                    $fallbackTitles = ['New Women Style', 'Best Women Shopping', 'Top Women Collection'];
                    for ($i = 0; $i < 3; $i++) {
                        echo '<div class="col-md-4">';
                        echo '<img src="' . base_url(ASSET_PATH . 'assets/images/c' . ($i + 1) . '.jpg') . '" class="img-fluid"/>';
                        echo '<div class="col-md-12 cat-title">' . $fallbackTitles[$i] . '</div>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>
