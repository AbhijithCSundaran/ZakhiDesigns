
<script>

$(document).ready(function() {
    $('#staffList').DataTable({
        "processing": true,
        "serverSide": false,
        "searching": true,
        "paging": true,
        "ordering": true,
        "info": true,

    });
});

var baseUrl = "<?= base_url() ?>";

$('#staffSubmit').click(function(e) {
    e.preventDefault(); // Important to prevent normal form submit
    var url = baseUrl + "staff/save"; // Correct route

    $.post(url, $('#createstaff').serialize(), function(data) {
        $('#createstaff')[0].reset();

        if (data.status == 1) {
            alert('Data stored successfully!');
        } else {
            alert('Failed to store data: ' + data.message);
        }
    }, 'json');
});
</script>