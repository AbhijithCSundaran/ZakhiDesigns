<!-- Add a custom search input bar -->
<div style="margin-bottom: 10px;">
    <input type="text" id="customSearchBox" placeholder="Search Orders..." class="form-control" style="width: 300px;" />
</div>

<script>
var baseUrl = "<?= base_url() ?>";
var csrfTokenName = "<?= csrf_token() ?>";
var csrfHash = "<?= csrf_hash() ?>";

var table = $('#orderList').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
    ajax: {
        url: baseUrl + "admin/orders/List",  
        type: "POST",
        data: function(d) {
            d[csrfTokenName] = csrfHash;
        }
    },
    columns: [
        {
            data: null,
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            },
            orderable: false,
            searchable: false
        },
        { data: 'cust_Name' },
        { data: 'cust_Email' },
        { data: 'cust_Phone' },
        { data: 'pr_Code' },
        { data: 'od_Quantity' },
        { data: 'od_createdon' },
        { data: 'od_Status' }, 
        { data: 'actions' }
    ]
});

// Bind custom search box
$('#customSearchBox').on('keyup', function () {
    table.search(this.value).draw();
});
</script>
