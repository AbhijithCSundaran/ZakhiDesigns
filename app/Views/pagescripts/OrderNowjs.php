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
// Enable the 'Use This Address' button only when a radio is selected
document.querySelectorAll('input[name="selectedAddress"]').forEach(radio => {
  radio.addEventListener('change', () => {
    document.getElementById('useSelectedAddressBtn').disabled = false;
  });
});

// Function to call on button click
function useSelectedAddress() {
  const selectedRadio = document.querySelector('input[name="selectedAddress"]:checked');
  if (!selectedRadio) {
    alert('Please select an address first.');
    return;
  }

  fetch('<?= base_url('ordernow/getAddress/') ?>' + selectedRadio.value)
    .then(res => res.json())
    .then(data => {
      // Update Section 1 input fields
      document.getElementById('fname').value = data.add_Name;
      document.getElementById('Place').value = data.add_City;
      document.getElementById('emailid').value = data.add_Email;
      document.getElementById('contactno').value = data.add_Phone;
      document.getElementById('deliveryAddress').value =
        `${data.add_BuldingNo}, ${data.add_Street}\n` +
        `${data.add_Landmark}\n` +
        `${data.add_City}, ${data.add_State}\n` +
        `${data.add_Pincode}\n` +
        `${data.add_Phone}`;

      // Optional: Close accordion if needed
      const collapseExisting = bootstrap.Collapse.getOrCreateInstance(document.getElementById('collapseExisting'));
      collapseExisting.hide();
    })
    .catch(error => {
      console.error("Error fetching address:", error);
      alert("Failed to load the selected address.");
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
        loadAddress(data.add_Id);
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

    fetch("<?= base_url('ordernow/saveNewAddress') ?>", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            const addr = data.address;

            // Update default address section
            document.querySelector("input[name='fname']").value = addr.add_Name;
            document.querySelector("input[name='email']").value = addr.add_Email;
            document.querySelector("input[name='phone']").value = addr.add_Phone;
            document.querySelector("input[name='place']").value = addr.add_City;
            document.querySelector("textarea[name='address']").value = 
                `${addr.add_BuldingNo}, ${addr.add_Street}\n${addr.add_Landmark}\n${addr.add_City}, ${addr.add_State}\n${addr.add_Pincode}\n${addr.add_Phone}`;

            // Optional: Close "Add New Address" accordion and open default
            document.getElementById('collapseNew').classList.remove('show');
            document.getElementById('collapseDefault').classList.add('show');
        } else {
            alert(data.msg || 'Something went wrong');
        }
    });
}
</script>

