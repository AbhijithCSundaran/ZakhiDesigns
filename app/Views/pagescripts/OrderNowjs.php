<!-- pagescripts/OrderNowjs.php -->
<script>
$(function() {
    // Save new address and then confirm order
    $('#newAddressForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= base_url('OrderNow/saveNewAddress') ?>",
            type: "POST",
            data: $(this).serialize(),
            success: function(res) {
                if (res.success) {
                    $('input[name="address_id"]').prop('checked', false);
                    $('<input>').attr({
                        type: 'radio',
                        name: 'address_id',
                        value: res.insertId,
                        checked: true
                    }).appendTo('body').hide();
                    alert(res.message);
                } else {
                    alert(res.message);
                }
            },
            error: function() {
                alert('Failed to save address.');
            }
        });
    });

    // Final Order Submit
    $('#confirmOrderBtn').on('click', function() {
        const od_Id = $(this).data('odid');
        const add_Id = $('input[name="address_id"]:checked').val();

       if (!add_Id) {
        $('#messageBox').html('<div class="alert alert-warning">Please select or add an address.</div>').fadeIn().delay(5000).fadeOut();
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
