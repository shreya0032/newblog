$('document').ready(function () {

    $('#createUserForm').on('submit', function (event) {
        event.preventDefault();
        submitForm = $(this);
        submitBtn = $(this).find('#submitUserForm');
        var url=$(this).data('redirecturl');
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
                submitBtn.attr("disabled", false).text('Submit');
                if (data.status == 0) {
                   
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#createUserForm')[0].reset();

                    $.toast({
                        text:data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack:3,
                        position: 'top-right'
                    })
                    window.setTimeout(function() {
                        window.location.href = url;
                    }, 2000);
                }
            }

        })


    })

    $(document).on('click', 'input[name="all_checkboxUser"]', function (e) {
        if (this.checked) {
            $('input[name="single_checkboxUser"]').each(function () {
                this.checked = true;
            })
        } else {
            $('input[name="single_checkboxUser"]').each(function () {
                this.checked = false;
            })
        }
        toggleBtnUser()
    })

    $(document).on('click', 'input[name="single_checkboxUser"]', function (e) {
        if ($('input[name="single_checkboxUser"]').length == $('input[name="single_checkboxUser"]:checked').length) {
            $('input[name="all_checkboxUser"]').prop('checked', true);
        } else {
            $('input[name="all_checkboxUser"]').prop('checked', false);
        }
        toggleBtnUser()
    })

    function toggleBtnUser() {
        if ($('input[name="single_checkboxUser"]').length > 0) {
            $('button#deleteAllUser').text('Delete').removeClass('d-none')
        } else {
            $('button#deleteAllUser').addClass('d-none')
        }
    }

    $(document).on('click', 'button#deleteAllUser', function () {
        var checkedUser = [];
        $('input[name="single_checkboxUser"]:checked').each(function () {
            checkedUser.push($(this).data('id'))

        })
        var url = 'delete/selected';
        if (checkedUser.length > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    $.post(url, {
                        checked_user: checkedUser,
                        _token: $('[name="_token"]').val(),
                    }, function (data) {
                        if (data.status == 1) {
                            $('#userlist').DataTable().ajax.reload(null, true);
                            $.toast({
                                    text:data.msg,
                                    showHideTransition: 'slide',
                                    icon: 'success',
                                    hideAfter: 10000,
                                    stack:3,
                                    position: 'top-right'
                                })
                        }
                    }, 'json');
                }
            })
        }
    })

    $(".toggle-password").click(function () {

        $(this).toggleClass("fa-eye-slash fa-eye");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
            $(this).css("cursor", "pointer");
        } else {
            input.attr("type", "password");
            $(this).css("cursor", "default");
        }
    });

    $('#updateUserForm').on('submit', function (event) {
        event.preventDefault();
        submitForm = $(this);
        submitBtn = $(this).find('#submitUpdateForm');
        var url=$(this).data('redirecturl');
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
                   
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#updateUserForm')[0].reset();

                    $.toast({
                        text:data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        position: 'top-right'
                    })

                    window.setTimeout(function() {
                        window.location.href = url;
                    }, 2000);
                    
                }
            }

        })


    })

    $('.profile').click(function(e){
        e.preventDefault();
        var id = $(this).data('id');
        var url = $(this).data('url');
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success:function(data){
                $('#loader').hide();
                $('#username').val(data.user.name)
                $('#useremail').val(data.user.email)
                $('#profile_id').val(data.user.id)
            }
        })
    })

    $('#updateUserProfile').on('submit', function (event) {
        event.preventDefault();
        submitForm = $(this);
        submitBtn = $(this).find('#submitUserProfile');

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
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    
                    $('#updateUserProfile')[0].reset();
                    $.toast({
                        text:data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack:3,
                        position: 'top-right'
                    })

                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000);
    
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

                    $.ajax({
                        url: action,
                        type: 'get',
                        dataType: 'json',
                        beforeSend: function () {
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


    $('#updateUserAvatar').on('submit', function (event) {
        event.preventDefault();
        submitForm = $(this);
        submitBtn = $(this).find('#submitUserAvatar');
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
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    
                    $('#updateUserAvatar')[0].reset();
                    $.toast({
                        text:data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack:3,
                        position: 'top-right'
                    })

                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000);
    
                }
            }

        })


    })

    $('#roleForm').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#roleSubmitBtn');
        var url=$(this).data('redirecturl');
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
                    $.toast({
                        text:data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack:3,
                        position: 'top-right'
                    })
                    window.setTimeout(function() {
                        window.location.href = url;
                    }, 2000);
                }
            }

        })


    })

    $(document).on('click', 'input[name="all_checkbox"]', function (e) {
        if (this.checked) {
            $('input[name="single_checkbox"]').each(function () {
                this.checked = true;
            })
        } else {
            $('input[name="single_checkbox"]').each(function () {
                this.checked = false;
            })
        }
        toggleBtn()
    })

    $(document).on('click', 'input[name="single_checkbox"]', function (e) {
        if ($('input[name="single_checkbox"]').length == $('input[name="single_checkbox"]:checked').length) {
            $('input[name="all_checkbox"]').prop('checked', true);
        } else {
            $('input[name="all_checkbox"]').prop('checked', false);
        }
        toggleBtn()
    })

    function toggleBtn() {
        if ($('input[name="single_checkbox"]').length > 0) {
            $('button#deleteAll').text('Delete').removeClass('d-none')
        } else {
            $('button#deleteAll').addClass('d-none')
        }
    }

    $(document).on('click', 'button#deleteAll', function (e) {
        e.preventDefault();
        // var action = $(this).attr('data-action')
        var checkedRoles = [];
        $('input[name="single_checkbox"]:checked').each(function () {
            checkedRoles.push($(this).data('id'))

        })
        // alert(checkedRoles);
        var url = 'delete/selected';
        if (checkedRoles.length > 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.value) {
                    console.log('ok');
                    // $.post(url, {
                    //     checked_roles_ids: checkedRoles,
                    //     "_token": "{{ csrf_token() }}",
                    // }, function (data) {



                    //              console.log(data);
                    //     if (data.status == 1) {
                    //         // $('#rolelist').DataTable().ajax.reload(null, true);
                    //         // toastr.success(data.msg);
                    //     }
                    // }, 'json');

                    $.ajax({
                        url: url,
                        type: 'post',
                        data:{
                            checked_roles_ids: checkedRoles,
                            _token: $('[name="_token"]').val(),
                        },
                        
                        beforeSend: function () {
                            // loader(1);
                            
                        },
                        success: function (msg) {
                            if (msg.status == 0) {
                                // toaster(msg.title, msg.msg, msg.type);
                            } else {
                                // toaster(msg.title, msg.msg, msg.type);
                                $('#rolelist').DataTable().ajax.reload(null, true);
                            }
                            setTimeout(function () {
                                $("#alert").css('display', 'none');
                            }, 5000);
                        }
                    });
                }
            })
        }
    })

    $('#updateRoleForm').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#updateRoleBtn');
        event.preventDefault();
        // var url = "'roles/index'";
        var url=$(this).data('redirecturl');
        // console.log(url);
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
                    $.toast({
                        text:data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack:3,
                        position: 'top-right'
                    })
                    window.setTimeout(function() {
                        window.location.href = url;
                    }, 2000);
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
        url=$(this).data('redirecturl');
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
                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#permissionForm')[0].reset();
                    $.toast({
                        text:data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack:3,
                        position: 'top-right'
                    })
                    window.setTimeout(function() {
                        window.location.href = url;
                    }, 2000);
                }
            }

        })
    })

    // $('#updatePermission').on('submit', function (event) {
    //     submitForm = $(this);
    //     submitBtn = $(this).find('#updatePermissionBtn');
    //     var url=$(this).data('redirecturl');
    //     event.preventDefault();
    //     $.ajax({
    //         url: $(this).attr('action'),
    //         type: $(this).attr('method'),
    //         dataType: 'json',
    //         data: new FormData(this),
    //         cache: false,
    //         processData: false,
    //         contentType: false,
    //         beforeSend: function () {
    //             submitBtn.attr("disabled", "disabled").text('Please wait..')
    //             $(document).find('span.error-text').text('');
    //         },
    //         success: function (data) {
    //             submitBtn.attr("disabled", false).text('Update');
    //             if (data.status == 0) {
    //                 // console.log('not ok');
    //                 $.each(data.error, function (prefix, val) {
    //                     $('span.' + prefix + '_error').text(val[0])
    //                 })
    //             } else {
    //                 $('#updatePermission')[0].reset();
    //                 // $.toast({
    //                 //     text:data.msg,
    //                 //     showHideTransition: 'slide',
    //                 //     icon: 'success',
    //                 //     hideAfter: 2000,
    //                 //     stack:3,
    //                 //     position: 'top-right'
    //                 // })
    //                 // window.setTimeout(function() {
    //                 //     window.location.href = url;
    //                 // }, 2000);
    //             }
    //         }

    //     })


    // })

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
                   $.toast({
                        text:data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack:3,
                        position: 'top-right'
                    })
                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            }

        })
    })

    $('.deletePermission').on('click', function (event) {
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
                            toaster(msg.title, msg.msg, msg.type);
                        } else {
                            window.location.reload();
                        }
                    }
                });

            }
        })
    })

});
