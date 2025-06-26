<section class="top-prod">
    <div class="container-lg">
        <div class="row">
            <div class="col-12">
                <h3>CATEGORIES</h3>
            </div>
        </div>

        <?php if (empty($category)): ?>
            <div class="alert alert-warning text-center">No Category found.</div>
        <?php else: ?>
            <div class="row">
                <?php
                    $uniqueIds = [];

                    foreach ($category as $item):
                        if (in_array($item['cat_Id'], $uniqueIds)) {
                            continue;
                        }
                        $uniqueIds[] = $item['cat_Id']; 
                        $images = json_decode($item['product_images'], true);
                        $firstImage = isset($images[0]['name'][0]) ? $images[0]['name'][0] : 'default.jpg';
                ?>
                    <div class="col-md-3 mb-3">
                        <div    class="card h-100 text-center">
                            <div class="card-body">
                                <a href="<?= base_url('category/catProducts/' . $item['cat_Id']); ?>">
                                    <img class="product-img img-fluid mb-2"
                                        src="<?= base_url('uploads/productmedia/') . $firstImage; ?>"
                                        alt="<?= esc($item['cat_Name']); ?>" />
                                </a>    
                                <h5><?= esc($item['cat_Name']) ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
