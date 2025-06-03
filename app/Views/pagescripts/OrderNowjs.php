<script>
var baseUrl = "<?= base_url() ?>";
$(document).ready(function() {
    $('#orderNowForm').on('submit', function(e) {
        e.preventDefault(); // Stop normal form submission

        var url = "<?= base_url('ordernow/submit') ?>"; // Submit URL

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

                    // Redirect after success
                    if (response.od_Id) {
                        setTimeout(function () {
                            window.location.href = "<?= base_url('ordernow/product/') ?>" + response.od_Id;
                        }, 3000);
                    }
                }, 3000); // <-- this was missing in your code
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



/*******************************************************************************/
function loadAddress(id) {
    fetch('<?= base_url('ordernow/getAddress/') ?>' + id)
        .then(res => res.json())
        .then(data => {
            document.getElementById('fname').value = data.add_Name;
            document.getElementById('Place').value = data.add_City;
            document.getElementById('emailid').value = data.add_Email;
            document.getElementById('contactno').value = data.add_Phone;
            document.getElementById('deliveryAddress').value =
                `${data.add_BuldingNo}, ${data.add_Street}\n${data.add_Landmark}\n${data.add_City}, ${data.add_State}\n${data.add_Pincode}\n${data.add_Phone}`;
        });
}

function saveNewAddress() {
    const data = {
        add_Name: document.getElementById('newName').value,
        add_Email: document.getElementById('newEmail').value,
        add_Phone: document.getElementById('newPhone').value,
        add_BuldingNo: document.getElementById('newBuilding').value,
        add_Street: document.getElementById('newStreet').value,
        add_Landmark: document.getElementById('newLandmark').value,
        add_City: document.getElementById('newCity').value,
        add_State: document.getElementById('newState').value,
        add_Pincode: document.getElementById('newPincode').value,
        add_Default: document.getElementById('newDefault').checked ? 1 : 0
    };

    fetch('<?= base_url('ordernow/saveAddress') ?>', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
    })
    .then(res => res.json())
    .then(data => {
        alert('Address saved');
        loadAddress(data.add_ID);
    });
}


</script>
<script>
function openAccordionItem(targetId) {
  const collapseElement = document.getElementById(targetId);
  const collapse = new bootstrap.Collapse(collapseElement, {
    toggle: true
  });
}
</script>


<script>
var baseUrl = "<?= base_url() ?>";
function saveAndSetAddress() {
    const form = document.getElementById('orderaddress');
    const formData = new FormData(form);

    fetch("<?= base_url('ordernow/save-new-address') ?>", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(response => {
        if (response.status === 'success') {
            const address = response.address;

            // Update the default address section dynamically
            document.querySelector("input[name='fname']").value = address.add_Name;
            document.querySelector("input[name='place']").value = address.add_City;
            document.querySelector("input[name='email']").value = address.add_Email;
            document.querySelector("input[name='phone']").value = address.add_Phone;
            document.querySelector("textarea[name='address']").value =
                `${address.add_BuldingNo}, ${address.add_Street}\n` +
                `${address.add_Landmark}\n` +
                `${address.add_City}, ${address.add_State}\n` +
                `${address.add_Pincode}\n` +
                `${address.add_Phone}`;

            // Optionally collapse the new address accordion
            const newAddressSection = document.getElementById('accordionNew');
            if (newAddressSection) newAddressSection.classList.remove('show');

            // Show success alert or message
            alert("Address saved and set as default.");
        } else {
            alert("Failed to save address. Please try again.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("An error occurred while saving the address.");
    });
}

</script>

