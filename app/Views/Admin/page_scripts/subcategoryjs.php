<script>
//Data table
var baseUrl = "<?= base_url() ?>";
var csrfTokenName = "<?= csrf_token() ?>";
var csrfHash = "<?= csrf_hash() ?>";

$('#subcategoryList').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: baseUrl + "admin/subcategory/List",
        type: "POST",
        data: function(d) {
            d[csrfTokenName] = csrfHash;
        }
    },
    columns: [{
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1; // Serial number
            },
            orderable: false,
            searchable: false
        },
        {
            data: 'cat_Name'
        },
        {
            data: 'sub_Category_Name'
        },
        {
            data: 'sub_Discount_Value'
        },
        {
            data: 'sub_Discount_Type'
        },
        {
            data: 'status_switch'
        },
        {
            data: 'actions'
        }
    ],
    columnDefs: [{
            targets: [5, 6],
            orderable: false,
            searchable: false
        },
        {
            targets: 5,
            render: function(data, type, row) {
                return data;
            }
        }
    ]
});
//Add Subcategory

var baseUrl = "<?= base_url() ?>";

$('#subcategorySubmit').click(function(e) {
    e.preventDefault();
    var url = baseUrl + "admin/subcategory/save";

    $.post(url, $('#createSubcategory').serialize(), function(response) {
        if (response.status == 1) {
            $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Subcategory Created Successfully!')
                .show();

            setTimeout(function() {
                window.location.href = baseUrl + "admin/subcategory/";
            }, 3000);
        } else {
            $('#messageBox')
                .removeClass('alert-success')
                .addClass('alert-danger')
                .text(response.message || 'Please fill all the data')
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
        text: 'You want to delete this SubCategory?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('admin/subcategory/delete'); ?>/" + subId,
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
//Active Inactive status Change
$(document).ready(function() {
    $('.checkactive').on('change', function() {
        let subId = $(this).val();
        let status = $(this).prop('checked') ? 1 : 2;
        $.ajax({
            url: '<?= base_url('admin/subcategory/status'); ?>',
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