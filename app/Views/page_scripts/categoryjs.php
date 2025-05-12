<script>
//Data table
$(document).ready(function() {
    $('#categoryList').DataTable({
        "processing": true,
        "serverSide": false,
        "searching": true,
        "paging": true,
        "ordering": true,
        "info": true,

    });
});

//Add category

var baseUrl = "<?= base_url() ?>";
$('#categorySubmit').click(function(e) {
    e.preventDefault(); 
    var url = baseUrl + "category/save"; 

    $.post(url, $('#createCategory').serialize(), function(response) {
        if (response.status == 1) {
            $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Category Created Successfully!')
                .show();

            setTimeout(function() {
                window.location.href = baseUrl + "category/"; 
            }, 1500);
        } else {
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text(response.message || 'Please Fill all the Data')
                .show();
        }

        setTimeout(function() {
            $('#messageBox').empty().hide();
        }, 2000);
    }, 'json');
});

//Active and Inactive status
$(document).ready(function() {
    $('.checkactive').on('change', function() {
        let catId = $(this).val();
        let status = $(this).prop('checked') ? 1 : 2;
        $.ajax({
            url: '<?= base_url('category/status'); ?>',
            type: 'POST',
            data: {
                cat_Id: catId,
                cat_Status: status
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

//Delete
function confirmDelete(catId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this Category?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to delete
            $.ajax({
                url: "<?php echo base_url('category/delete'); ?>/" + catId,
                method: "POST",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        Swal.fire('Deleted!', response.msg, 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        Swal.fire('Error', response.msg, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            });
        }
    });
}
</script>