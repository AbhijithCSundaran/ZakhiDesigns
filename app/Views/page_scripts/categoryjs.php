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
    e.preventDefault(); // Important to prevent normal form submit
    var url = baseUrl + "category/save"; // Correct route

    $.post(url, $('#createCategory').serialize(), function(response) {
       

        if (response.status == 1) { $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Category created successfully!')
                .show();

            // Wait, then redirect
            setTimeout(function() {
                window.location.href = baseUrl + "category/"; // Update this path to your Manage Staff page
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
                if (response.success) {
                   alert('Status Updated Successfully');
                } else {
                    alert('Failed to update status. Try again.');
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error updating status.');
            }
        });
    });
});

//Delete

let categoryId = null;
function confirmDelete(cat_id) {
    categoryId = cat_id;
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function deleteCategory(){
    $.ajax({
        url: "<?php echo base_url('category/delete'); ?>/" + categoryId,
        method: "POST",
        success: function(response) {
            if (response == 1){
                alert("Deleted successfully");
                location.reload();
            } else {
                alert("Failed to delete: " + response.message);
            }
        },
        error: function() {
            alert("An error occurred while trying to delete the customer.");
        },
    });
}



</script>