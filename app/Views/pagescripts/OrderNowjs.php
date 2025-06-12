<!-- pagescripts/OrderNowjs.php -->
<script>
$(function() {
    $('#newAddressForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('OrderNow/saveNewAddress') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(res) {
                if (res.success) {
                    $('input[name="address_id"]').prop('checked', false);
                    $('<input>').attr({
                        type: 'radio',
                        name: 'address_id',
                        value: res.insertId,
                        checked: true
                    }).appendTo('body').hide();

                    // ✅ Show success message
                    $('#messageBox').html('<div class="alert alert-success">' + res.message + '</div>').fadeIn().delay(5000).fadeOut();

                } else {
                    // ❌ Show error message
                    $('#messageBox').html('<div class="alert alert-danger">' + res.message + '</div>').fadeIn().delay(5000).fadeOut();
                }

                // ⬆️ Scroll to messageBox
                $('html, body').animate({
                    scrollTop: $('#messageBox').offset().top - 100
                }, 'slow');
            },
            error: function() {
                $('#messageBox').html('<div class="alert alert-danger">Failed to save address.</div>').fadeIn().delay(5000).fadeOut();

                // ⬆️ Scroll to messageBox on error
                $('html, body').animate({
                    scrollTop: $('#messageBox').offset().top - 100
                }, 'slow');
            }
        });
    });
});


    // Final Order Submit
    $('#confirmOrderBtn').on('click', function() {
        const od_Id = $(this).data('odid');
        const add_Id = $('input[name="address_id"]:checked').val();

       if (!add_Id) {
        $('#messageBox').html('<div class="alert alert-warning">Please select or add an address.</div>').fadeIn().delay(5000).fadeOut();
        
         $('html, body').animate({ scrollTop: $('#messageBox').offset().top - 100 }, 'fast');
        return;
    }

        $.post("<?= base_url('OrderNow/submitfrm') ?>", { od_Id, add_Id }, function(res) {
            if (res.status == 1) {
            $('#messageBox').html('<div class="alert alert-success">' + res.msg + '</div>').fadeIn().delay(5000).fadeOut();
            // You can optionally reset or update parts of the page here if needed
        } else {
            $('#messageBox').html('<div class="alert alert-danger">' + res.msg + '</div>').fadeIn().delay(5000).fadeOut();
        }
        });
    });
});
</script>
