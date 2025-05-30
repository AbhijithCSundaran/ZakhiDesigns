
<script>
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

$('#orderNowBtn').click(function(e) {
    e.preventDefault();
    $('#orderNowBtn').prop('disabled', true);

    var url = baseUrl + "product/submit";

    $.post(url, $('#orderNowForm').serialize(), function(response) {
        $('html, body').animate({ scrollTop: 0 }, 'fast');
console.log(response); 
        if (response.status == 1) {
			
            $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Order placed successfully')
                .show();

            // Assuming od_Id is returned from the backend
				let od_Id = response.od_Id;

            setTimeout(function() {
                $('#orderNowBtn').prop('disabled', false);
                if (od_Id) {
                    window.location.href = baseUrl + "ordernow/product/" + od_Id;
                }
            }, 3000);
        } else {
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text(response.msg || 'Please select Options.')
                .show();
            $('#orderNowBtn').prop('disabled', false);
        }

        setTimeout(function() {
			$('#orderNowBtn').prop('disabled', false);
            $('#messageBox').empty().hide();
        }, 3000);
    }, 'json');
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
                    preview.innerHTML = `<img src="${src}" style="width: 100%; max-height: 400px; object-fit: contain;" />`;
                } else if (type === 'video') {
                    preview.innerHTML = `<video src="${src}" controls autoplay style="width: 100%; max-height: 400px; object-fit: contain;"></video>`;
                }
            });
        });
    });
</script>