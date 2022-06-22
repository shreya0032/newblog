$(document).ready(function () {
    var url = window.location.href;
    console.log(url);
    var split = url.split('/');
    var lastseg = split.pop();
    // console.log(lastseg);
    console.log(url);
    // axios.get('http://localhost/ecommerce/public/table/product/getrow')
    axios.get(url + '/getrow')
        .then(function (response) {
            console.log(response.data);
            let data = response.data;
            let dataTableRow = []
            data.map((res) => {
                var tem = {
                    "data": res
                }
                dataTableRow.push(tem)
                //
            })
            var action = {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
            dataTableRow.push(action)
            console.log(dataTableRow);


            $('#example1').DataTable({
                "processing": true,
                "serverSide": true,
                "order": [
                    [0, "asc"]
                ],
                "ajax": url + '/get',
                "language": {
                    "searchPlaceholder": "Search records"
                },
                "columns": dataTableRow,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csv',
                        title: lastseg,
                    }

                ],

            });
        })
        .catch(function (error) {

            console.log(error);
        })


    $('#activity-log').DataTable({

        processing: true,
        stateSave: true,
        serverSide: true,
        pageLength: 10,
        lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
        //pagingType: "input",
        //bLengthChange: false,
        bFilter: true,
        destroy: true,
        "paging": true,
        "bInfo": true,
        "ordering": true,
        "order": [
            [0, "desc"]
        ],
        "search": {
            "caseInsensitive": false,

        },
        "language": {
            "searchPlaceholder": "Search records"
        },
        ajax: {
            'url': "activity-log/getAjax",
            'type': 'GET',
            // 'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'},

        },
        columns: [{
                data: 'table_name'
            },
            {
                data: 'description'
            },
            {
                data: 'role_name'
            },
            {
                data: 'previous_info'
            },
            {
                data: 'present_info'
            },
        ]
    });


    $('#userlist').DataTable({
        processing: true,
        serverSide: true,
        rowReorder: true,
        ajax: {
            'url': 'user-list-ajax',
            'type': 'get'
        },
        language: {
            "searchPlaceholder": "Search records"
        },
        // "order": [
        //     [0, "asc"]
        // ],
        "columns": [
            {
                data: "checkbox",
                orderable: false,
                searchable: false
            },
            {
                data: "name",
            },
            {
                data: "email"
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]

    }).on('draw', function(){
        $('input[name="single_checkboxUser"]').each(function(){
            this.checked = false;
        })
        $('input[name="all_checkboxUser"]').prop('checked', false)
        $('button#deleteAllUser').addClass('d-none')
    });




    $('#rolelist').DataTable({
        processing: true,
        serverSide: true,
        "order": [
            [0, "asc"]
        ],
        ajax: {
            'url': 'role-list-ajax',
            'type': 'get'
        },
        language: {
            "searchPlaceholder": "Search records"
        },
        "columns": [{
                data: "checkbox",
                orderable: false,
                searchable: false
            },
            {
                data: "name",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]

    }).on('draw', function(){
        $('input[name="single_checkbox"]').each(function(){
            this.checked = false;
        })
        $('input[name="all_checkbox"]').prop('checked', false)
        $('button#deleteAll').addClass('d-none')
    });



    $('#permissionList').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            'url': 'permission-list-ajax',
            'type': 'get'
        },
        language: {
            "searchPlaceholder": "Search records"
        },

        "columns": [{
                data: "name",
            },
            // {
            //     data: 'action',
            //     name: 'actions',
            //     orderable: false,
            //     searchable: false
            // }
        ]

    });



    $('#dynamicTableList').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            'url': 'permission-table-list-ajax',
            'type': 'get'
        },
        language: {
            "searchPlaceholder": "Search records"
        },

        "columns": [{
                data: "name",
            },
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ]

    });

})
