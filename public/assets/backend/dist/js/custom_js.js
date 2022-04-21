$('document').ready(function () {
    

    $('#createUserForm').on('submit', function (event) {
        event.preventDefault();
        submitForm = $(this);
        submitBtn = $(this).find('#submitUserForm');
        submitBtnLoader = $(this).find('#loaderSubmitUserForm');
        // submitBtn.hide();
        // submitBtnLoader.show();

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
                // submitBtnLoader.show();
                // $(document).find('span.error-text').text('');
                submitBtn.attr("disabled", "disabled").text('Please wait...');
            },
            success: function (data) {
                submitBtn.attr("disabled", false).text('Submit');
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#createUserForm')[0].reset();
                    alert(data.msg);
                    window.location.href = "index";
                    // setTimeout(function () {
                    //     window.location.href = "{{route('user.index')}}";
                    //   }, 2 * 1000);
                }
            }

        })
    })

    // $('#createUserForm').on('submit', function (event) {
    //     event.preventDefault();
    //     submitForm = $(this);
    //     submitBtn = $(this).find('#submitUserForm');

    //     $.ajax({
    //         url: $(this).attr('action'),
    //         type: $(this).attr('method'),
    //         dataType: 'json',
    //         data: new FormData(this),
    //         cache: false,
    //         processData: false,
    //         contentType: false,
    //         beforeSend: function () {
    //             // submitBtn.attr("disabled", "disabled")
    //             $(document).find('span.error-text').text('');
    //         },
    //         success: function (data) {
    //             if (data.status == 0) {
    //                 // console.log('not ok');
    //                 $.each(data.error, function (prefix, val) {
    //                     $('span.' + prefix + '_error').text(val[0])
    //                 })
    //             } else {
    //                 $('#createUserForm')[0].reset();
    //                 alert(data.msg);
    //                 window.location.href = "index";
    //                 // setTimeout(function () {
    //                 //     window.location.href = "{{route('user.index')}}";
    //                 //   }, 2 * 1000);
    //             }
    //         }

    //     })
    // })

    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye-slash fa-eye");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
            $(this).css("cursor","pointer");
        } else {
            input.attr("type", "password");
            $(this).css("cursor","default");
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
                submitBtn.attr("disabled", "disabled").text('Please wait..')
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                submitBtn.attr("disabled", false).text('Update');
                if (data.status == 0) {
                    console.log(data.error);
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    // $('#updateUserForm')[0].reset();
                    $('#updateUserForm')[0].reset();

                    alert(data.msg);
                    window.location.reload();
                    // reloadDatatable.ajax.reload(null, false);
                }
            }

        })


    })

    $('body').delegate('#userlist .deleteuser', 'click', function () {
        var type = $(this).attr('data-type')
        var id = $(this).attr('data-id')
        var action = $(this).attr('data-action')
        var reloadDatatable = $('#userlist').DataTable();
        if (type == 'delete') {
            // res = confirm('Do you really want to delete?');
            // if (res === false) {
            //     return;
            // } 

            // console.log(action);
            // console.log('true');
            // window.location.replace(action);


            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              //  window.location.replace(action);

              $.ajax({
                    url: action,
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function () {
                        // loader(1);
                    },
                    success: function (msg) {
                        // loader(0);
                        if (msg.status == 0) {
                            // toaster(msg.title, msg.msg, msg.type);
                        } else {
                            // toaster(msg.title, msg.msg, msg.type);
                            reloadDatatable.ajax.reload(null, false);
                        }
                        setTimeout(function () {
                            $("#alert").css('display', 'none');
                        }, 5000);
                    }
                });

            }
          })

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
                // $(document).find('span.error-text').text('');
                submitBtn.attr("disabled", "disabled").text('Please wait...');
            },
            success: function (data) {
                submitBtn.attr("disabled", false).text('Submit');
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#roleForm')[0].reset();
                    alert(data.msg);
                    window.location.href = "index";
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
                submitBtn.attr("disabled", "disabled").text('Please wait..')
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                submitBtn.attr("disabled", false).text('Update');
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#updateRoleForm')[0].reset();
                    alert(data.msg);
                    window.location.reload();
                }
            }

        })
    })

    $('body').delegate('#rolelist .deleterole', 'click', function () {
        var type = $(this).attr('data-type')
        var id = $(this).attr('data-id')
        var action = $(this).attr('data-action')
        var reloadDatatable = $('#rolelist').DataTable();
        if (type == 'delete') {
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              //  window.location.replace(action);

              $.ajax({
                    url: action,
                    type: 'get',
                    dataType: 'json',
                    beforeSend: function () {
                        // loader(1);
                    },
                    success: function (msg) {
                        // loader(0);
                        if (msg.status == 0) {
                            // toaster(msg.title, msg.msg, msg.type);
                        } else {
                            // toaster(msg.title, msg.msg, msg.type);
                            reloadDatatable.ajax.reload(null, false);
                        }
                        setTimeout(function () {
                            $("#alert").css('display', 'none');
                        }, 5000);
                    }
                });

            }
          })

        } else {

        }
    });


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
                submitBtn.attr("disabled", "disabled").text('Please wait..');
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                submitBtn.attr("disabled", false).text('Submit');
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#permissionForm')[0].reset();
                    alert(data.msg);
                    window.location.href = "index";
                }
            }

        })


    })

    $('#updatePermission').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#updatePermissionBtn');
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
                submitBtn.attr("disabled", "disabled").text('Please wait..')
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                submitBtn.attr("disabled", false).text('Update');
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#updatePermission')[0].reset();
                    alert(data.msg);
                    window.location.reload();
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
                submitBtn.attr("disabled", "disabled").text('Please wait..');
                $(document).find('span.error-text').text('');
            },
            success: function (data) {
                submitBtn.attr("disabled", false).text('Assign');
                if (data.status == 0) {
                    // console.log('not ok');
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#updateManagePermission')[0].reset();
                    alert(data.msg);
                    window.location.reload();
                    // reloadDatatable.ajax.reload(null, false);
                  
                }
            }

        })
    });

    $('.deletePermission').on('click', function(event){
        // console.log('ok');
            event.preventDefault();
            var action = $(this).data('href');
            // console.log($(this).data('href'));

            
    
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.isConfirmed) {
                  //  window.location.replace(action);
    
                  $.ajax({
                        url: action,
                        type: 'get',
                        dataType: 'json',
                        beforeSend: function () {
                            // loader(1);
                        },
                        success: function (msg) {
                            // loader(0);
                            if (msg.status == 0) {
                                // toaster(msg.title, msg.msg, msg.type);
                            } else {
                                window.location.reload();
                            }
                        }
                    });
    
                }
              })
    })

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

});
