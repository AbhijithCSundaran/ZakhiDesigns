<script>
//Data table
$(document).ready(function() {
    $('#subcategoryList').DataTable({
        "processing": true,
        "serverSide": false,
        "searching": true,
        "paging": true,
        "ordering": true,
        "info": true,

    });
});

//Add Subcategory

var baseUrl = "<?= base_url() ?>";

$('#subcategorySubmit').click(function(e) {
    e.preventDefault(); 
    var url = baseUrl + "subcategory/save"; 

    $.post(url, $('#createSubcategory').serialize(), function(response) {
       

        if (response.status == 1) { $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Sub category created successfully!')
                .show();

            // Wait, then redirect
            setTimeout(function() {
                window.location.href = baseUrl + "subcategory/"; 
            }, 1500);
        } 
		else {
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text(response.msg || 'Please Fill all the Data')
                .show();
        }
		setTimeout(function() {
                $('#messageBox').empty().hide();
            }, 2000);
    }, 'json');
});

//Delete Sub category
function confirmDelete(subId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Do you want to delete this SubCategory?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('subcategory/delete'); ?>/" + subId,
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
//Active Inactive status Change
$(document).ready(function() {
    $('.checkactive').on('change', function() {
        let subId = $(this).val();
        let status = $(this).prop('checked') ? 1 : 2;
        $.ajax({
            url: '<?= base_url('subcategory/status'); ?>',
            type: 'POST',
            data: {
                sub_Id: subId,
                sub_Status: status
            },
            headers: {
                'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
            },
            success: function(response) {
                const messageBox = $('#messageBox');

                if (response.message === 'Status Updated Successfully!') {
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