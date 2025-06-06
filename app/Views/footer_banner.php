		<!-- <section class="footerbanner" style="background-image:url('<?php echo base_url().ASSET_PATH; ?>assets/images/footerbanner.png')">
			<div class="container-lg">
				<div class="row">
					<div class="col-md-6 leftbox">
						New<br/>Style
					</div>
					<div class="col-md-6 rightbox">
						<div class="yearblock">2025</div>
						<button class="btn btn-black">View Collection</button>
					</div>
				</div>
			</div>
		</section> -->

		<?php
$footerImage = base_url(ASSET_PATH . 'assets/images/footerbanner.png');
$footerTitle = 'New<br/>Style';
$footerLink = '#';
$showFooter = false;

if (!empty($themes['theme_Section3'])) {
    $section3 = json_decode($themes['theme_Section3'], true);

    // Filter only entries that have at least one value
    $validSections = array_filter($section3, function ($item) {
        return !empty($item['image']) || !empty($item['name']) || !empty($item['link']);
    });

    if (!empty($validSections)) {
        $validSections = array_values($validSections); // reindex

        // Rotate every 10 minutes based on current time
        $index = floor(time() / 600) % count($validSections);
        $current = $validSections[$index];

        $showFooter = true;

        if (!empty($current['image'])) {
            $footerImage = base_url('public/uploads/themes/' . $current['image']);
        }
        if (!empty($current['name'])) {
            $footerTitle = nl2br(esc($current['name']));
        }
        if (!empty($current['link'])) {
            $footerLink = esc($current['link']);
        }
    }
}
?>

<?php if ($showFooter): ?>
<section class="footerbanner" style="background-image:url('<?= $footerImage; ?>')">
    <div class="container-lg">
        <div class="row">
            <div class="col-md-6 leftbox">
                <?= $footerTitle ?>
            </div>
            <div class="col-md-6 rightbox">
                <div class="yearblock"><?= date('Y') ?></div>
				<a href="<?= base_url('product/viewcollection') ?>" class="btn btn-black">View Collection</a>
            </div>
        </div>
    </div>
</section>
<script>
// Refresh every 10 minutes
setTimeout(function () {
    location.reload();
}, 600000);
</script>
<?php endif; ?>

