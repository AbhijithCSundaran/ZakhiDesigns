<script>
$('#profileForm').submit(function(e) {
    e.preventDefault();
    $.post("<?= base_url('profile/update') ?>", $(this).serialize(), function(res) {
        if (res.status === 'success') {
            showMessage('Profile updated successfully!', 'success');
        } else {
            showMessage(res.msg || 'Update failed!', 'danger');
        }
    }, 'json');
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

$('#addressForm').submit(function(e){
    e.preventDefault();
    const id = $('#addressId').val();
    const url = id ? 'profile/address/edit' : 'profile/address/add';
    $.post("<?= base_url() ?>" + url, $(this).serialize(), function(res){
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
</script>

