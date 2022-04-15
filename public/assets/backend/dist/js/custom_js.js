$('document').ready(function () {
    // $('.testmsg').click(function(){
    //     // event.preventDefault();
    //     console.log('testmsg');
    //     // href
    // })

    // function testDeleteFunction(){
    //     console.log('testmsg');
    // }

    $('#createUserForm').on('submit', function (event) {
        event.preventDefault();
        submitForm = $(this);
        submitBtn = $(this).find('#submitUserForm');

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // submitBtn.attr("disabled", "disabled")
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#createUserForm')[0].reset();
                    alert(data.msg);
                }
            }

        })

        // Swal.fire({
        //     title: 'Are you sure?',
        //     text: "You won't be able to revert this!",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, delete it!'
        //   }).then((result) => {
        //     if (result.isConfirmed) {
        //       // Swal.fire(
        //       //   'Deleted!',
        //       //   'Your file has been deleted.',
        //       //   'success'
        //       // )
        //     }
        //   })


    })

    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye-slash fa-eye");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $('#updateUserForm').on('submit', function (event) {
        event.preventDefault();
        submitForm = $(this);
        submitBtn = $(this).find('#submitUpdateForm');
        // reloadDatatable = $('#userlist').DataTable();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // submitBtn.attr("disabled", "disabled")
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#updateUserForm')[0].reset();
                    alert(data.msg);
                    // reloadDatatable.ajax.reload(null, false);
                }
            }

        })

        // Swal.fire({
        //     title: 'Are you sure?',
        //     text: "You won't be able to revert this!",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'Yes, delete it!'
        //   }).then((result) => {
        //     if (result.isConfirmed) {
        //       // Swal.fire(
        //       //   'Deleted!',
        //       //   'Your file has been deleted.',
        //       //   'success'
        //       // )
        //     }
        //   })


    })

    $('body').delegate('#userlist .deleteuser', 'click', function () {
        var type = $(this).attr('data-type'),
            id = $(this).attr('data-id'),
            action = $(this).attr('data-action'),
            // reloadDatatable = $('#userlist').DataTable();
        if (type == 'delete') {
            res = confirm('Do you really want to delete?');
            if (res === false) {
                return;
            } 
                $.ajax({
                    url: action,
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function () {
                        loader(1);
                    },
                    success: function (msg) {
                        loader(0);
                        if (msg.status == 0) {
                            toaster(msg.title, msg.msg, msg.type);
                        } else {
                            toaster(msg.title, msg.msg, msg.type);
                            reloadDatatable.ajax.reload(null, false);
                        }
                        setTimeout(function () {
                            $("#alert").css('display', 'none');
                        }, 5000);
                    }
                });

        } else {

        }
    });



    $('#roleForm').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#roleSubmitBtn');
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // submitBtn.attr("disabled", "disabled")
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#roleForm')[0].reset();
                    alert(data.msg);
                    // reloadDatatable.ajax.reload(null, false);
                }
            }

        })


    })

    // window.location = "//www.aspsnippets.com/";
    $('#updateRoleForm').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#updateRoleBtn');
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // submitBtn.attr("disabled", "disabled")
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#updateRoleForm')[0].reset();
                    alert(data.msg);
                }
            }

        })
    })

    $('#permissionForm').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#submitPermissionBtn');
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // submitBtn.attr("disabled", "disabled")
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#permissionForm')[0].reset();
                    alert(data.msg);
                }
            }

        })


    })

    $('#updateManagePermission').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#updateManagePermissionBtn');
        // reloadDatatable = $('#updateManagePermission').DataTable();

        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // submitBtn.attr("disabled", "disabled")
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#updateManagePermission')[0].reset();
                    alert(data.msg);
                    // reloadDatatable.ajax.reload(null, false);
                  
                }
            }

        })
    })

    $("#close").click(function () {

        var type = $(this).attr('data-type')
        var id = $(this).attr('data-id')
        var action = $(this).attr('data-action')
            // reloadDatatable = $('#userlist').DataTable();
            console.log('ok test')
        $(this).toggleClass("fa-eye-slash fa-eye");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $('#register').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#submitRegister');
        event.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: new FormData(this),
            cache: false,
            processData: false,
            contentType: false,
            beforeSend: function () {
                // submitBtn.attr("disabled", "disabled")
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#userForm')[0].reset();
                    alert(data.msg);
                }
            }

        })


    })

    $('.deleteuser').click(function (e) {
        // var userDetails = $(this).data
        // console.log(userDetails);

        e.preventDefault();
        alert('hello')
    })
});
