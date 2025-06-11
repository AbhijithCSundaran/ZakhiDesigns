<script>

document.addEventListener('DOMContentLoaded', function () {
    const baseUrl = "<?= base_url() ?>";

    // Enable "Use This Address" button when a radio is selected
    document.querySelectorAll('input[name="selectedAddress"]').forEach(input => {
        input.addEventListener('change', function () {
            document.getElementById('useSelectedAddressBtn').disabled = false;
        });
    });

    // Handle "Use This Address" button click
    document.getElementById('useSelectedAddressBtn').addEventListener('click', useSelectedAddress);

    // Handle save new address form submission
    document.getElementById('orderAddressForm').addEventListener('submit', saveAndSetAddress);

    // Handle order form submission
    document.getElementById('orderNowForm').addEventListener('submit', submitOrderForm);
});




// Populate form fields with address data
function populateDeliveryFields(data) {
    document.getElementById('fname').value = data.add_Name;
    document.getElementById('Place').value = data.add_City;
    document.getElementById('emailid').value = data.add_Email;
    document.getElementById('contactno').value = data.add_Phone;
    document.getElementById('deliveryAddress').value =
        `${data.add_BuldingNo}, ${data.add_Street}\n${data.add_Landmark}\n${data.add_City}, ${data.add_State}\n${data.add_Pincode}\n${data.add_Phone}`;
}

// Use selected existing address
function useSelectedAddress() {
    const selectedRadio = document.querySelector('input[name="selectedAddress"]:checked');
    if (!selectedRadio) {
        alert('Please select an address first.');
        return;
    }

    const button = document.getElementById('useSelectedAddressBtn');
    button.disabled = true;
    button.innerText = 'Loading...';

    fetch("<?= base_url('ordernow/getAddress/') ?>" + selectedRadio.value)
        .then(res => res.json())
        .then(data => {
            if (!data || !data.add_Name) {
                alert("Invalid address returned.");
                return;
            }
            document.getElementById('fname').value = data.add_Name || '';
            document.getElementById('Place').value = data.add_City || '';
            document.getElementById('emailid').value = data.add_Email || '';
            document.getElementById('contactno').value = data.add_Phone || '';
            document.getElementById('deliveryAddress').value =
                (data.add_BuldingNo || '') + ', ' + (data.add_Street || '') + '\n' +
                (data.add_Landmark || '') + '\n' +
                (data.add_City || '') + ', ' + (data.add_State || '') + '\n' +
                (data.add_Pincode || '') + '\n' +
                (data.add_Phone || '');

            // Set hidden addressId field
            document.getElementById('addressIdHidden').value = data.add_Id || '';

            // Collapse existing address section
            const collapseExisting = bootstrap.Collapse.getOrCreateInstance(document.getElementById('collapseExisting'));
            collapseExisting.hide();

            // Expand delivery address section
            const collapseDefault = bootstrap.Collapse.getOrCreateInstance(document.getElementById('collapseDefault'));
            collapseDefault.show();

            // Scroll into view smoothly
            setTimeout(() => {
                document.getElementById('collapseDefault').scrollIntoView({ behavior: 'smooth' });
            }, 300);
        })
        .catch(error => {
            console.error("Error fetching address:", error);
            alert("Failed to load the selected address.");
        })
        .finally(() => {
            button.disabled = false;
            button.innerText = 'Use This Address';
        });
}

// Save new address and populate fields
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('orderAddressForm');
    const messageBox = document.getElementById('messageBox');

    function showMessage(message, type = 'success') {
        messageBox.textContent = message;
        messageBox.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger');
        messageBox.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });

        setTimeout(() => {
            messageBox.style.display = 'none';
        }, 3000);
    }

    function validateName(name) {
        return /^[A-Za-z\s]+$/.test(name.trim());
    }

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
    }

    function validatePhone(phone) {
        return /^\d{10}$/.test(phone.trim());
    }

    function validateAddressField(addr) {
        return /^[A-Za-z0-9_\-,./\s]+$/.test(addr.trim());
    }

    function validatePincode(pincode) {
        return /^\d{6}$/.test(pincode.trim());
    }

    function populateDeliveryFields(details) {
        document.getElementById('fname').value = details.add_Name || '';
        document.getElementById('Place').value = details.add_City || '';
        document.getElementById('emailid').value = details.add_Email || '';
        document.getElementById('contactno').value = details.add_Phone || '';

        const addr = [
            details.add_BuldingNo,
            details.add_Street,
            details.add_Landmark,
            details.add_City,
            details.add_State,
            details.add_Pincode,
            details.add_Phone
        ].filter(Boolean).join(', ');

        document.getElementById('deliveryAddress').value = addr;
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();

        const name = form.newName.value.trim();
        const email = form.newEmail.value.trim();
        const phone = form.newPhone.value.trim();
        const building = form.newBuilding.value.trim();
        const street = form.newStreet.value.trim();
        const landmark = form.newLandmark.value.trim();
        const city = form.newCity.value.trim();
        const state = form.newState.value.trim();
        const pincode = form.newPincode.value.trim();

        // Inline validation with focus on the first error
        if (!name) {
            showMessage('Full Name is required.', 'error');
            form.newName.focus();
            return;
        }
        if (!validateName(name)) {
            showMessage('Name must contain only alphabets and spaces.', 'error');
            form.newName.focus();
            return;
        }

        if (!email) {
            showMessage('Email is required.', 'error');
            form.newEmail.focus();
            return;
        }
        if (!validateEmail(email)) {
            showMessage('Please enter a valid email address.', 'error');
            form.newEmail.focus();
            return;
        }

        if (!phone) {
            showMessage('Phone number is required.', 'error');
            form.newPhone.focus();
            return;
        }
        if (!validatePhone(phone)) {
            showMessage('Phone number must be exactly 10 digits.', 'error');
            form.newPhone.focus();
            return;
        }

        const addressFields = [
            { value: building, field: form.newBuilding, label: 'Building No.' },
            { value: street, field: form.newStreet, label: 'Street' },
            { value: landmark, field: form.newLandmark, label: 'Landmark' },
            { value: city, field: form.newCity, label: 'City' },
            { value: state, field: form.newState, label: 'State' }
        ];

        for (const item of addressFields) {
            if (!item.value) {
                showMessage(`${item.label} is required.`, 'error');
                item.field.focus();
                return;
            }
            if (!validateAddressField(item.value)) {
                showMessage(`${item.label} contains invalid characters.`, 'error');
                item.field.focus();
                return;
            }
        }

        if (!pincode) {
            showMessage('Pincode is required.', 'error');
            form.newPincode.focus();
            return;
        }
        if (!validatePincode(pincode)) {
            showMessage('Pincode must be exactly 6 digits.', 'error');
            form.newPincode.focus();
            return;
        }

        const formData = new FormData(form);

        fetch("<?= base_url('ordernow/saveAddress') ?>", {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.details) {
                populateDeliveryFields(data.details);
                form.reset();
                document.getElementById('addressIdHidden').value = data.insertId;

                showMessage('Address saved and set as default!', 'success');

                // Collapse all accordions
                const accordion = document.getElementById('addressAccordion');
                accordion.querySelectorAll('.accordion-collapse').forEach(collapseEl => {
                    const bsCollapse = bootstrap.Collapse.getInstance(collapseEl);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    } else {
                        new bootstrap.Collapse(collapseEl, { toggle: false }).hide();
                    }
                });

                // Expand delivery address section
                const deliveryCollapse = document.getElementById('collapseDefault');
                const deliveryCollapseInstance = bootstrap.Collapse.getInstance(deliveryCollapse);
                if (deliveryCollapseInstance) {
                    deliveryCollapseInstance.show();
                } else {
                    new bootstrap.Collapse(deliveryCollapse, { toggle: true });
                }
            } else {
                showMessage(data.msg || 'Failed to save address or fetch default.', 'error');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            showMessage('Something went wrong while saving the address.', 'error');
        });
    });
});

// Submit the order form
   var baseUrl = "<?= base_url() ?>";

$('#orderNowBtn').click(function (e) {
    e.preventDefault();
    $('#orderNowBtn').prop('disabled', true);

    const zd_uid = "<?= session()->get('zd_uid'); ?>";

    // Scroll to top and clear previous message
    $('html, body').animate({ scrollTop: 0 }, 'fast');
    $('#messageBox').removeClass('alert-success alert-danger').hide();

    // Check login
    if (!zd_uid) {
        $('#modalBody').load(baseUrl + "weblogin", function () {
            $('#mainModal').modal('show');
        });
        $('#orderNowBtn').prop('disabled', false);
        return;
    }

    // Validate fields
    let fname = $('#fname').val().trim();
    let email = $('#emailid').val().trim();
    let contact = $('#contactno').val().trim();
    let address = $('#deliveryAddress').val().trim();
    let size = $('#size').val();
    let color = $('#selected_color').val();
    let qty = $('#qty').val();

    if (!fname || !email || !contact || !address || !size || !color || !qty) {
        $('#messageBox')
            .addClass('alert alert-danger')
            .text('Please fill in all required fields: Name, Email, Contact, Address, Size, Color, and Quantity.')
            .fadeIn();

        $('#orderNowBtn').prop('disabled', false);

        setTimeout(() => $('#messageBox').fadeOut(), 4000);
        return;
    }

    // AJAX submit
    const form = $('#orderNowForm')[0];
    const formData = new FormData(form);

    $.ajax({
        url: baseUrl + "ordernow/submitfrm",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function (response) {
            $('html, body').animate({ scrollTop: 0 }, 'fast');
            $('#messageBox').removeClass('alert-danger alert-success').hide();

            if (response.status == 1) {
                $('#messageBox')
                    .addClass('alert alert-success')
                    .html(response.msg)
                    .fadeIn();

                setTimeout(() => {
                    $('#messageBox').fadeOut();
                    if (response.redirect) {
                        window.location.href = response.redirect;
                    }
                }, 3000);
            } else {
                $('#messageBox')
                    .addClass('alert alert-danger')
                    .html('Failed: ' + response.msg)
                    .fadeIn();

                setTimeout(() => $('#messageBox').fadeOut(), 4000);
            }

            $('#orderNowBtn').prop('disabled', false);
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error:', error);

            $('#messageBox')
                .addClass('alert alert-danger')
                .text('A server error occurred: ' + error)
                .fadeIn();

            setTimeout(() => $('#messageBox').fadeOut(), 5000);
            $('#orderNowBtn').prop('disabled', false);
        }
    });
});

// Utility: Open accordion item by ID
function openAccordionItem(targetId) {
    const collapseElement = document.getElementById(targetId);
    new bootstrap.Collapse(collapseElement, { toggle: true });
}
</script>
