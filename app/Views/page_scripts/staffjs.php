
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

var baseUrl = "<?= base_url() ?>";

$('#staffSubmit').click(function(e) {
    e.preventDefault(); // Important to prevent normal form submit
    var url = baseUrl + "staff/save"; // Correct route

    $.post(url, $('#createstaff').serialize(), function(response) {
        $('#createstaff')[0].reset();

        if (response.status == 1) {
            $('#messageBox').text(response.msg).show();
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
        confirmButtonText: 'Yes, delete',
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