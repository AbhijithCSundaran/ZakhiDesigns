<script>
    var baseUrl = "<?= base_url() ?>";
    var csrfTokenName = "<?= csrf_token() ?>";
    var csrfHash = "<?= csrf_hash() ?>";

    var table = $('#orderList').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        order: [[6, 'desc']],
        ajax: {
            url: baseUrl + "admin/orders/List",
            type: "POST",
            data: function (d) {
                d[csrfTokenName] = csrfHash;
            }
        },
        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                },
                orderable: false,
                searchable: false
            },
            {
                data: 'cust_Name',
                render: function (data, type, row) {
                    if (!data) return 'N/A';
                    return data.length > 25
                        ? '<span title="' + data + '">' + data.substring(0, 25) + '...</span>'
                        : data;
                }
            },
            { data: 'add_Email' },
            { data: 'add_Phone' },
            { data: 'pr_Code' },
            { data: 'od_Quantity' },
            { data: 'od_createdon' },
            { data: 'od_Status' },
            {
                data: 'actions',
                orderable: false,
                searchable: false
            }
        ]
    });

</script>