		<section class="footerbanner" style="background-image:url('<?php echo base_url().ASSET_PATH; ?>assets/images/footerbanner.png')">
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
        
        <footer>
		    <div class="container-lg">
		        <div class="row">
		            <div class="col-md-3">
		                <h4>Your Account<h4>
		                        <ul>
		                            <li><i class="bi bi-arrow-right"></i>My Profile</li>
		                            <li><i class="bi bi-arrow-right"></i>My Orders</li>
		                            <li><i class="bi bi-arrow-right"></i>Address</li>
		                            <li><i class="bi bi-arrow-right"></i>Track Orders</li>
		                        </ul>
		            </div>
		            <div class="col-md-3">
		                <h4>Products<h4>
		                        <ul>
		                            <li><i class="bi bi-arrow-right"></i>Price Drop</li>
		                            <li><i class="bi bi-arrow-right"></i>Products</li>
		                            <li><i class="bi bi-arrow-right"></i>Best Sellers</li>
		                            <li><i class="bi bi-arrow-right"></i>Sitemap</li>
		                        </ul>
		            </div>
		            <div class="col-md-3">
		                <h4>Our Company<h4>
		                        <ul>
		                            <li><i class="bi bi-arrow-right"></i>Delivery</li>
		                            <li><i class="bi bi-arrow-right"></i>Privacy Policy</li>
		                            <li><i class="bi bi-arrow-right"></i>Terms & Conditions</li>
		                            <li><i class="bi bi-arrow-right"></i>Return Policy</li>
		                        </ul>
		            </div>
		            <div class="col-md-3">
		                <h4>Store Information<h4>
		                        <ul>
		                            <li><i class="bi bi-geo-alt-fill"></i>Zakhi Designs Store<br />16/541P Muppathadam, Near
		                                Govt: GHS School Aluva, Ernakulam</li>
		                            <li><i class="bi bi-telephone-fill"></i>+91 70348 53219</li>
		                            <li><i class="bi bi-envelope-fill"></i>zakhidesigns@gmail.com</li>
		                        </ul>
		            </div>
		        </div>
		        <div class="row">
		            <div class="col-md-12 text-center social-ico">
		                <i class="bi bi-facebook"></i>
		                <i class="bi bi-twitter"></i>
		                <i class="bi bi-instagram"></i>
		                <i class="bi bi-youtube"></i>
		            </div>
		        </div>
		    </div>
		</footer>
		</body>
		<script src="<?php echo base_url().ASSET_PATH; ?>assets/js/jquery-3.7.1.min.js"></script>
		<script src="<?php echo base_url().ASSET_PATH; ?>assets/js/bootstrap.min.js"></script>

		<script src="<?php echo base_url().ASSET_PATH; ?>assets/vendors/owlcarousel/owl.carousel.js"></script>
		<script>
function openRespMenu() {
    var x = document.getElementById("respTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
$(document).ready(function() {
    $('.bi-search').click(function() {
        $('.searchbox').find('input').toggle({
            right: '250px'
        });
    });
    var topowl = $('#top-prod-owl,#top-prod-owl-two');
    topowl.owlCarousel({
        margin: 10,
        loop: true,
        nav: true, // Enables navigation
        navText: ["<", ">"], // Custom navigation text/icons

        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 4
            }
        }
    });
})
		</script>

		</html>