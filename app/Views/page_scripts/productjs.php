<script>

$(document).ready(function() {
    $('#productList').DataTable({
        "processing": true,
        "serverSide": false,
        "searching": true,
        "paging": true,
        "ordering": true,
        "info": true,

    });
});

//Add product

var baseUrl = "<?= base_url() ?>";

$('#productSubmit').click(function(e) {
    e.preventDefault(); 
    var url = baseUrl + "product/save"; 

    $.post(url, $('#createProduct').serialize(), function(response) {
          $('html, body').animate({ scrollTop: 0 }, 'fast');
       

        if (response.status == 1) { $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Product created successfully!')
                .show();
            setTimeout(function() {
                window.location.href = baseUrl + "product/"; 
            }, 3000);
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




</script>