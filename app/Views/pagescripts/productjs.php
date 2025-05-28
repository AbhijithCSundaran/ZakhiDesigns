

<script>
  function searchProduct() {
    const keyword = document.getElementById('search').value.trim();
    if (keyword !== '') {
      window.location.href = "<?= base_url('product/products_lists') ?>?keyword=" + encodeURIComponent(keyword);
    }
  }
</script>
<script>
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
</script>
<script>
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
</script>

