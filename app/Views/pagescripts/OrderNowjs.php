<script>
$(document).ready(function () {
    const baseUrl = "<?= base_url() ?>";

    // Submit the order form
    // Enable "Use This Address" button when a radio is selected
    $('input[name="selectedAddress"]').on('change', function () {
        $('#useSelectedAddressBtn').prop('disabled', false);
    });
});

// Use selected existing address
function useSelectedAddress() {
    const selectedRadio = document.querySelector('input[name="selectedAddress"]:checked');
    if (!selectedRadio) {
        alert('Please select an address first.');
        return;
    }

    fetch("<?= base_url('ordernow/getAddress/') ?>" + selectedRadio.value)
	
        .then(res => res.json())
        .then(data => {
            document.getElementById('fname').value = data.add_Name;
            document.getElementById('Place').value = data.add_City;
            document.getElementById('emailid').value = data.add_Email;
            document.getElementById('contactno').value = data.add_Phone;
            document.getElementById('deliveryAddress').value =
                `${data.add_BuldingNo}, ${data.add_Street}\n${data.add_Landmark}\n${data.add_City}, ${data.add_State}\n${data.add_Pincode}\n${data.add_Phone}`;

            // Collapse existing address accordion
            const collapse = bootstrap.Collapse.getOrCreateInstance(document.getElementById('collapseExisting'));
            collapse.hide();
        })
        .catch(error => {
            console.error("Error fetching address:", error);
            alert("Failed to load the selected address.");
        });
}


function saveAndSetAddress(event) {
    event.preventDefault(); // prevent form from submitting the normal way

    const form = document.getElementById('orderAddressForm');
    const formData = new FormData(form);

    fetch('<?= base_url('ordernow/saveAddress') ?>', {
        method: 'POST', 
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.details) {
            const addr = data.details;
            document.getElementById('fname').value = addr.add_Name;
            document.getElementById('Place').value = addr.add_City;
            document.getElementById('emailid').value = addr.add_Email;
            document.getElementById('contactno').value = addr.add_Phone;
            document.getElementById('deliveryAddress').value =
                `${addr.add_BuldingNo}, ${addr.add_Street}\n${addr.add_Landmark}\n${addr.add_City}, ${addr.add_State}\n${addr.add_Pincode}\n${addr.add_Phone}`;
            form.reset(); // optional: clear the form after save
            alert('Address saved and set as default!');
        } else {
            alert('Failed to save address or fetch default.');
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('Something went wrong while saving the address.');
    });
}


// Optional: Manually open any accordion item by ID
function openAccordionItem(targetId) {
    const collapseElement = document.getElementById(targetId);
    new bootstrap.Collapse(collapseElement, { toggle: true });
}

document.getElementById('orderNowForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent default form submission

    const form = e.target;
    const formData = new FormData(form);

    fetch('<?= base_url('ordernow/submitfrm') ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 1) {
            alert(data.msg); // Show success message
            // Stay on current page - do nothing else
        } else {
            alert('Failed: ' + data.msg);
        }
    })
    .catch(err => {
        console.error('Error:', err);
        alert('An error occurred while placing the order.');
    });
});


</script>
