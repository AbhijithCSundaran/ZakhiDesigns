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
const itiInstances = {};
function setupIntlTelInput(selector) {
    const input = document.querySelector(selector);
    if (!input) return;

    // Destroy existing if already initialized
    if (itiInstances[selector]) {
        itiInstances[selector].destroy();
    }

    itiInstances[selector] = window.intlTelInput(input, {
        initialCountry: "in",
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });

    // Restrict characters
    $(selector).on('input', function () {
        let filtered = $(this).val().replace(/[^0-9\s\-]/g, '');
        $(this).val(filtered);
    });
}
$(document).ready(function () {
    setupIntlTelInput("#newPhone");          
    setupIntlTelInput("#add_Phone");        
    setupIntlTelInput("#phone");      
    setupIntlTelInput("#number"); 
});

function validatePhoneNumber(selector, alertBoxId = "messageBox") {
    const iti = itiInstances[selector];
    if (!iti) return false;

    // Extract national number (without country code)
    let number = iti.getNumber(intlTelInputUtils.numberFormat.NATIONAL);
    number = number.replace(/\D/g, ''); // Strip all non-digit characters

    // Validate 7 to 15 digit length
    if (number.length < 7 || number.length > 20) {
        const errorHtml = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Phone Number must be between 7 to 15 digits (excluding country code).
            </div>
        `;

        $(`#${alertBoxId}`).html(errorHtml).fadeIn();

        // Auto-hide alert after 3 seconds
        setTimeout(() => {
            $(`#${alertBoxId} .alert`).fadeOut(300, function () {
                $(this).remove();
            });
        }, 3000);

        $(selector).focus();
        return false;
    }

    // Set full international number (with country code) into the input value
    document.querySelector(selector).value = iti.getNumber();
    return true;
}



$('#profileForm').on('submit', function(e) {
    e.preventDefault();
     const isValid = validatePhoneNumber("#phone");
    if (!isValid) return;

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
            showMessage(res.msg || 'Failed To Load Address Data.', 'danger');
        }
    }, 'json');
}
let originalPhone = $('#add_Phone').val().trim();

$('#editAddressForm').submit(function(e) {
    e.preventDefault();

    const currentPhone = $('#add_Phone').val().trim();

    // Validate only if the phone was changed
    if (currentPhone !== originalPhone && !validatePhoneNumber("#add_Phone", "editAlert")) {
        return;
    }

    $.post("<?= base_url('profile/address/edit') ?>", $(this).serialize(), function(res) {
        if (res.status === 'success') {
            showMessage('Address Updated Successfully!', 'success');
            $('#editAddressModal').modal('hide');
            setTimeout(() => location.reload(), 3000);
        } else {
            $('#editAlert').html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${res.msg || 'Failed To Update Address.'}
                </div>
            `);
            setTimeout(() => {
                $('#editAlert .alert').fadeOut(300, function () {
                    $(this).remove();
                });
            }, 3000);
        }
    }, 'json');
});

$('#addressForm').submit(function(e) {
    e.preventDefault();
    
    const id = $('#addressId').val();
    // const phone = $('#newPhone').val().trim();
    // const phonePattern = /^\d{7,15}$/;
     if (!validatePhoneNumber("#newPhone")) return;
    // if (!phonePattern.test(phone)) {
    //     showMessage('Phone Number Must Be Between 7 To 15 Digits.', 'danger');
    //     $('#newPhone').focus();
    //     return;
    // }

    const url = id ? 'profile/address/edit' : 'profile/address/add';
    $.post("<?= base_url() ?>" + url, $(this).serialize(), function(res) {
        if (res.status === 'success') {
            showMessage('Address Saved Successfully!', 'success');
            setTimeout(() => location.reload(), 3000);
        } else {
            showMessage(res.msg || 'Failed To Save Address.', 'danger');
        }
    }, 'json');
});


function openDeleteModal(id) {
    document.getElementById('delete_add_id').value = id;
    var modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
function confirmDeleteAddress() {
    const addId = document.getElementById('delete_add_id').value;

    setTimeout(function () {
        $.ajax({
            url: '<?= base_url("profile/deleteAddress") ?>',
            type: 'POST',
            data: { add_Id: addId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
                    modal.hide();
                    window.location.href = "<?= base_url('profile#address') ?>";
                } else {
                    alert(response.message);
                }
            },
            error: function () {
                alert('Something Went Wrong. Please Try Again.');
            }
        });
    },1000);
}

    // Wait until page is fully loaded
    window.addEventListener('DOMContentLoaded', function () {
        const flashMsg = document.getElementById('flashMessage');
        if (flashMsg) {
            setTimeout(() => {
                flashMsg.style.display = 'none';
            }, 3000); // 3 seconds
        }
    });


function setDefaultAddress(id) {
    $.post("<?= base_url('profile/setDefaultAddress') ?>", { add_Id: id }, function(res) {
        if (res.status === 'success') {
            showMessage('Default Address Updated.', 'success');
            setTimeout(() => location.reload(), 3000);
        } else {
            showMessage(res.msg || 'Failed To Update Default Address.', 'danger');
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
            .html('New Password Must Be At Least 6 Characters Long!')
            .fadeIn();

        setTimeout(() => messageBox.fadeOut(), 4000);
        return;
    }

    if (newPassword !== confirmPassword) {
        messageBox
            .removeClass('alert-success alert-danger')
            .addClass('alert alert-danger')
            .html('New Password And Confirm Password Do Not Match!')
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
/////////////////////////////////////////////////////////////////////
const newPasswordInput = document.getElementById('newPassword');
        const strengthBar = document.getElementById('new-password-strength-bar');
        const strengthFill = document.getElementById('new-password-strength-fill');
        const strengthText = document.getElementById('new-password-strength-text');
 
        newPasswordInput.addEventListener('input', function () {
            const value = newPasswordInput.value;
            const result = calculatePasswordStrength(value);
 
            if (value.length > 0) {
                strengthBar.style.display = 'block';
            } else {
                strengthBar.style.display = 'none';
                strengthText.innerText = '';
                strengthText.style.color = '';
                return;
            }
 
            strengthFill.style.width = result.percent + '%';
            strengthFill.className = 'progress-bar bg-' + result.color;
            strengthText.innerText = result.label;
            strengthText.style.color = getTextColor(result.color);
        });
 
        function calculatePasswordStrength(password) {
            let score = 0;
            if (password.length >= 8) score++;
            if (/[A-Z]/.test(password)) score++;
            if (/[a-z]/.test(password)) score++;
            if (/\d/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;
 
            switch (score) {
                case 0:
                case 1: return { percent: 20, color: 'danger', label: 'Very Weak' };
                case 2: return { percent: 40, color: 'warning', label: 'Weak' };
                case 3: return { percent: 60, color: 'info', label: 'Moderate' };
                case 4: return { percent: 80, color: 'primary', label: 'Strong' };
                case 5: return { percent: 100, color: 'success', label: 'Very Strong' };
                default: return { percent: 0, color: 'secondary', label: '' };
            }
        }
 
        function getTextColor(color) {
            switch (color) {
                case 'danger': return '#dc3545';
                case 'warning': return '#ffc107';
                case 'info': return '#17a2b8';
                case 'primary': return '#007bff';
                case 'success': return '#28a745';
                default: return '#6c757d';
            }
        }
   


</script>


