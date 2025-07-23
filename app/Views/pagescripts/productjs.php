<script>
    $(document).ready(function () {
        $("#top-prod-owl-one").owlCarousel({
            items: 4,
            margin: 10,
            nav: true,       // Show next/prev buttons
            dots: false,     // Hide dots
            loop: true,      // Loop the items
            autoplay: false, // Disable automatic slide
            responsive: {
                0: { items: 1 },
                600: { items: 2 },
                1000: { items: 4 }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const stock = <?= isset($product['pr_Stock']) ? (int) $product['pr_Stock'] : 0 ?>;
        const orderBtn = document.getElementById('orderNowBtn');

        if (stock < 1 && orderBtn) {
            orderBtn.disabled = true;
            orderBtn.classList.add('btn-secondary');
            orderBtn.classList.remove('btn-dark');
            orderBtn.innerText = 'Out of Stock';
        }
    });


    //   function searchProduct() {
    //     const keyword = document.getElementById('search').value.trim();
    //     if (keyword !== '') {
    //       window.location.href = "<?= base_url('product/search') ?>?keyword=" + encodeURIComponent(keyword);
    //     }
    //   }



    $(document).ready(function () {
        $('.thumbs .preview a').on('click', function (e) {
            e.preventDefault();
            let newSrc = $(this).data('full');
            let newTitle = $(this).data('title');
            $('#main-image').attr('src', newSrc);
            $('#main-image-link').attr('href', newSrc).attr('title', newTitle);

            // Optionally, set active class for selected thumbnail
            $('.thumbs .preview a').removeClass('selected');
            $(this).addClass('selected');
        });
    });

    document.querySelectorAll('.thumbs a').forEach(thumb => {
        thumb.addEventListener('click', function (e) {
            e.preventDefault();
            const fullImageUrl = this.getAttribute('data-full');
            const mainImage = document.getElementById('main-image');
            const mainImageLink = document.getElementById('main-image-link');

            mainImage.src = fullImageUrl;
            mainImageLink.href = fullImageUrl;

            document.querySelectorAll('.thumbs a').forEach(a => a.classList.remove('selected'));
            this.classList.add('selected');
        });
    });


    /*********************************************/

    var baseUrl = "<?= base_url() ?>";


    $('#orderNowBtn').click(function (e) {
        e.preventDefault();
        $('#orderNowBtn').prop('disabled', true);

        const zd_uid = "<?= session()->get('zd_uid'); ?>";

        let size = $('#size').val();
        let color = $('#selected_color').val();
        let qty = $('#qty').val();

        if (!zd_uid) {

            sessionStorage.setItem('tempOrder', JSON.stringify({
                size: size,
                color: color,
                qty: qty
            }));

            // $('#modalBody').load("<?= base_url('weblogin'); ?>", function () {
            //     $('#mainModal').modal('show');
            // });
            $('#exampleModal').modal('show');
            $('#orderNowBtn').prop('disabled', false);
            return;
        }

        if (!size || !color || !qty) {
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert alert-danger')
                .text('Please select Size, Color and Quantity.')
                .fadeIn();

            $('html, body').animate({ scrollTop: 0 }, 'fast');
            $('#orderNowBtn').prop('disabled', false);

            setTimeout(() => {
                $('#messageBox').fadeOut();
            }, 3000);
            return;
        }

        var url = baseUrl + "product/submit";

        $.post(url, $('#orderNowForm').serialize(), function (response) {
            $('#messageBox').removeClass('alert-danger alert-success').hide();

            if (response.status == 1) {
                $('html, body').animate({ scrollTop: 0 }, 'fast', function () {
                    let redirectUrl = response.redirect;
                    if (redirectUrl) {
                        window.location.href = redirectUrl;
                    } else {
                        $('#orderNowBtn').prop('disabled', false);
                    }
                });
            } else {
                $('html, body').animate({ scrollTop: 0 }, 'fast');

                $('#messageBox')
                    .addClass('alert alert-danger')
                    .text(response.msg || 'Please select Size, Color and Quantity.')
                    .fadeIn();

                $('#orderNowBtn').prop('disabled', false);

                setTimeout(function () {
                    $('#messageBox').fadeOut();
                }, 5000);
            }
        }, 'json').fail(function (jqXHR, textStatus, errorThrown) {
            $('html, body').animate({ scrollTop: 0 }, 'fast');
            $('#orderNowBtn').prop('disabled', false);
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert alert-danger')
                .text('A server error occurred: ' + errorThrown)
                .fadeIn();
        });
    });

    /**********************************************************************/


    document.addEventListener('DOMContentLoaded', function () {
        const preview = document.getElementById('main-preview');

        document.querySelectorAll('.thumb-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const type = this.dataset.type;
                const src = this.dataset.src;
                if (type === 'image') {
                    preview.innerHTML = `<img src="${src}" />`;
                } else if (type === 'video') {
                    preview.innerHTML = `<video src="${src}" controls autoplay></video>`;
                }
            });
        });
    });

    function searchProduct() {
        const keyword = document.getElementById('search').value.trim();
        if (keyword !== '') {
            window.location.href = "<?= base_url('product/search') ?>?keyword=" + encodeURIComponent(keyword);
        }
    }



    let loading = false;
    let page = 2;
    let keyword = "<?= esc($keyword ?? '') ?>";
    let lastScrollTop = 0;

    $(document).ready(function () {
        const $loadMore = $('#load-more');
        const $noMoreMsg = $('#no-more-products');
        const $productList = $('#product-list');

        // Scroll Event
        $(window).on('scroll', function () {
            const scrollTop = $(this).scrollTop();
            const windowHeight = $(this).height();
            const documentHeight = $(document).height();

            // Load next batch if near bottom
            if (!loading && scrollTop + windowHeight >= documentHeight - 200) {
                loadNextBatch();
            }

            // Scroll up — remove previous batch to save memory
            if (scrollTop < lastScrollTop && page > 2) {
                const prevBatch = page - 1;
                const $lastBatch = $(`.product-batch[data-batch="${prevBatch}"]`);
                if ($lastBatch.length && scrollTop < $lastBatch.offset().top) {
                    $lastBatch.remove();
                    page--;
                    $loadMore.fadeIn().html('<i class="bi bi-arrow-down-circle" style="font-size: 1.4rem;"></i>');
                    $noMoreMsg.addClass('d-none');
                }
            }

            lastScrollTop = scrollTop;
        });

        function loadNextBatch() {
            loading = true;
            $loadMore.html('<span class="spinner-border spinner-border-sm"></span>');

            const ajaxURL = keyword !== ''
                ? "<?= base_url('product/loadMoreSearch') ?>"
                : "<?= base_url('product/loadMoreByDate') ?>";

            const requestData = keyword !== ''
                ? { keyword: keyword, page: page }
                : { page: page };

            $.ajax({
                url: ajaxURL,
                type: "GET",
                data: requestData,
                success: function (html) {
                    if ($.trim(html) === '') {
                        $loadMore.hide();
                        $noMoreMsg.removeClass('d-none').text('No more products to show.');
                    } else {
                        $productList.append(`<div class="product-batch" data-batch="${page}">${html}</div>`);
                        $loadMore.html('<i class="bi bi-arrow-down-circle" style="font-size: 1.4rem;"></i>').fadeIn();
                        page++;
                    }
                    loading = false;
                },
                error: function () {
                    alert("Failed to load more products.");
                    $loadMore.html('<i class="bi bi-arrow-down-circle" style="font-size: 1.4rem;"></i>').fadeIn();
                    loading = false;
                }
            });
        }
    });


    function selectColor(color, element) {
        document.getElementById('selected_color').value = color;
        document.querySelectorAll('.cpicker').forEach(el => el.style.border = 'none');
        element.style.border = '3px solid #000';
    }

    $(document).ready(function () {
        let tempOrder = sessionStorage.getItem('tempOrder');
        if (tempOrder) {
            tempOrder = JSON.parse(tempOrder);

            if (tempOrder.size) {
                $('#size').val(tempOrder.size);
            }

            if (tempOrder.color) {
                $('#selected_color').val(tempOrder.color);

                $('.cpicker').removeClass('selected');
                $('.cpicker').each(function () {
                    if ($(this).css('background-color') === tempOrder.color ||
                        rgb2hex($(this).css('background-color')) === tempOrder.color.toLowerCase()) {
                        $(this).addClass('selected');
                    }
                });
            }

            if (tempOrder.qty) {
                $('#qty').val(tempOrder.qty);
            }

            sessionStorage.removeItem('tempOrder');
        }
    });

    // Helper function to convert rgb() to hex
    function rgb2hex(rgb) {
        if (!rgb.startsWith("rgb")) return rgb;
        rgb = rgb.match(/\d+/g);
        return "#" + rgb.map(x => ('0' + parseInt(x).toString(16)).slice(-2)).join('');
    }
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 1, // On mobile
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            992: {
                slidesPerView: 4,
                spaceBetween: 20,
            }
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });

    document.addEventListener('DOMContentLoaded', function () {
        const toggleIcon = document.getElementById('toggleReviewIcon');
        const reviewContainer = document.getElementById('review-container');

        let extraReviewWrapper = null; // to hold dynamically loaded reviews

        toggleIcon.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');
            const offset = parseInt(this.getAttribute('data-offset'), 10);
            const isExpanded = this.getAttribute('data-expanded') === 'true';

            if (!isExpanded) {
                // Load more reviews
                fetch(`<?= base_url('product/load-more-reviews') ?>/${productId}?offset=${offset}`)

                    .then(response => response.text())
                    .then(data => {
                        if (data.trim() !== '') {
                            // Create a container for extra reviews if not present
                            extraReviewWrapper = document.createElement('div');
                            extraReviewWrapper.id = 'extra-review-wrapper';
                            extraReviewWrapper.innerHTML = data;
                            reviewContainer.appendChild(extraReviewWrapper);

                            // Scroll to newly loaded reviews
                            extraReviewWrapper.scrollIntoView({ behavior: 'smooth' });

                            // Change icon and state
                            toggleIcon.classList.remove('bi-chevron-double-down');
                            toggleIcon.classList.add('bi-chevron-double-up');
                            toggleIcon.setAttribute('data-expanded', 'true');
                        }
                    });
            } else {
                // Collapse: Remove extra reviews
                if (extraReviewWrapper) {
                    extraReviewWrapper.remove();
                    extraReviewWrapper = null;

                    // Scroll back to top of reviews
                    reviewContainer.scrollIntoView({ behavior: 'smooth' });

                    // Change icon and state
                    toggleIcon.classList.remove('bi-chevron-double-up');
                    toggleIcon.classList.add('bi-chevron-double-down');
                    toggleIcon.setAttribute('data-expanded', 'false');
                }
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-review').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const parent = this.closest('.card-text');
                const shortText = parent.querySelector('.short-text');
                const fullText = parent.querySelector('.full-text');

                const isHidden = fullText.classList.contains('d-none');

                if (isHidden) {
                    shortText.classList.add('d-none');
                    fullText.classList.remove('d-none');
                    this.textContent = 'Read less';
                } else {
                    shortText.classList.remove('d-none');
                    fullText.classList.add('d-none');
                    this.textContent = 'Read more';
                }
            });
        });
    });

</script>