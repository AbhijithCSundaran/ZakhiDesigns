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


//Category and Subactegory listed the dropdown

$('#categoryName').on('change', function() {
    var categoryId = $(this).val();
    var subSelect = $('#subcategoryName');
    var messageElement = $('#noSubcategoryMsg');

    subSelect.empty(); 

    if (categoryId) {
        $.ajax({
            url: baseUrl + "product/get-subcategories", 
            type: "POST",
            data: {
                cat_id: categoryId
            },
            dataType: "json",
            success: function(response) {
                if (response.length === 0) {
                    subSelect.append('<option value="">-- No Subcategory Available --</option>');
                    messageElement.show(); 
                } else {
                    subSelect.append('<option value="">-- Select Subcategory --</option>');
                    $.each(response, function(index, sub) {
                        subSelect.append('<option value="' + sub.sub_Id + '">' + sub
                            .sub_Category_Name + '</option>');
                    });
                    messageElement.hide(); 
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


//File Upload

function handleFiles(files) {
    const allowedTypes = ['image/jpeg', 'image/png'];
    const formData = new FormData();
    const productId = document.getElementById('productId').value;

    for (let i = 0; i < files.length; i++) {
        const file = files[i];

        if (!allowedTypes.includes(file.type)) {
            alert(`File "${file.name}" is not allowed. Only JPEG and PNG formats are accepted.`);
            return; // Stop processing if one file is invalid
        }

        formData.append('files[]', file);
    }

    formData.append('product_id', productId);

    fetch("<?= base_url('product/upload-media') ?>", {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success === true) {
                alert(data.msg || 'Images uploaded successfully!');
                loadProductImages(productId);
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



//Open the modal
function openProductModal(productId, productName) {
    document.getElementById('productId').value = productId;
    document.getElementById('productName').textContent = productName;
    loadProductImages(productId);
    $('#exampleModal').modal('show');
}

//modal does' not close properly
$(document).ready(function () {
    $('#exampleModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });
});


//Image listed the Modal
function loadProductImages(productId) {
    fetch(`<?= base_url('product/get-product-images') ?>/${productId}`)
        .then(response => response.json())
        .then(data => {
            const imageContainer = document.getElementById('imagePreview');
            imageContainer.innerHTML = '';

            if (data && Array.isArray(data)) {
                data.forEach(imgName => {
                    const wrapper = document.createElement('div');
                    wrapper.style.position = 'relative';
                    wrapper.style.display = 'inline-block';
                    wrapper.style.margin = '5px';

                    const img = document.createElement('img');
                    img.src = `<?= base_url('uploads/productmedia/') ?>/${imgName}`;
                    img.alt = "Product Image";
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.classList.add('rounded', 'border');

                    // Create delete icon
                    const delIcon = document.createElement('span');
                    delIcon.innerHTML = '&times;';
                    delIcon.style.position = 'absolute';
                    delIcon.style.top = '5px';
                    delIcon.style.right = '10px';
                    delIcon.style.cursor = 'pointer';
                    delIcon.style.color = 'red';
                    delIcon.style.fontSize = '24px';
                    delIcon.title = 'Delete this image';

                    // Delete click event
                    delIcon.onclick = function () {
                        if (confirm('Are you sure you want to delete this image?')) {
                            fetch(`<?= base_url('product/delete-product-image') ?>`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({ product_id: productId, image: imgName })
                            })
                            .then(res => res.json())
                            .then(result => {
                                if (result.success) {
                                    wrapper.remove(); // Remove image from DOM
                                } else {
                                    alert('Failed to delete image.');
                                }
                            })
                            .catch(err => {
                                console.error('Delete error:', err);
                                alert('Error deleting image.');
                            });
                        }
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(delIcon);
                    imageContainer.appendChild(wrapper);
                });
            } else {
                imageContainer.innerHTML = '<p class="text-muted">No images found.</p>';
            }
        })
        .catch(err => {
            console.error('Image load error:', err);
            document.getElementById('imagePreview').innerHTML = '<p class="text-danger">Failed to load images.</p>';
        });
}


//Delete whole Product
function confirmDelete(prId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this Product?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?php echo base_url('product/delete'); ?>/" + prId,
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

//Calculate the selling price depends on the discount value
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

document.getElementById('mRp')?.addEventListener('input', calculateSellingPrice);
document.getElementById('discountType')?.addEventListener('change', calculateSellingPrice);
document.getElementById('discountValue')?.addEventListener('input', calculateSellingPrice);
</script>