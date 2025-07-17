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
$(document).ready(function () {
    const phoneInputs = {
        "#phone": null,
        "#newPhone": null,
        "#add_Phone": null
    };

    function initPhoneInput(selector) {
        const input = document.querySelector(selector);
        const iti = window.intlTelInput(input, {
            initialCountry: "auto",
            geoIpLookup: function (callback) {
                $.get("https://ipinfo.io", function () {}, "jsonp").always(function (resp) {
                    const countryCode = (resp && resp.country) ? resp.country : "IN";
                    callback(countryCode);
                });
            },
            utilsScript: "js/utils.js"
        });

        input.dataset.original = input.value.trim(); // Save original for change check

        input.addEventListener("countrychange", function () {
            input.value = ""; // Clear number if flag changes
        });

        input.addEventListener("input", function () {
            const errorDiv = document.querySelector(selector + "_error");
            const validDiv = document.querySelector(selector + "_valid");
            if (!input.value.trim()) {
                errorDiv.style.display = "none";
                validDiv.style.display = "none";
                return;
            }
            if (iti.isValidNumber()) {
                errorDiv.style.display = "none";
                validDiv.style.display = "block";
            } else {
                validDiv.style.display = "none";
                errorDiv.textContent = "Invalid phone number.";
                errorDiv.style.display = "block";
            }
        });

        phoneInputs[selector] = iti;
    }

    initPhoneInput("#phone");
    initPhoneInput("#newPhone");
    initPhoneInput("#add_Phone");

    function isPhoneValid(selector) {
        const input = document.querySelector(selector);
        const iti = phoneInputs[selector];
        const original = input.dataset.original || "";

        // No changes made
        if (input.value.trim() === original) return true;

        // Validate if changed
        return iti && iti.isValidNumber();
    }

    function appendPhoneData(formSelector, selector, codeField) {
        const input = document.querySelector(selector);
        const iti = phoneInputs[selector];
        if (iti) {
            const number = iti.getNumber();
            const code = iti.getSelectedCountryData().dialCode;
            $(formSelector).append(`<input type="hidden" name="${codeField}" value="${code}">`);
            $(selector).val(number); // set formatted number
        }
    }

    // Profile Form Submission
    $('#profileForm').on('submit', function (e) {
        e.preventDefault();
        if (!isPhoneValid("#phone")) return;

        appendPhoneData("#profileForm", "#phone", "cust_phcode");

        $.ajax({
            type: 'POST',
            url: '<?= base_url('profile/editprofile') ?>',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (response) {
                $('html, body').animate({ scrollTop: 0 }, 'fast');
                $('#messageBox')
                    .removeClass('alert-success alert-danger')
                    .addClass('alert-' + (response.status === 'success' ? 'success' : 'danger'))
                    .html(response.msg)
                    .fadeIn();
                if (response.status === 'success') {
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    setTimeout(() => $('#messageBox').fadeOut(), 5000);
                }
            },
            error: function () {
                $('#messageBox')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .html('An error occurred. Please try again.')
                    .fadeIn();
                setTimeout(() => $('#messageBox').fadeOut(), 5000);
            }
        });
    });

    // Address Form Submission (Add New)
  
    $('#addressForm').on('submit', function (e) {
        e.preventDefault();
        if (!isPhoneValid("#add_Phone")) return;

        appendPhoneData("#addressForm", "#add_Phone", "add_phcode");

        const id = $('#addressId').val();
        const url = id ? 'profile/address/edit' : 'profile/address/add';
        $.post("<?= base_url() ?>" + url, $(this).serialize(), function (res) {
            if (res.status === 'success') {
                showMessage('Address Saved Successfully!', 'success');
                setTimeout(() => location.reload(), 3000);
            } else {
                showMessage(res.msg || 'Failed To Save Address.', 'danger');
            }
        }, 'json');
    });

    // Set tab and password toggle
    let hash = window.location.hash;
    if (hash) {
        $('.nav-link[href="' + hash + '"]').tab('show');
    }
    $('.nav-link[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        history.replaceState(null, null, e.target.hash);
    });

    document.querySelectorAll(".toggle-password").forEach(function (icon) {
        icon.addEventListener("click", function () {
            const targetId = this.getAttribute("data-target");
            const input = document.getElementById(targetId);
            const isPassword = input.getAttribute("type") === "password";
            input.setAttribute("type", isPassword ? "text" : "password");
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });
    });

    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault();
        const oldPassword = $('#oldPassword').val().trim();
        const newPassword = $('#newPassword').val().trim();
        const confirmPassword = $('#confirmPassword').val().trim();
        const messageBox = $('#messageBox');

        if (!oldPassword || !newPassword || !confirmPassword) {
            showMessage('All fields are required!', 'danger'); return;
        }
        if (newPassword.length < 6) {
            showMessage('New Password Must Be At Least 6 Characters Long!', 'danger'); return;
        }
        if (newPassword !== confirmPassword) {
            showMessage('New Password And Confirm Password Do Not Match!', 'danger'); return;
        }

        $.post("<?= base_url('profile/change_password') ?>", $(this).serialize(), function (response) {
            showMessage(response.msg, response.status ? 'success' : 'danger');
            if (response.status) $('#changePasswordForm')[0].reset();
        }, 'json');
    });

    function showMessage(msg, type = 'success') {
        const $box = $('#messageBox');
        $box
            .removeClass('alert-success alert-danger')
            .addClass('alert-' + type)
            .html(msg)
            .fadeIn();
        $('html, body').animate({ scrollTop: $box.offset().top - 20 }, 500);
        setTimeout(() => $box.fadeOut(), 3000);
    }
});

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
$('#editAddressForm').submit(function(e) {
    e.preventDefault();
    $.post("<?= base_url('profile/address/edit') ?>", $(this).serialize(), function(res) {
        if (res.status === 'success') {
            showMessage('Address Updated Successfully!', 'success');
            $('#editAddressModal').modal('hide');
            setTimeout(() => location.reload(), 3000);
        } else {
            showMessage(res.msg || 'Failed To Update Address.', 'danger');
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
</script>
