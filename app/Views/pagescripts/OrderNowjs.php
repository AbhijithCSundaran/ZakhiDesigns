<script>
document.addEventListener('DOMContentLoaded', function () {
    const baseUrl = "<?= base_url() ?>";

    const useAddressBtn = document.getElementById('useSelectedAddressBtn');
    const orderAddressForm = document.getElementById('orderAddressForm');
    const orderNowForm = document.getElementById('orderNowForm');
    const messageBox = document.getElementById('messageBox');

    // ----------------------------- VALIDATION HELPERS -----------------------------
    const validators = {
        name: name => /^[A-Za-z\s]+$/.test(name.trim()),
        email: email => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.trim()),
        phone: phone => /^\d{10}$/.test(phone.trim()),
        addressField: addr => /^[A-Za-z0-9_\-,./\s]+$/.test(addr.trim()),
        pincode: pincode => /^\d{6}$/.test(pincode.trim())
    };

    function showMessage(message, type = 'success') {
        messageBox.textContent = message;
        messageBox.className = 'alert alert-' + (type === 'success' ? 'success' : 'danger');
        messageBox.style.display = 'block';
        window.scrollTo({ top: 0, behavior: 'smooth' });

        setTimeout(() => {
            messageBox.style.display = 'none';
        }, 3000);
    }

    // ----------------------------- POPULATE DELIVERY FIELDS -----------------------------
    function populateDeliveryFields(data) {
        document.getElementById('fname').value = data.add_Name || '';
        document.getElementById('Place').value = data.add_City || '';
        document.getElementById('emailid').value = data.add_Email || '';
        document.getElementById('contactno').value = data.add_Phone || '';

        const addr = [
            data.add_BuldingNo || '',
            data.add_Street || '',
            data.add_Landmark || '',
            data.add_City || '',
            data.add_State || '',
            data.add_Pincode || '',
            data.add_Phone || ''
        ].filter(Boolean).join(', ');

        document.getElementById('deliveryAddress').value = addr;
    }

    // ----------------------------- COLLAPSE / EXPAND -----------------------------
    function toggleAccordionCollapse(hideId, showId) {
        const toHide = document.getElementById(hideId);
        const toShow = document.getElementById(showId);
        if (toHide) bootstrap.Collapse.getOrCreateInstance(toHide).hide();
        if (toShow) bootstrap.Collapse.getOrCreateInstance(toShow).show();
        setTimeout(() => {
            toShow.scrollIntoView({ behavior: 'smooth' });
        }, 300);
    }

    // ----------------------------- SELECT EXISTING ADDRESS -----------------------------
    document.querySelectorAll('input[name="selectedAddress"]').forEach(input => {
        input.addEventListener('change', () => {
            useAddressBtn.disabled = false;
        });
    });

    useAddressBtn.addEventListener('click', function () {
        const selected = document.querySelector('input[name="selectedAddress"]:checked');
        if (!selected) return alert("Please select an address first.");

        useAddressBtn.disabled = true;
        useAddressBtn.innerText = 'Loading...';

        fetch(baseUrl + 'ordernow/getAddress/' + selected.value)
            .then(res => res.json())
            .then(data => {
                if (!data || !data.add_Name) throw new Error("Invalid data");

                populateDeliveryFields(data);
                document.getElementById('addressIdHidden').value = data.add_Id || '';

                toggleAccordionCollapse('collapseExisting', 'collapseDefault');
            })
            .catch(err => {
                console.error(err);
                alert("Failed to load address.");
            })
            .finally(() => {
                useAddressBtn.disabled = false;
                useAddressBtn.innerText = 'Use This Address';
            });
    });

    // ----------------------------- SAVE NEW ADDRESS -----------------------------
    orderAddressForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(orderAddressForm);

        const fields = {
            name: formData.get('newName'),
            email: formData.get('newEmail'),
            phone: formData.get('newPhone'),
            building: formData.get('newBuilding'),
            street: formData.get('newStreet'),
            landmark: formData.get('newLandmark'),
            city: formData.get('newCity'),
            state: formData.get('newState'),
            pincode: formData.get('newPincode')
        };

        if (!validators.name(fields.name)) return showMessage('Name must contain only alphabets and spaces.', 'error');
        if (!validators.email(fields.email)) return showMessage('Invalid email address.', 'error');
        if (!validators.phone(fields.phone)) return showMessage('Phone number must be exactly 10 digits.', 'error');

        for (let key of ['building', 'street', 'landmark', 'city', 'state']) {
            if (!validators.addressField(fields[key])) {
                return showMessage('Address fields contain invalid characters.', 'error');
            }
        }

        if (!validators.pincode(fields.pincode)) return showMessage('Pincode must be 6 digits.', 'error');

        fetch(baseUrl + 'ordernow/saveAddress', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success && data.details) {
                populateDeliveryFields(data.details);
                orderAddressForm.reset();
                document.getElementById('addressIdHidden').value = data.insertId;
                showMessage('Address saved and set as default!');

                // Collapse all and open delivery section
                document.querySelectorAll('.accordion-collapse').forEach(el => {
                    bootstrap.Collapse.getOrCreateInstance(el).hide();
                });
                bootstrap.Collapse.getOrCreateInstance(document.getElementById('collapseDefault')).show();
            } else {
                showMessage('Failed to save address.', 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showMessage('Something went wrong while saving the address.', 'error');
        });
    });

    // ----------------------------- SUBMIT ORDER FORM -----------------------------
    orderNowForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const fname = form.querySelector('#fname').value.trim();
        const email = form.querySelector('#emailid').value.trim();
        const contact = form.querySelector('#contactno').value.trim();
        const address = form.querySelector('#deliveryAddress').value.trim();

        if (!fname || !email || !contact || !address) {
            return alert('Please fill in all delivery details.');
        }

        const formData = new FormData(form);

        fetch(baseUrl + 'ordernow/submitfrm', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 1) {
                alert(data.msg);
                // Optional: window.location.href = baseUrl + 'order/confirmation';
            } else {
                alert('Failed: ' + data.msg);
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error placing order.');
        });
    });

});
</script>
