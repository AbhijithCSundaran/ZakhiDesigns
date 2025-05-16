
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

/*********************************/

function confirmDelete(theId) {
	console.log("Deleting ID:", theId);
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this banner ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to delete
            $.ajax({
                url: "<?php echo base_url('banner/delete'); ?>/" + theId,
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
        let theId = $(this).val();
        let status = $(this).prop('checked') ? 1 : 2;
        $.ajax({
            url: '<?= base_url('banner/status'); ?>',
            type: 'POST',
            data: {
                the_Id: theId,
                the_Status: status
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
/************************************************/
var baseUrl = "<?= base_url() ?>";

$('#imageSubmit').click(function (e) {
    e.preventDefault();
    $('#imageSubmit').prop('disabled', true);

    var form = $('#banner_add')[0];
    var formData = new FormData(form);

    $.ajax({
        url: baseUrl + "banner/save", // Route to your controller method
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function (response) {
            if (response.status == 1) {
                $('#messageBox')
                    .removeClass('alert-danger')
                    .addClass('alert-success')
                    .text(response.msg)
                    .show();

                setTimeout(function () {
                    $('#imageSubmit').prop('disabled', false);
                    window.location.href = baseUrl + "banner";
                }, 1000);
            } else {
                $('#messageBox')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .text(response.msg)
                    .show();
                $('#imageSubmit').prop('disabled', false);
            }

            setTimeout(function () {
                $('#messageBox').hide();
            }, 3000);
        },
		
		error: function (xhr, status, error) {
    console.error("AJAX Error:", xhr.responseText);
    $('#messageBox')
        .removeClass('alert-success')
        .addClass('alert-danger')
        .text('Server error. Please try again.')
        .show();
    $('#imageSubmit').prop('disabled', false);
}

    });
});

/*********************************/
$('#banner_image').on('change', function () {
    const [file] = this.files;
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            $('#imagePreview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(file);
    }
});

</script>