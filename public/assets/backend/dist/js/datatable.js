$(document).ready(function () {
            var url = window.location.href;
            var split = url.split('/');
            var lastseg = split.pop();
            // console.log(lastseg);
            // console.log(url);
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
                        "ajax": url + '/get',
                        "language": {
                            "searchPlaceholder": "None"
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
                    "caseInsensitive": false
                },
                ajax: {
                    'url': "activity-log/getAjax",
                    'type': 'GET',
                    // 'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'},

                },
                columns: [{
                        data: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
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
                    ajax: {
                        'url':'user-list-ajax',
                        'type': 'get'
                    },
                    language: {
                        "searchPlaceholder": "None"
                    },

                    "columns": [
                        {
                            data: "DT_RowIndex",
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

                    });




            $('#rolelist').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        'url':'role-list-ajax',
                        'type': 'get'
                    },
                    language: {
                        "searchPlaceholder": "None"
                    },

                    "columns": [
                        {
                            data: "DT_RowIndex",
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

                    });



            $('#permissionList').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        'url':'permission-list-ajax',
                        'type': 'get'
                    },
                    language: {
                        "searchPlaceholder": "None"
                    },

                    "columns": [
                        {
                            data: "DT_RowIndex",
                            orderable: false,
                            searchable: false
                        }, 
                        {
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
                        'url':'permission-table-list-ajax',
                        'type': 'get'
                    },
                    language: {
                        "searchPlaceholder": "None"
                    },

                    "columns": [
                        {
                            data: "DT_RowIndex",
                            orderable: false,
                            searchable: false
                        }, 
                        {
                            data: "name",
                        }
                    ]

                    });



                    function testDeleteFunction(){
                        console.log('testmsg');
                    }



            })
