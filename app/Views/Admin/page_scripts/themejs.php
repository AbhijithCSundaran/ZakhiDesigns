<script>

//////////////////////////////////////////data tables//////////////////////
var baseUrl = "<?= base_url() ?>";
$('#productsLists').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "<?= base_url('admin/themes/List') ?>",
        type: "POST",
        data: function (d) {
            d['<?= csrf_token() ?>'] = "<?= csrf_hash() ?>";
        }
    },
		columns: [
		{ data: 'DT_RowIndex', orderable: false, searchable: false },
		{ data: 'theme_Name' },
		{ data: 'theme_Description' },
		{ data: 'status_switch' },
		{ data: 'actions' }
	],

    columnDefs: [
        { targets: [3,4], orderable: false, searchable: false },
        { targets: 2, render: function (data, type, row) {
            return data; // Render raw HTML for image thumbnail
        }}
    ]
});
///////////////////////////////////////////////////////////////////////////

/*********************************/

function confirmDelete(theId) {
	console.log("Deleting ID:", theId);
    Swal.fire({
        title: 'Are you sure?',
        text: 'You want to delete this theme?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
    }).then((result) => {
        if (result.isConfirmed) {
            // AJAX call to delete
            $.ajax({
                url: "<?php echo base_url('admin/themes/delete'); ?>/" + theId,
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
/*************************************/
//Active and Inactive status

var baseUrl = "<?= base_url() ?>";
$(document).on('change', '.checkactive', function () {
    let themeId = $(this).attr('id').split('-')[1]; // Extract ID from id="statusSwitch-123"
    let status = $(this).is(':checked') ? 1 : 2;

    $.ajax({
        url: baseUrl + 'admin/themes/status',
        type: 'POST',
        data: {
            theme_Id: themeId,
            theme_Status: status
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Or use `<?= csrf_hash(); ?>` if inline
        },
        success: function (response) {
            const messageBox = $('#messageBox');

            if (response.success) {
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
        error: function (xhr) {
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



/************************************************/


$(document).on('click', '.add-row', function () {
    const section = $(this).closest('.section');
    const lastRow = section.find('.row:last');
    const newRow = lastRow.clone();
    
    // Reset input values
    newRow.find('input, textarea').val('');
    newRow.find('img.preview').remove();

    section.append(newRow);
});

// Event delegation for image preview
$(document).on('change', 'input[type="file"]', function () {
    previewImage(this);
});

// Add new entry
function addEntry(sectionId) {
    const section = document.getElementById(sectionId);
    const container = section.querySelector(`#${sectionId}-entries`);
    const firstEntry = container.querySelector('.entry');

    if (firstEntry) {
        const newEntry = firstEntry.cloneNode(true);

        // Reset inputs, but preserve old-image hidden fields
        newEntry.querySelectorAll('input').forEach(input => {
            if (input.type === 'file') {
                input.value = ''; // clear file input
            } else if (input.classList.contains('old-image')) {
                // Don't change old-image field — keep it as is
            } else {
                input.value = ''; // clear text inputs
            }
        });

        // Reset preview image
        const img = newEntry.querySelector('img.preview');
        if (img) {
            img.style.display = 'none';
            img.src = '';
        }

        container.appendChild(newEntry);
    }
}

// Remove entry
function removeEntry(sectionId) {
    const container = document.querySelector(`#${sectionId}-entries`);
    const entries = container.querySelectorAll('.entry');

    if (entries.length > 1) {
        container.removeChild(entries[entries.length - 1]);
    } else {
        alert('At least one entry must remain.');
    }
}

// Collect JSON data from all sections
function collectSectionData() {
    const collectEntries = (sectionId) => {
        let entries = [];
        $(`#${sectionId} .entry`).each(function () {
            let entry = {};
            let fileInput = $(this).find('input[type="file"]')[0];
            let oldImage = $(this).find('input.old-image').val() || '';

            // Collect text fields
            $(this).find('input[type="text"]').each(function () {
                let key = $(this).attr('placeholder')?.trim().replace(/\s+/g, '_').toLowerCase() || 'text';
                entry[key] = $(this).val();
            });

            // Handle image name
            entry.image = fileInput && fileInput.files.length > 0 ? fileInput.files[0].name : oldImage;

            entries.push(entry);
        });
        return entries;
    };

    return {
        theme_Section1: JSON.stringify(collectEntries('section1')),
        theme_Section2: JSON.stringify(collectEntries('section2')),
        theme_Section3: JSON.stringify(collectEntries('section3')),
    };
}

// Handle form submission
$('#main_home_submit').on('click', function (e) {
    e.preventDefault();
    $('#main_home_submit').prop('disabled', true);

    let form = $('#theme_add')[0];
    let formData = new FormData(form);
    let sectionData = collectSectionData();

    // Set updated JSON data
    formData.set('theme_Section1', sectionData.theme_Section1);
    formData.set('theme_Section2', sectionData.theme_Section2);
    formData.set('theme_Section3', sectionData.theme_Section3);

    $.ajax({
        url: "<?= base_url('admin/themes/save_file') ?>",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
		
        success: function (response) {
            if (response.status == 1) {
                $('#messageBox')
                    .removeClass('alert-danger')
                    .addClass('alert-success')
                    .text(response.msg)
                    .show();

                setTimeout(function () {
                    $('#main_home_submit').prop('disabled', false);
                    window.location.href = baseUrl + "admin/themes";
                }, 3000);
            } else {
                $('#messageBox')
                    .removeClass('alert-success')
                    .addClass('alert-danger')
                    .text(response.msg)
                    .show();
                $('#main_home_submit').prop('disabled', false);
            }

            setTimeout(function () {
                $('#messageBox').hide();
            }, 3000);
        },
		
		error: function (xhr, status, error) {
    
    $('#messageBox')
        .removeClass('alert-success')
        .addClass('alert-danger')
        .text('Server error. Please try again.')
        .show();
    $('#main_home_submit').prop('disabled', false);
}
    });
});
</script>
