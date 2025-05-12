<script>
function confirmDelete(addId) {
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
                url: "<?php echo base_url('customer_address/delete'); ?>/" + addId,
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
/*********************************************/

var baseUrl = "<?= base_url() ?>";

$('#custSubmit').click(function(e) {
$('#custSubmit').prop('disabled', true);
    e.preventDefault(); // Important to prevent normal form submit
    var url = baseUrl + "customer_address/save"; // Correct route
    $.post(url, $('#createcustaddress').serialize(), function(response) {
       // $('#createstaff')[0].reset();
        if (response.status == 1) { 
		$('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Customer address created successfully!')
                .show();

            // Wait, then redirect
            setTimeout(function() {
				$('#custSubmit').prop('disabled', false);
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

</script>
