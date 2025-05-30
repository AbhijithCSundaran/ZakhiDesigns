<script>
var baseUrl = "<?= base_url() ?>";
$(document).ready(function() {
    $('#orderNowForm').on('submit', function(e) {
        e.preventDefault(); // stop normal form submission
        
        var url = "<?= base_url('ordernow/submit') ?>"; // your submit URL
        
        $('#orderNowBtn').prop('disabled', true);
        
        $.post(url, $(this).serialize(), function(response) {
            $('html, body').animate({ scrollTop: 0 }, 'fast');
            
            if (response.status == 1) {
                $('#messageBox')
                    .removeClass('alert-danger')
                    .addClass('alert-success')
                    .text(response.msg)
                    .show();
                
                setTimeout(function() {
                    $('#messageBox').fadeOut();
                    $('#orderNowBtn').prop('disabled', false);
                    
                    // ✅ Remove redirect to stay on the same page
                    // if(response.od_Id) {
                    //     window.location.href = "<?= base_url('ordernow/product/') ?>" + response.od_Id;
                    // }
                }, 3000);
            } else {
                $('#messageBox')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .text(response.msg || 'Something went wrong.')
                    .show();
                
                $('#orderNowBtn').prop('disabled', false);
                
                setTimeout(function() {
                    $('#messageBox').fadeOut();
                }, 3000);
            }
        }, 'json');
    });
});
</script>
