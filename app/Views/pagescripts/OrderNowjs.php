<!-- pagescripts/OrderNowjs.php -->
<script>
    const orderId = "<?= esc($od_Id) ?>";
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

    $(document).ready(function () {
        const selectedAddressId = sessionStorage.getItem('selectedAddressId');
        if (selectedAddressId) {
            const $radio = $('input[name="address_id"][value="' + selectedAddressId + '"]');
            if ($radio.length) {
                $radio.prop('checked', true);
                renderAddressLabel($radio[0]);
            }
        }
    });

    function saveSelectedAddress(input) {
        const addressId = $(input).val();
        sessionStorage.setItem('selectedAddressId', addressId);
    }


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

        const link = $(event.currentTarget);
        const addressId = event.currentTarget.getAttribute('data-id');
        const productId = event.currentTarget.getAttribute('data-product-id');

        if (addressId) {
            sessionStorage.setItem('edit_address_id', addressId);
        }

        if (productId) {
            sessionStorage.setItem('edit_product_id', productId);
        }

        // Redirect to the address section
        window.location.href = link.attr('href');
    }
    function renderAddressLabel(radio) {
        const $radio = $(radio);
        const id = $radio.data('id');
        const label = $('#address-label-' + id);

        const name = $radio.data('name') || '';
        const phone = $radio.data('phone') || '';
        const building = $radio.data('building') || '';
        const street = $radio.data('street') || '';
        const landmark = $radio.data('landmark') || '';
        const city = $radio.data('city') || '';
        const pincode = $radio.data('pincode') || '';
        const state = $radio.data('state') || '';

        const formatted = `
        ${name} - ${phone}<br>
        ${building}, ${street}, ${landmark}<br>
        ${city} - ${pincode}<br>
        ${state}
    `;

        label.html(formatted);
    }

    function generateAddressHtml(address) {
        const id = address.add_Id;
        const orderId = "<?= esc($od_Id) ?>";
        const selectedId = sessionStorage.getItem('selectedAddressId');
        const isChecked = selectedId == id ? 'checked' : '';

        return `
    <div class="form-check mb-2 position-relative" id="address-${id}">
        <input class="form-check-input" type="radio" name="address_id"
            value="${id}" ${isChecked}
            data-id="${id}"
            data-name="${address.add_Name}"
            data-phone="${address.add_Phone}"
            data-building="${address.add_BuldingNo}"
            data-street="${address.add_Street}"
            data-landmark="${address.add_Landmark}"
            data-city="${address.add_City}"
            data-pincode="${address.add_Pincode}"
            data-state="${address.add_State}"
            onchange="renderAddressLabel(this); toggleEditLinks(); saveSelectedAddress(this);">
 
        <label class="form-check-label" id="address-label-${id}">
            ${address.add_Name} - ${address.add_Phone}<br>
            ${address.add_BuldingNo}, ${address.add_Street}, ${address.add_Landmark}<br>
            ${address.add_City} - ${address.add_Pincode}<br>
            ${address.add_State}
        </label>
 
        <a href="${baseUrl}/profile#address" class="edit-link btn btn-sm btn-link"
            data-id="${id}"
            data-product-id="${orderId}"
            onclick="storeEditInfo(event)"
            style="display:none;"><span class="edit-address-orders">Edit</span></a>
    </div>`;
    }

    $(function () {

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
                success: function (res) {
                    if (res.success) {
                        // toggleEditLinks();
                        const a = res.details;

                        const newHtml = `
                            <div class="form-check mb-2 position-relative" id="address-${a.add_Id}">
                                <input class="form-check-input" type="radio" name="address_id"
                                    value="${a.add_Id}" checked
                                    data-id="${a.add_Id}"
                                    data-name="${a.add_Name}"
                                    data-phone="${a.add_Phone}"
                                    data-building="${a.add_BuldingNo}"
                                    data-street="${a.add_Street}"
                                    data-landmark="${a.add_Landmark}"
                                    data-city="${a.add_City}"
                                    data-pincode="${a.add_Pincode}"
                                    data-state="${a.add_State}"
                                    onchange="renderAddressLabel(this); toggleEditLinks(); saveSelectedAddress(this);">
 
                                <label class="form-check-label" id="address-label-${a.add_Id}">
                                    ${a.add_Name} - ${a.add_Phone}<br>
                                    ${a.add_BuldingNo}, ${a.add_Street}, ${a.add_Landmark}<br>
                                    ${a.add_City} - ${a.add_Pincode}<br>
                                    ${a.add_State}
                                </label>
 
                                <a href="<?= base_url('profile#address') ?>" class="edit-link btn btn-sm btn-link"
                                    data-id="${a.add_Id}" data-product-id="${orderId}" onclick="storeEditInfo(event)"
                                    style="display:none;"> <span class="edit-address-orders">Edit</span></a>
                            </div>`;

                        $('#selectExistAddress').append(newHtml);
                        const $newRadio = $(`input[name="address_id"][value="${a.add_Id}"]`);
                        renderAddressLabel($newRadio[0]);
                        toggleEditLinks();


                        $('#messageBox').html('<div class="alert alert-success">' + res.message + '</div>').fadeIn().delay(5000).fadeOut();

                        // Optionally reset form
                        $('#newAddressForm')[0].reset();
                        $('html, body').animate({
                            scrollTop: $('#address-' + a.add_Id).offset().top - 100
                        }, 'slow');

                        $('#collapseNew').collapse('hide');
                        $('#collapseSelect').collapse('show');

                        sessionStorage.setItem('selectedAddressId', a.add_Id);
                    } else {
                        $('#messageBox').html('<div class="alert alert-danger">' + res.message + '</div>').fadeIn().delay(5000).fadeOut();
                    }
                },
                error: function () {
                    $('#messageBox').html('<div class="alert alert-danger">Failed to save address.</div>').fadeIn().delay(5000).fadeOut();
                    $('html, body').animate({
                        scrollTop: $('#messageBox').offset().top - 100
                    }, 'slow');
                },
                complete: function () {
                    setTimeout(() => {
                        $submitBtn.prop('disabled', true).show();
                    }, 5000);
                }
            });
        });


        // $('#confirmOrderBtn').on('click', function () {
        //     const $btn = $(this);
        //     const od_Id = $btn.data('odid');
        //     const add_Id = $('input[name="address_id"]:checked').val();

        //     if (!add_Id) {
        //         $('#messageBox').html('<div class="alert alert-warning">Please select or add an address.</div>')
        //         .fadeIn()
        //         .delay(5000)
        //         .fadeOut();
        //         $('html, body').animate({
        //                 scrollTop: $('#messageBox').offset().top - 100
        //             }, 'slow');
        //         return;
        //     }

        //     $btn.prop('disabled', true);
        //     $btn.text('Processing...');

        //     $.ajax({
        //         url: "<?= base_url('OrderNow/submitfrm') ?>",
        //         type: "POST",
        //         data: { od_Id, add_Id },
        //         dataType: "json",
        //         success: function (res) {
        //             if (res.status == 1) {
        //                 $('#messageBox')
        //                     .html('<div class="alert alert-success">' + res.msg + '</div>')
        //                     .fadeIn()
        //                     .delay(5000)
        //                     .fadeOut(function () {
        //                         window.location.href = res.redirect;
        //                     });
        //             } else {
        //                 $('#messageBox')
        //                     .html('<div class="alert alert-danger">' + res.msg + '</div>')
        //                     .fadeIn()
        //                     .delay(5000)
        //                     .fadeOut();
        //                 $btn.prop('disabled', false).text('Confirm Order');
        //             }

        //             $('html, body').animate({
        //                 scrollTop: $('#messageBox').offset().top - 100
        //             }, 'slow');
        //         },
        //         error: function () {
        //             $('#messageBox').html('<div class="alert alert-danger">Failed to submit order.</div>').fadeIn().delay(5000).fadeOut();
        //             $btn.prop('disabled', false).text('Confirm Order');

        //             $('html, body').animate({
        //                 scrollTop: $('#messageBox').offset().top - 100
        //             }, 'slow');
        //         }
        //     });
        // });
        $('#confirmOrderBtn').on('click', function () {
            const $btn = $(this);
            const od_Id = $btn.data('odid');
            const add_Id = $('input[name="address_id"]:checked').val();

            if (!add_Id) {
                $('#messageBox')
                    .html('<div class="alert alert-warning">Please select or add an address.</div>')
                    .fadeIn()
                    .delay(5000)
                    .fadeOut();
                $('html, body').animate({
                    scrollTop: $('#messageBox').offset().top - 100
                }, 'slow');
                return;
            }

            $btn.prop('disabled', true).text('Processing...');

            $.ajax({
                url: "<?= base_url('OrderNow/submitfrm') ?>",
                type: "POST",
                data: { od_Id, add_Id },
                dataType: "json",
                success: function (res) {
                    if (res.success) {
                        const newAddress = res.newAddress;

                        // Remove previous address with same ID if exists (prevent duplicates)
                        $(`.form-check input[value="${newAddress.add_Id}"]`).closest('.form-check').remove();

                        const addressHtml = generateAddressHtml(newAddress); // Build new address radio + label block
                        $('#selectExistAddress').append(addressHtml); // Append to container

                        // Re-render label content and set new radio as checked
                        const newRadio = $(`input[name="address_id"][value="${newAddress.add_Id}"]`)[0];
                        if (newRadio) {
                            newRadio.checked = true;
                            renderAddressLabel(newRadio);
                            toggleEditLinks();
                        }

                        toggleEditLinks(); // Ensure edit link shows on selected address

                        $('#messageBox')
                            .html('<div class="alert alert-success">' + res.msg + '</div>')
                            .fadeIn()
                            .delay(5000)
                            .fadeOut();

                    } else {
                        $('#messageBox')
                            .html('<div class="alert alert-danger">' + res.msg + '</div>')
                            .fadeIn()
                            .delay(5000)
                            .fadeOut();
                    }

                    // Scroll to message
                    $('html, body').animate({
                        scrollTop: $('#messageBox').offset().top - 100
                    }, 'slow');

                    $btn.prop('disabled', false).text('Confirm Order');
                },
                error: function () {
                    $('#messageBox')
                        .html('<div class="alert alert-danger">Failed to submit order.</div>')
                        .fadeIn()
                        .delay(5000)
                        .fadeOut();

                    $('html, body').animate({
                        scrollTop: $('#messageBox').offset().top - 100
                    }, 'slow');

                    $btn.prop('disabled', false).text('Confirm Order');
                }
            });
        });

    });
    $(document).on('change', 'input[name="address_id"]', function () {
        const selectedId = $(this).val();
        sessionStorage.setItem('selectedAddressId', selectedId);
        toggleEditLinks();
    });


    document.addEventListener('DOMContentLoaded', toggleEditLinks);

    $(document).ready(function () {
        const selectedAddressId = sessionStorage.getItem('selectedAddressId');
        if (selectedAddressId) {
            const $radio = $('input[name="address_id"][value="' + selectedAddressId + '"]');
            if ($radio.length) {
                $radio.prop('checked', true);
            }
        }
 
        // Render labels
        $('input[name="address_id"]').each(function () {
            renderAddressLabel(this);
        });
 
        toggleEditLinks();
 
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

                if (editProductId) {
                    $('#edit_product_id').val(editProductId); // example
                }
                const $editedRadio = $('input[name="address_id"][value="' + editAddressId + '"]');
                if ($editedRadio.length) {
                    $editedRadio.prop('checked', true);
                    sessionStorage.setItem('selectedAddressId', editAddressId);
 
                    renderAddressLabel($editedRadio[0]);
                }
 
                toggleEditLinks();
 
 
                const $addressBlock = $('#address-' + editAddressId);
                if ($addressBlock.length) {
                    $('html, body').animate({
                        scrollTop: $addressBlock.offset().top - 100
                    }, 600);
                }
            }, 300);

            // Clean up
            sessionStorage.removeItem('edit_address_id');
            sessionStorage.removeItem('edit_product_id');
        }
    });

</script>