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
    e.preventDefault(); // Important to prevent normal form submit
    var url = baseUrl + "subcategory/save"; // Correct route

    $.post(url, $('#createSubcategory').serialize(), function(response) {
       

        if (response.status == 1) { $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Sub category created successfully!')
                .show();

            // Wait, then redirect
            setTimeout(function() {
                window.location.href = baseUrl + "subcategory/"; // Update this path to your Manage Staff page
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
</script>