
<script>

$(document).ready(function() {
    $('#staffList').DataTable({
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

	$('#staffname').on('input', function () {
        const value = $(this).val().trim();
        $('#error-staffname').text(value ? '' : 'Name is required.');
    });
    $('#staffemail').on('input', function () {
        const value = $(this).val().trim();
        if (!value) {
            $('#error-staffemail').text('Primary email is required.');
        } else if (!emailPattern.test(value)) {
            $('#error-staffemail').text('Invalid email format.');
        } else {
            $('#error-staffemail').text('');
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

$('#staffSubmit').click(function(e) {
    e.preventDefault(); // Important to prevent normal form submit
    var url = baseUrl + "staff/save"; // Correct route

    $.post(url, $('#createstaff').serialize(), function(response) {
       // $('#createstaff')[0].reset();

        if (response.status == 1) { $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Staff created successfully!')
                .show();

            // Wait, then redirect
            setTimeout(function() {
                window.location.href = baseUrl + "staff/"; // Update this path to your Manage Staff page
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
                url: "<?php echo base_url('staff/delete'); ?>/" + userId,
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
</script>