<script>
var baseUrl = "<?= base_url() ?>";
var csrfTokenName = "<?= csrf_token() ?>";
var csrfHash = "<?= csrf_hash() ?>";

var table = $('#orderList').DataTable({
    processing: true,
    serverSide: true,
    scrollX: true,
   // paging: true,
   // pageLength: 10, 
   // lengthMenu: [10, 25, 50, 100], 
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
    {
        data: 'cust_Name',
        render: function(data, type, row) {
            if (!data) return 'N/A';
            return data.length > 25
                ? '<span title="' + data + '">' + data.substring(0, 25) + '...</span>'
                : data;
        }
    },
    { data: 'cust_Email' },
    {
    data: 'cust_Phone',
    render: function (data, type, row) {
        return data && data.trim() !== '' ? data : 'N/A';
    }
},

    { data: 'pr_Code' },
    { data: 'od_Quantity' },
    { data: 'od_createdon' },
    { data: 'od_Status' }, 
    { data: 'actions' }
]
});
// table.on('draw', function () {
//     console.log('Table redrawn');
// });
// Bind custom search box
// $('#customSearchBox').on('keyup', function () {
//     table.search(this.value).draw();
// });
</script>