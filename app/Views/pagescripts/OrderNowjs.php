<!-- pagescripts/OrderNowjs.php -->
<script>
    const phoneInput = document.querySelector("#newPhone");
    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });
 
    document.querySelector("#newAddressForm").addEventListener("submit", function (e) {
        const fullNumber = iti.getNumber();
        phoneInput.value = fullNumber;
    });
$(function() {
    $('#newPhone').on('input', function () {
        let value = $(this).val();
        let filtered = value.replace(/[^0-9\s\-]/g, '');
        $(this).val(filtered);
    });
    // Save new address and then confirm order
    $('#newAddressForm').on('submit', function(e) {
        e.preventDefault();
         const $submitBtn = $('#newAddressForm button[type="submit"]');
        $submitBtn.prop('disabled', true).hide();
        $.ajax({
            url: "<?= base_url('OrderNow/saveNewAddress') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json", // ensure JSON response is expected
            success: function(res) {
                if (res.success) {
                    $('input[name="address_id"]').prop('checked', false);
                    $('<input>').attr({
                        type: 'radio',
                        name: 'address_id',
                        value: res.insertId,
                        checked: true
                    }).appendTo('body').hide();

                    $('#messageBox').html('<div class="alert alert-success">' + res.message + '</div>').fadeIn().delay(5000).fadeOut();
                } else {
                    $('#messageBox').html('<div class="alert alert-danger">' + res.message + '</div>').fadeIn().delay(5000).fadeOut();
                }

                // Scroll to messageBox
                $('html, body').animate({
                    scrollTop: $('#messageBox').offset().top - 100
                }, 'slow');
            },
            error: function() {
                $('#messageBox').html('<div class="alert alert-danger">Failed to save address.</div>').fadeIn().delay(5000).fadeOut();

                // Scroll to messageBox on error
                $('html, body').animate({
                    scrollTop: $('#messageBox').offset().top - 100
                }, 'slow');
            },
             complete: function() {
            // Optional: Re-enable and show the button after 5 seconds
            setTimeout(() => {
                // $submitBtn.prop('disabled', false).show();
                $submitBtn.prop('disabled', true).hide();
            }, 5000);
        }
        });
    });

    // Final Order Submit
    // $('#confirmOrderBtn').on('click', function() {
    //     const od_Id = $(this).data('odid');
    //     const add_Id = $('input[name="address_id"]:checked').val();

    //     if (!add_Id) {
    //         $('#messageBox').html('<div class="alert alert-warning">Please select or add an address.</div>').fadeIn().delay(5000).fadeOut();
    //         return;
    //     }

    //     $.ajax({
    //         url: "<?= base_url('OrderNow/submitfrm') ?>",
    //         type: "POST",
    //         data: { od_Id, add_Id },
    //         dataType: "json",
    //         success: function(res) {
    //             if (res.status == 1) {
    //                 $('#messageBox')
    //                     .html('<div class="alert alert-success">' + res.msg + '</div>')
    //                     .fadeIn()
    //                     .delay(5000)
    //                     .fadeOut(function(){
    //                         window.location.href = res.redirect;
    //                     });
    //             } else {
    //                 $('#messageBox')
    //                     .html('<div class="alert alert-danger">' + res.msg + '</div>')
    //                     .fadeIn()
    //                     .delay(5000)
    //                     .fadeOut();
    //             }
    //             $('html, body').animate({
    //                 scrollTop: $('#messageBox').offset().top - 100
    //             }, 'slow');
    //         },
    //         error: function() {
    //             $('#messageBox').html('<div class="alert alert-danger">Failed to submit order.</div>').fadeIn().delay(5000).fadeOut();

    //             $('html, body').animate({
    //                 scrollTop: $('#messageBox').offset().top - 100
    //             }, 'slow');
    //         }
    //     });
    // });
    $('#confirmOrderBtn').on('click', function() {
    const $btn = $(this);             
    const od_Id = $btn.data('odid');
    const add_Id = $('input[name="address_id"]:checked').val();

    if (!add_Id) {
        $('#messageBox').html('<div class="alert alert-warning">Please select or add an address.</div>').fadeIn().delay(5000).fadeOut();
        return;
    }

    $btn.prop('disabled', true);      
    $btn.text('Processing...');      

    $.ajax({
        url: "<?= base_url('OrderNow/submitfrm') ?>",
        type: "POST",
        data: { od_Id, add_Id },
        dataType: "json",
        success: function(res) {
            if (res.status == 1) {
                $('#messageBox')
                    .html('<div class="alert alert-success">' + res.msg + '</div>')
                    .fadeIn()
                    .delay(5000)
                    .fadeOut(function() {
                        window.location.href = res.redirect;
                    });
            } else {
                $('#messageBox')
                    .html('<div class="alert alert-danger">' + res.msg + '</div>')
                    .fadeIn()
                    .delay(5000)
                    .fadeOut();
                $btn.prop('disabled', false).text('Confirm Order'); 
            }

            $('html, body').animate({
                scrollTop: $('#messageBox').offset().top - 100
            }, 'slow');
        },
        error: function() {
            $('#messageBox').html('<div class="alert alert-danger">Failed to submit order.</div>').fadeIn().delay(5000).fadeOut();
            $btn.prop('disabled', false).text('Confirm Order'); 

            $('html, body').animate({
                scrollTop: $('#messageBox').offset().top - 100
            }, 'slow');
        }
    });
});

});
</script>
