
<script>

$(document).ready(function() {
    $('#customerList').DataTable({
        "processing": true,
        "serverSide": false,
        "searching": true,
        "paging": true,
        "ordering": true,
        "info": true,

    });
});
$(document).ready(function () {
	const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^\d{10}$/;

	$('#custname').on('input', function () {
        const value = $(this).val().trim();
        $('#error-custname').text(value ? '' : 'Name is required.');
    });
    $('#custemail').on('input', function () {
        const value = $(this).val().trim();
        if (!value) {
            $('#error-custemail').text('Email is required.');
        } else if (!emailPattern.test(value)) {
            $('#error-custemail').text('Invalid email format.');
        } else {
            $('#error-custemail').text('');
        }
    });
    $('#mobile').on('input', function () {
        const value = $(this).val().trim();
        if (!value) {
            $('#error-mobile').text('Phone number is required.');
        } else if (!phonePattern.test(value)) {
            $('#error-mobile').text('Phone number must be 10 digits.');
        } else {
            $('#error-mobile').text('');
        }
    });

    $('#password').on('input', function () {
        const value = $(this).val().trim();
        $('#error-password').text(value ? '' : 'Password is required.');
    });
});




var baseUrl = "<?= base_url() ?>";

$('#custSubmit').click(function(e) {

    e.preventDefault(); // Important to prevent normal form submit
    var url = baseUrl + "customer/save"; // Correct route
console.log("response");
    $.post(url, $('#createcust').serialize(), function(response) {
       // $('#createstaff')[0].reset();
        if (response.status == 1) { 
		$('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Customer created successfully!')
                .show();

            // Wait, then redirect
            setTimeout(function() {
                window.location.href = baseUrl + "customer/"; // Update this path to your Manage Staff page
            }, 1500);
        } 
		else {
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text(response.msg || 'Please enter data correctly')
                .show();
        }
		setTimeout(function() {
                $('#messageBox').empty().hide();
            }, 2000);
    }, 'json');
});

/*********************************/

function confirmDelete(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this staff member?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to delete
            $.ajax({
                url: "<?php echo base_url('customer/delete'); ?>/" + userId,
                method: "POST",
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Deleted!', response.msg, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire('Error', response.msg, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            });
        }
    });
}
/*************************************/
//Active and Inactive status
$(document).ready(function() {
    $('.checkactive').on('change', function() {
        let custId = $(this).val();
        let status = $(this).prop('checked') ? 1 : 2;
        $.ajax({
            url: '<?= base_url('customer/status'); ?>',
            type: 'POST',
            data: {
                cust_Id: custId,
                cust_Status: status
            },
            headers: {
                'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
            },
            success: function(response) {
    const messageBox = $('#messageBox');
    
    if (response.status === 'success') {
        messageBox
            .removeClass('alert-danger')
            .addClass('alert alert-success')
            .text(response.message)
            .fadeIn();

    } else {
        messageBox
            .removeClass('alert-success')
            .addClass('alert alert-danger')
            .text(response.message)
            .fadeIn();
    }

    // Auto-hide the message after 1 seconds
    setTimeout(() => {
        messageBox.fadeOut();
    }, 1000);
},

error: function(xhr) {
    $('#messageBox')
        .removeClass('alert-success')
        .addClass('alert alert-danger')
        .text('Error updating status. Please try again later.')
        .fadeIn();

    setTimeout(() => {
        $('#messageBox').fadeOut();
    }, 1000);

    console.error(xhr.responseText);
}
        });
    });
});
</script>