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

    function calculateSellingPrice() {
        const mrp = parseFloat(document.getElementById('mRp').value) || 0;
        const discountType = document.getElementById('discountType').value;
        const discountValue = parseFloat(document.getElementById('discountValue').value) || 0;

        let sellingPrice = mrp;

        if (discountType === '%') {
            sellingPrice = mrp - (mrp * discountValue / 100);
        } else if (discountType === 'Rs') {
            sellingPrice = mrp - discountValue;
        }

        
        if (sellingPrice < 0) sellingPrice = 0;

        
        document.getElementById('sellingPrice').value = sellingPrice.toFixed(2);
    }

   document.getElementById('mRp').addEventListener('input', calculateSellingPrice);
    document.getElementById('discountType').addEventListener('change', calculateSellingPrice);
    document.getElementById('discountValue').addEventListener('input', calculateSellingPrice);





</script>