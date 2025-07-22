<!-- pagescripts/OrderNowjs.php -->
<script>
    function initPhoneInput() {
    const input = document.querySelector("#newPhone");
    if (!input) return;

    const iti = window.intlTelInput(input, {
        nationalMode: false,
        initialCountry: "in", // or "auto"
        preferredCountries: ["in", "us", "gb"],
        separateDialCode: true,
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/js/utils.js", // required for validation
    });

    // Save dial code to hidden input
    input.addEventListener("countrychange", function () {
        document.querySelector("#newphcode").value = "+" + iti.getSelectedCountryData().dialCode;
    });

    // On blur, validate number
    input.addEventListener("blur", function () {
        if (iti.isValidNumber()) {
            document.querySelector("#phone_valid").style.display = "block";
            document.querySelector("#phone_error").style.display = "none";
        } else {
            document.querySelector("#phone_error").textContent = "Invalid phone number";
            document.querySelector("#phone_error").style.display = "block";
            document.querySelector("#phone_valid").style.display = "none";
        }
    });
}

   window.phoneInputs = window.phoneInputs || {};
initPhoneInput("#newPhone"); // already in your DOMContentLoaded

    document.addEventListener("DOMContentLoaded", function () {
        const input = document.querySelector("#newPhone");
        const formatDiv = document.querySelector("#phone_format");

        if (!input || !formatDiv) return;

        const iti = window.intlTelInput(input, {
            initialCountry: "in",
            preferredCountries: ["in", "us", "ae"],
            nationalMode: false,
            separateDialCode: true,
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/js/utils.js"
        });

        // Store reference
        window.phoneInputs = window.phoneInputs || {};
        window.phoneInputs["#newPhone"] = iti;

        // Update hidden input on country change
        input.addEventListener("countrychange", function () {
            document.querySelector("#newphcode").value = "+" + iti.getSelectedCountryData().dialCode;
            updatePhoneFormatHint("#newPhone");
        });

        // Validate on input
        input.addEventListener("input", function () {
            if (iti.isValidNumber()) {
                document.querySelector("#phone_valid").style.display = "block";
                document.querySelector("#phone_error").style.display = "none";
            } else {
                document.querySelector("#phone_valid").style.display = "none";
                document.querySelector("#phone_error").style.display = "block";
                document.querySelector("#phone_error").innerText = "Invalid phone number";
            }
        });

        // Initial setup
        document.querySelector("#newphcode").value = "+" + iti.getSelectedCountryData().dialCode;
        updatePhoneFormatHint("#newPhone");
    });

    function updatePhoneFormatHint(selector) {
        const input = document.querySelector(selector);
        const iti = window.phoneInputs[selector];
        const formatDiv = document.querySelector("#phone_format");

        if (iti && window.intlTelInputUtils && formatDiv) {
            const iso2 = iti.getSelectedCountryData().iso2;
            const example = intlTelInputUtils.getExampleNumber(iso2, true, intlTelInputUtils.numberFormat.INTERNATIONAL);
            formatDiv.textContent = "Phone Format Example: " + example;
        } else {
            formatDiv.textContent = "";
        }
    }


 
    document.querySelector("#newAddressForm").addEventListener("submit", function (e) {
        const fullNumber = iti.getNumber();
        phoneInput.value = fullNumber;
    });
$(function() {
 
    // Save new address and then confirm order
   $('#newAddressForm').on('submit', function (e) {
    e.preventDefault();

    const phoneSelector = "#newPhone"; // Case-sensitive
    const phoneInput = $(phoneSelector)[0];
    const iti = window.phoneInputs[phoneSelector];

    if (!iti || !iti.isValidNumber()) {
        $('#phone_error').text("Invalid phone number").show();
        $('#phone_valid').hide();
        return;
    }

    // Set hidden input with full number (e.g. +91 9876543210)
    const fullPhone = iti.getNumber();
    $('#newphcode').val(fullPhone); // use this to send full number (not just dial code)

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

function toggleEditLinks() {
        document.querySelectorAll('.form-check-input[name="address_id"]').forEach(radio => {
            const editLink = radio.closest('.form-check').querySelector('.edit-link');
            if (radio.checked) {
                editLink.style.display = 'inline';
            } else {
                editLink.style.display = 'none';
            }
        });
    }
    function storeEditInfo(event) {
        event.preventDefault();
 
        const addressId = event.currentTarget.getAttribute('data-id');
        const productId = event.currentTarget.getAttribute('data-product-id');
 
        if (addressId) {
            sessionStorage.setItem('edit_address_id', addressId);
        }
 
        if (productId) {
            sessionStorage.setItem('edit_product_id', productId);
        }
 
        // Redirect to the address section
        window.location.href = event.currentTarget.href;
    }
 
    document.addEventListener('DOMContentLoaded', toggleEditLinks);
 
    $(document).ready(function () {
        const editAddressId = sessionStorage.getItem('edit_address_id');
        const editProductId = sessionStorage.getItem('edit_product_id');
 
        if (editAddressId) {
            // Switch to address tab
            const addressTabTrigger = document.querySelector('#address-tab');
            if (addressTabTrigger) {
                const tab = new bootstrap.Tab(addressTabTrigger);
                tab.show();
            }
 
            // Load address data via existing function
            setTimeout(() => {
                if (typeof editAddress === 'function') {
                    editAddress(editAddressId);
                }
 
                // OPTIONAL: use the product ID
                if (editProductId) {
                    console.log("Editing product ID:", editProductId);
                    // You can pre-fill hidden fields or do more here
                    $('#edit_product_id').val(editProductId); // example
                }
            }, 300);
 
            // Clean up
            sessionStorage.removeItem('edit_address_id');
            sessionStorage.removeItem('edit_product_id');
        }
    });
 
</script>
