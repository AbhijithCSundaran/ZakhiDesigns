<script>
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
    var url = baseUrl + "admin/save"; // Correct route

    $.post(url, $('#createstaff').serialize(), function(response) {
       // $('#createstaff')[0].reset();

        if (response.status == 1) { $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Updated successfully!')
                .show();
        } 
		else {
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text(response.msg || 'Please enter data correctly')
                .show();
			$btn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Saving...');
        }
		setTimeout(function() {
                $('#messageBox').empty().hide();
            }, 2000);
    }, 'json');
});
</script>