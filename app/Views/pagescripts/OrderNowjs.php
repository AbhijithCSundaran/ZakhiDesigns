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

            // ✅ Populate delivery section
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
    // Form elements
    const form = document.getElementById('orderAddressForm');
    const messageBox = document.getElementById('messageBox');

    // Helper to show message in messageBox for 3 seconds and scroll top
    function showMessage(message, type = 'success') {
        messageBox.textContent = message;
        messageBox.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger');
        messageBox.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });

        setTimeout(() => {
            messageBox.style.display = 'none';
        }, 3000);
    }

    // Validation functions
    function validateName(name) {
        return /^[A-Za-z\s]+$/.test(name.trim());
    }

    function validateEmail(email) {
        // simple email regex
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim());
    }

    function validatePhone(phone) {
        return /^\d{10}$/.test(phone.trim());
    }

    function validateAddressField(addr) {
        // letters, digits, underscore, hyphen, comma, slash, full stop, space allowed
        return /^[A-Za-z0-9_\-,./\s]+$/.test(addr.trim());
    }

    function validatePincode(pincode) {
        return /^\d{6}$/.test(pincode.trim());
    }

    // Populate delivery fields from saved address details
    function populateDeliveryFields(details) {
        document.getElementById('fname').value = details.add_Name || '';
        document.getElementById('Place').value = details.add_City || '';
        document.getElementById('emailid').value = details.add_Email || '';
        document.getElementById('contactno').value = details.add_Phone || '';

        // Compose delivery address text (adjust fields as needed)
        const addr = [
            details.add_BuldingNo || '',
            details.add_Street || '',
            details.add_Landmark || '',
            details.add_City || '',
            details.add_State || '',
            details.add_Pincode || '',
            details.add_Phone || ''
        ].filter(Boolean).join(', ');

        document.getElementById('deliveryAddress').value = addr;
    }

    // Main form submit handler for saving new address
    form.addEventListener('submit', function (event) {
        event.preventDefault();

        // Gather form data
        const name = form.newName.value;
        const email = form.newEmail.value;
        const phone = form.newPhone.value;
        const building = form.newBuilding.value;
        const street = form.newStreet.value;
        const landmark = form.newLandmark.value;
        const city = form.newCity.value;
        const state = form.newState.value;
        const pincode = form.newPincode.value;

        // Validate inputs
        if (!validateName(name)) {
            showMessage('Name must contain only alphabets and spaces.', 'error');
            return;
        }
        if (!validateEmail(email)) {
            showMessage('Please enter a valid email address.', 'error');
            return;
        }
        if (!validatePhone(phone)) {
            showMessage('Phone number must be exactly 10 digits.', 'error');
            return;
        }
        if (!validateAddressField(building) || !validateAddressField(street) || !validateAddressField(landmark) || !validateAddressField(city) || !validateAddressField(state)) {
            showMessage('Address fields contain invalid characters.', 'error');
            return;
        }
        if (!validatePincode(pincode)) {
            showMessage('Pincode must be exactly 6 digits.', 'error');
            return;
        }

        // If all validations pass, submit via fetch
        const formData = new FormData(form);

        fetch('<?= base_url('ordernow/saveAddress') ?>', {
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

                // Collapse all accordion items first
                const accordion = document.getElementById('addressAccordion');
                accordion.querySelectorAll('.accordion-collapse').forEach(collapseEl => {
                    const bsCollapse = bootstrap.Collapse.getInstance(collapseEl);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    } else {
                        new bootstrap.Collapse(collapseEl, { toggle: false }).hide();
                    }
                });

                // Open the Delivery to This Address accordion
                const deliveryCollapse = document.getElementById('collapseDefault');
                const deliveryCollapseInstance = bootstrap.Collapse.getInstance(deliveryCollapse);
                if (deliveryCollapseInstance) {
                    deliveryCollapseInstance.show();
                } else {
                    new bootstrap.Collapse(deliveryCollapse, { toggle: true });
                }
            } else {
                showMessage('Failed to save address or fetch default.', 'error');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            showMessage('Something went wrong while saving the address.', 'error');
        });
    });
});


// Submit the order form
function submitOrderForm(e) {
    e.preventDefault();

    const form = e.target;
    const fname = form.querySelector('#fname').value.trim();
    const email = form.querySelector('#emailid').value.trim();
    const contact = form.querySelector('#contactno').value.trim();
    const address = form.querySelector('#deliveryAddress').value.trim();

    if (!fname || !email || !contact || !address) {
        alert('Please fill in all delivery details.');
        return;
    }

    const formData = new FormData(form);

    fetch('<?= base_url('ordernow/submitfrm') ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 1) {
            alert(data.msg);
            // Optionally redirect or reload
        } else {
            alert('Failed: ' + data.msg);
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('An error occurred while placing the order.');
    });
}

// Utility: Open accordion item by ID
function openAccordionItem(targetId) {
    const collapseElement = document.getElementById(targetId);
    new bootstrap.Collapse(collapseElement, { toggle: true });
}
</script>
