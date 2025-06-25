<script>
$(document).ready(function () {
    $('.login-check').click(function (e) {
        const zd_uid = "<?= session()->get('zd_uid'); ?>";

        if (!zd_uid) {
            e.preventDefault(); // Stop navigation

            // Load login form into modal and show it
            $('#modalBody').load("<?= base_url('weblogin'); ?>", function () {
                $('#mainModal').modal('show');
            });
        }
    });
});

$('#profileForm').on('submit', function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: '<?= base_url('profile/editprofile') ?>',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            $('html, body').animate({   scrollTop: 0  }, 'fast');

            $('#messageBox')
                .removeClass('alert-success alert-danger')
                .addClass('alert-' + (response.status === 'success' ? 'success' : 'danger'))
                .html(response.msg)
                .fadeIn();
            // Auto-hide and optionally reload updated data
            if (response.status === 'success') {
                setTimeout(function () {
                    location.reload(); // reloads profile data from server
                }, 2000);
                
            } else {
                $('html, body').animate({   scrollTop: 0  }, 'fast');

                setTimeout(() => $('#messageBox').fadeOut(), 5000);
            }
        },
        error: function () {
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .html('An error occurred. Please try again.')
                .fadeIn();
            $('html, body').animate({ scrollTop: 0 }, 'fast');
            setTimeout(() => $('#messageBox').fadeOut(), 5000);
            
        }
    });
});


function openAddAddressForm() {
    $('#addressFormContainer').show();
    $('#addressForm')[0].reset();
    $('#addressId').val('');

    // Smooth scroll to the form
    $('html, body').animate({
        scrollTop: $('#addressFormContainer').offset().top - 100 // adjust offset if needed
    }, 500); // 500ms duration
}
function discardAddressForm() {
    $('#addressFormContainer').hide();
    $('#addressForm')[0].reset();
    $('#addressId').val('');
}


function editAddress(id) {
    $.post("<?= base_url('profile/getAddress') ?>", { add_Id: id }, function(res) {
        if (res.status === 'success') {
            const addr = res.data;
            $('#add_Id').val(addr.add_Id);
			$('#add_CustId').val(addr.add_CustId);
            $('#add_Name').val(addr.add_Name);
            $('#add_Phone').val(addr.add_Phone);
            $('#add_Email').val(addr.add_Email);
            $('#add_BuldingNo').val(addr.add_BuldingNo);
            $('#add_Street').val(addr.add_Street);
            $('#add_Landmark').val(addr.add_Landmark);
            $('#add_City').val(addr.add_City);
            $('#add_State').val(addr.add_State);
            $('#add_Pincode').val(addr.add_Pincode);
            $('#is_default').prop('checked', addr.is_default == 1);
            const modal = new bootstrap.Modal(document.getElementById('editAddressModal'));
            modal.show();
        } else {
            showMessage(res.msg || 'Failed to load address data.', 'danger');
        }
    }, 'json');
}
$('#editAddressForm').submit(function(e) {
    e.preventDefault();
    $.post("<?= base_url('profile/address/edit') ?>", $(this).serialize(), function(res) {
        if (res.status === 'success') {
            showMessage('Address updated successfully!', 'success');
            $('#editAddressModal').modal('hide');
            setTimeout(() => location.reload(), 3000);
        } else {
            showMessage(res.msg || 'Failed to update address.', 'danger');
        }
    }, 'json');
});

$('#addressForm').submit(function(e) {
    e.preventDefault();
    
    const id = $('#addressId').val();
    const phone = $('#newPhone').val().trim();
    const phonePattern = /^\d{7,15}$/;

    if (!phonePattern.test(phone)) {
        showMessage('Phone number must be between 7 to 15 digits.', 'danger');
        $('#newPhone').focus();
        return;
    }

    const url = id ? 'profile/address/edit' : 'profile/address/add';
    $.post("<?= base_url() ?>" + url, $(this).serialize(), function(res) {
        if (res.status === 'success') {
            showMessage('Address saved successfully!', 'success');
            setTimeout(() => location.reload(), 3000);
        } else {
            showMessage(res.msg || 'Failed to save address.', 'danger');
        }
    }, 'json');
});


function deleteAddress(id) {
    if (confirm("Are you sure to delete this address?")) {
        $.post("<?= base_url('profile/address/delete') ?>", { add_Id: id }, function(res) {
            if (res.status === 'success') {
                showMessage('Address deleted.', 'success');
                setTimeout(() => location.reload(), 3000);
            } else {
                showMessage(res.msg || 'Failed to delete address.', 'danger');
            }
        }, 'json');
    }
}


function setDefaultAddress(id) {
    $.post("<?= base_url('profile/setDefaultAddress') ?>", { add_Id: id }, function(res) {
        if (res.status === 'success') {
            showMessage('Default address updated.', 'success');
            setTimeout(() => location.reload(), 3000);
        } else {
            showMessage(res.msg || 'Failed to update default address.', 'danger');
        }
    }, 'json');
}

function showMessage(msg, type = 'success') {
    const $box = $('#messageBox');
    $box
        .removeClass('alert-success alert-danger')
        .addClass('alert-' + type)
        .html(msg)
        .fadeIn();

    // Scroll to message box
    $('html, body').animate({
        scrollTop: $box.offset().top - 20
    }, 500);

    setTimeout(() => {
        $box.fadeOut();
    }, 3000);
}

$(document).ready(function() {
    let hash = window.location.hash;
    if (hash) {
        $('.nav-link[href="' + hash + '"]').tab('show');
    }

    $('.nav-link[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        history.replaceState(null, null, e.target.hash);
    });
});

document.querySelectorAll(".toggle-password").forEach(function(icon) {
    icon.addEventListener("click", function() {
        const targetId = this.getAttribute("data-target");
        const input = document.getElementById(targetId);
        const isPassword = input.getAttribute("type") === "password";
        input.setAttribute("type", isPassword ? "text" : "password");
        this.classList.toggle("fa-eye");
        this.classList.toggle("fa-eye-slash");
    });
});

  
$('#changePasswordForm').on('submit', function(e) {
    e.preventDefault();

    const oldPassword = $('#oldPassword').val().trim();
    const newPassword = $('#newPassword').val().trim();
    const confirmPassword = $('#confirmPassword').val().trim();
    const messageBox = $('#messageBox');

    // Basic validations
    if (!oldPassword || !newPassword || !confirmPassword) {
        messageBox
            .removeClass('alert-success alert-danger')
            .addClass('alert alert-danger')
            .html('All fields are required!')
            .fadeIn();

        setTimeout(() => messageBox.fadeOut(), 4000);
        return;
    }


    if (newPassword.length < 6) {
        messageBox
            .removeClass('alert-success alert-danger')
            .addClass('alert alert-danger')
            .html('New Password must be at least 6 characters long!')
            .fadeIn();

        setTimeout(() => messageBox.fadeOut(), 4000);
        return;
    }

    if (newPassword !== confirmPassword) {
        messageBox
            .removeClass('alert-success alert-danger')
            .addClass('alert alert-danger')
            .html('New Password and Confirm Password do not match!')
            .fadeIn();

        setTimeout(() => messageBox.fadeOut(), 4000);
        return;
    }

    // All good — proceed to submit
    $.post("<?= base_url('profile/change_password') ?>", $(this).serialize(), function(response) {
        messageBox
            .removeClass('alert-success alert-danger')
            .addClass('alert ' + (response.status ? 'alert-success' : 'alert-danger'))
            .html(response.msg)
            .fadeIn();

        $('html, body').animate({ scrollTop: messageBox.offset().top - 20 }, 'fast');

        setTimeout(() => messageBox.fadeOut(), 5000);

        if (response.status) {
            $('#changePasswordForm')[0].reset();
        }
    }, 'json');
});



</script>


