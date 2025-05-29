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
$footerImage = base_url(ASSET_PATH . 'assets/images/footerbanner.png'); // default fallback

if (!empty($themes['theme_Section3'])) {
    $section3 = json_decode($themes['theme_Section3'], true);
    if (!empty($section3[0]['image'])) {
        $footerImage = base_url('public/uploads/themes/' . $section3[0]['image']);
    }
}
?>

<section class="footerbanner" style="background-image:url('<?php echo $footerImage; ?>')">
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
</section>
