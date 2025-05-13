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
        $('html, body').animate({
            scrollTop: 0
        }, 'fast');


        if (response.status == 1) {
            $('#messageBox')
                .removeClass('alert-danger')
                .addClass('alert-success')
                .text(response.msg || 'Product created successfully!')
                .show();
            setTimeout(function() {
                window.location.href = baseUrl + "product/";
            }, 3000);
        } else {
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


$('#categoryName').on('change', function() {
    var categoryId = $(this).val();
    var subSelect = $('#subcategoryName');
    var messageElement = $('#noSubcategoryMsg');

    subSelect.empty(); // Clear old options

    if (categoryId) {
        $.ajax({
            url: baseUrl + "product/get-subcategories", // Make sure this route exists and works
            type: "POST",
            data: {
                cat_id: categoryId
            },
            dataType: "json",
            success: function(response) {
                if (response.length === 0) {
                    subSelect.append('<option value="">-- No Subcategory Available --</option>');
                    messageElement.show(); // Show the message
                } else {
                    subSelect.append('<option value="">-- Select Subcategory --</option>');
                    $.each(response, function(index, sub) {
                        subSelect.append('<option value="' + sub.sub_Id + '">' + sub
                            .sub_Category_Name + '</option>');
                    });
                    messageElement.hide(); // Hide the message
                }
            },
            error: function(xhr) {
                console.error("Error fetching subcategories:", xhr.responseText);
            }
        });
    } else {
        subSelect.append('<option value="">-- Select Subcategory --</option>');
        messageElement.hide();
    }
});

$(document).ready(function () {
    $('.open-image-modal').on('click', function () {
        var productName = $(this).data('product-name');
        var productId = $(this).data('product-id');
        $('#productName').text(productName);          
        $('#productId').val(productId);                     
    });
});

  function handleFiles(files) {
        const formData = new FormData();
        const productId = document.getElementById('productId').value;

        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        
        formData.append('product_id', productId);

        fetch("<?= base_url('product/upload-media') ?>", {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.status == 1) {
                alert(data.msg || 'Images uploaded successfully!');
            
            } else {
                alert(data.msg || 'Upload failed.');
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            alert('Something went wrong. Try again later.');
        });
    }

    function handleDrop(event) {
        event.preventDefault();
        handleFiles(event.dataTransfer.files);
    }

    // File input change listener
    document.getElementById('fileElem').addEventListener('change', function () {
        handleFiles(this.files);
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