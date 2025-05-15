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

$(document).ready(function() {
    var selectedCatId = "<?= $product['cat_Id'] ?? '' ?>";
    var selectedSubId = "<?= $product['sub_Id'] ?? '' ?>";

    // Function to load subcategories based on category ID
    function loadSubcategories(catId, preselectSubId = '') {
        var subSelect = $('#subcategoryName');
        var messageElement = $('#noSubcategoryMsg');
        subSelect.empty();

        if (!catId) {
            subSelect.append('<option value="">-- Select Subcategory --</option>');
            return;
        }

        $.ajax({
            url: baseUrl + "product/get-subcategories",
            type: "POST",
            data: {
                cat_id: catId
            },
            dataType: "json",
            success: function(response) {
                if (response.length === 0) {
                    subSelect.append('<option value="">-- No Subcategory Available --</option>');
                    if (messageElement) messageElement.show();
                } else {
                    subSelect.append('<option value="">-- Select Subcategory --</option>');

                    $.each(response, function(index, sub) {
                        let selected = (sub.sub_Id == preselectSubId) ? 'selected' : '';
                        subSelect.append('<option value="' + sub.sub_Id + '" ' + selected +
                            '>' + sub.sub_Category_Name + '</option>');
                    });

                    if (messageElement) messageElement.hide();
                }
            },
            error: function(xhr) {
                console.error("Error fetching subcategories:", xhr.responseText);
            }
        });
    }

    // Prepopulate (on edit)
    if (selectedCatId) {
        $('#categoryName').val(selectedCatId);
        loadSubcategories(selectedCatId, selectedSubId);
    }

    // Handle category change (on add)
    $('#categoryName').on('change', function() {
        var catId = $(this).val();
        loadSubcategories(catId);
    });
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
$(document).ready(function() {
    $('#exampleModal').on('hidden.bs.modal', function() {
        $('body').removeClass('modal-open');
        $('body').css('overflow', 'auto');
        $('.modal-backdrop').remove();
    });
});
//modal does' not close properly
$(document).ready(function() {
    $('#videoModal').on('hidden.bs.modal', function() {
        $('#videoPreview').empty();
        $('body').removeClass('modal-open');
        $('body').css('overflow', 'auto');
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
                    delIcon.style.top = '-21px';
                    delIcon.style.right = '-8px';
                    delIcon.style.cursor = 'pointer';
                    delIcon.style.color = 'red';
                    delIcon.style.fontSize = '24px';
                    delIcon.title = 'Delete this image';

                    // Delete click event
                    delIcon.onclick = function() {
                        if (confirm('Are you sure you want to delete this image?')) {
                            fetch(`<?= base_url('product/delete-product-image') ?>`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-Requested-With': 'XMLHttpRequest'
                                    },
                                    body: JSON.stringify({
                                        product_id: productId,
                                        image: imgName
                                    })
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

function openvideoModal(productVideoId, productsName) {
    document.getElementById('productVideoId').value = productVideoId;
    document.getElementById('productsName').textContent = productsName;
    $('#videoModal').modal('show');
}



// vide AJAX Upload
$('#filevideo').on('change', function() {
    var file = this.files[0];

    if (file) {
        var maxSizeMB = 4;
        var allowedTypes = ['video/mp4', 'video/avi', 'video/mpeg', 'video/quicktime', 'video/x-matroska'];

        if (file.size > maxSizeMB * 1024 * 1024) {
            alert('Your video size is too large. Please upload a video within 4MB.');
            this.value = '';
            return;
        }

        if (!allowedTypes.includes(file.type)) {
            alert('Only video files are allowed. Please upload a valid video format.');
            this.value = ''; 
            return;
        }
    }

    // Proceed to upload via AJAX
    var formData = new FormData($('#videoUploadForm')[0]);

    $.ajax({
        url: '<?= base_url('product/video') ?>',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            if (response.status === 'success') {
                alert(response.message);
                const productId = $('#productVideoId').val();
                loadProductVideo(productId);
            } else {
                alert(response.message);
            }
        },
        error: function(xhr) {
            alert('Upload failed: ' + (xhr.responseJSON?.message || 'Unknown error'));
        }
    });
});



//Load video on modal

function openvideoModal(productId, productName) {
    $('#productVideoId').val(productId);
    $('#productsName').text(productName);
    $('#videoPreview').empty(); // Clear previous video

    $.ajax({
        url: '<?= base_url('product/getVideo') ?>',
        method: 'POST',
        data: {
            product_id: productId
        },
        success: function(response) {
            if (response.status === 'success' && response.video) {
                const videoUrl = '<?= base_url('uploads/productmedia/') ?>' + response.video;
                const videoElement = `
                    <div class="position-relative video-file d-inline-block">
                        <video width="300" height="200" controls>
                            <source src="${videoUrl}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        <span 
                            class="delete-video-btn" 
                            data-product-id="${productId}" 
                            data-video-name="${response.video}" 
                            title="Delete this video"
                            style="position: absolute; top: -10px; right: -13px; cursor: pointer; color: red; font-size: 30px;">
                            ×
                        </span>
                    </div>
                `;
                $('#videoPreview').append(videoElement).show();
                $('#drop-area').hide();
            } else {
                $('#videoPreview').hide();
                $('#drop-area').show();
            }

            $('#videoModal').modal('show');
        },
        error: function() {
            // Fallback
            $('#videoPreview').hide();
            $('#drop-area').show();
            $('#videoModal').modal('show');
        }
    });
}




//Delete video single video

$(document).on('click', '.delete-video-btn', function(e) {
    e.preventDefault();

    if (!confirm("Are you sure you want to delete this video?")) return;

    const productId = $(this).data('product-id');
    const videoName = $(this).data('video-name');

    $.ajax({
        url: '<?= base_url('product/deletevideo') ?>',
        type: 'POST',
        data: {
            product_id: productId,
            video_name: videoName
        },
        success: function(response) {
            if (response.status === 'success') {
                $(e.target).closest('.video-file').remove();
            } else {
                alert('Failed to delete video');
            }
        },
        error: function() {
            alert('Error while deleting the video');
        }
    });
});


//Active Inactive status Change
$(document).ready(function() {
    $('.checkactive').on('change', function() {
        let prId = $(this).val();
        let status = $(this).prop('checked') ? 1 : 2;
        $.ajax({
            url: '<?= base_url('product/status'); ?>',
            type: 'POST',
            data: {
                pr_Id: prId,
                pr_Status: status
            },
            headers: {
                'X-CSRF-TOKEN': '<?= csrf_hash(); ?>'
            },
            success: function(response) {
                const messageBox = $('#messageBox');
                $('html, body').animate({
                    scrollTop: 0
                }, 'fast');

                if (response.message === 'Product Status Updated Successfully!') {
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