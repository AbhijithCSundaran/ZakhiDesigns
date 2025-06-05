<script>
//Data table
/*$(document).ready(function() {
    $('#categoryList').DataTable({
        "processing": true,
        "serverSide": false,
        "searching": true,
        "paging": true,
        "ordering": true,
        "info": true,

    });
});*/

$(document).ready(function () {
    var baseUrl = "<?= base_url() ?>";
    var csrfToken = "<?= csrf_token() ?>";
    var csrfHash = "<?= csrf_hash() ?>";

    $('#categoryList').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl + "admin/category/List",
            type: "POST",
            data: function (d) {
                d[csrfToken] = csrfHash;
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                orderable: false,
                searchable: false
            },
            { data: 'cat_Name' },
            { data: 'cat_Discount_Value' },
            { data: 'cat_Discount_Type' },
            { data: 'status_switch' },
            { data: 'actions' }
        ],
        columnDefs: [
            {
                targets: [4, 5], 
                orderable: false,
                searchable: false
            },
            {
                targets: 4, 
                render: function (data, type, row) {
                    return data;
                }
            }
        ]
    });
});


//Add category

var baseUrl = "<?= base_url() ?>";
$('#categorySubmit').click(function(e) {
    e.preventDefault(); 
    var url = baseUrl + "admin/category/save"; 

    $.post(url, $('#createCategory').serialize(), function(response) {
        if (response.status == 1) {
            $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Category Created Successfully!')
                .show();

            setTimeout(function() {
                window.location.href = baseUrl + "admin/category/"; 
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
            url: '<?= base_url('admin/category/status'); ?>',
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
            $.ajax({
                url: "<?php echo base_url('admin/category/delete/'); ?>" + catId,
                type: "POST",
                success: function(response) {
                    Swal.fire('Deleted!', 'Category has been deleted.', 'success')
                        .then(() => {
                            location.reload(); 
                        });
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                }
            });
        }
    });
}

</script>