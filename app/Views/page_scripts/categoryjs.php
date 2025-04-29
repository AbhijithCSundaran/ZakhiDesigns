<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
var baseUrl = "<?= base_url() ?>";

$('#categorySubmit').click(function(e) {
    e.preventDefault(); // Important to prevent normal form submit
    var url = baseUrl + "category/save"; // Correct route

    $.post(url, $('#createCategory').serialize(), function(data) {
        $('#createCategory')[0].reset();

        if (data.status === 'success') {
            alert('Data stored successfully!');
        } else {
            alert('Failed to store data: ' + data.message);
        }
    }, 'json');
});
</script>