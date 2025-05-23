
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
	 let pwd = $('#password').val();
    let cpwd = $('#confirm_password').val();
    if (pwd !== cpwd) {
        $('#error-confirm-password').text('Passwords do not match');
        return false;
    } else {
        $('#error-confirm-password').text('');
    }
	$('#custSubmit').prop('disabled', true);
    e.preventDefault(); // Important to prevent normal form submit
    var url = baseUrl + "admin/customer/save"; // Correct route
    $.post(url, $('#createcust').serialize(), function(response) {
		$('html, body').animate({
            scrollTop: 0
        }, 'fast');
       // $('#createstaff')[0].reset();
        if (response.status == 1) { 
		$('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Customer created successfully!')
                .show();

            // Wait, then redirect
            setTimeout(function() {
				$('#custSubmit').prop('disabled', false);
                window.location.href = baseUrl + "admin/customer/"; // Update this path to your Manage Staff page
            }, 3000);
        } 
		else {
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text(response.msg || 'All mandatory fields are required')
                .show();
				$('#custSubmit').prop('disabled', false);
        }
		setTimeout(function() {
                $('#messageBox').empty().hide();
            }, 3000);
    }, 'json');
});

/*********************************/

function confirmDelete(addId) {
	console.log("Deleting ID:", addId);
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this customer ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to delete
            $.ajax({
                url: "<?php echo base_url('admin/customer/delete'); ?>/" + addId,
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
            url: '<?= base_url('admin/customer/status'); ?>',
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