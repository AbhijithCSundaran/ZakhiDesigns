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

    $.post(url, $('#createCategory').serialize(), function(data) {
        $('#createCategory')[0].reset();

        if (data.status === 'success') {
            alert('Data stored successfully!');
        } else {
            alert('Failed to store data: ' + data.message);
        }
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