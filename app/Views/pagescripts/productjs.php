<script>
$(document).ready(function(){
    $("#top-prod-owl-one").owlCarousel({
        items: 4,
        margin: 10,
        nav: true,       // Show next/prev buttons
        dots: false,     // Hide dots
        loop: true,      // Loop the items
        autoplay: false, // Disable automatic slide
        responsive:{
            0:{ items:1 },
            600:{ items:2 },
            1000:{ items:4 }
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


  function searchProduct() {
    const keyword = document.getElementById('search').value.trim();
    if (keyword !== '') {
      window.location.href = "<?= base_url('product/search') ?>?keyword=" + encodeURIComponent(keyword);
    }
  }



    $(document).ready(function() {
        $('.thumbs .preview a').on('click', function(e) {
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

//for saving pick details

/* document.getElementById('orderNowBtn').addEventListener('click', function () {
    const formData = {
        size: document.getElementById('size').value,
        selected_color: document.getElementById('selected_color').value,
        quantity: document.getElementById('quantity').value,
        pr_Id: document.getElementById('pr_Id').value
    };

    fetch("<?= base_url('ordernow/submit') ?>", {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest' // Important for CodeIgniter request->isAJAX()
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            window.location.href = "<?= base_url('order_now') ?>"; // Redirect on success
        } else {
            alert('Order submission failed. Please try again.');
        }
    })
    .catch(err => {
        console.error('AJAX error:', err);
    });
}); */


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

        $('#modalBody').load("<?= base_url('weblogin'); ?>", function () {
            $('#mainModal').modal('show');
        });
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
</script>