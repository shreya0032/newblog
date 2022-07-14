$('document').ready(function () {
    $(function () {
        var url = window.location;
        // for single sidebar menu
        $('ul.nav-sidebar a').filter(function () {
            return this.href == url;
        }).addClass('active');
    
        // for sidebar menu and treeview
        $('ul.nav-treeview a').filter(function () {
            return this.href == url;
        }).parentsUntil(".nav-sidebar > .nav-treeview")
            .css({'display': 'block'})
            .addClass('menu-open').prev('a')
            .addClass('active');
    });

    
    $('#createUserForm').on('submit', function (event) {
        event.preventDefault();
        submitForm = $(this);
        submitBtn = $(this).find('#submitUserForm');
        var url = $(this).data('redirecturl');
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
                        text: data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack: 3,
                        position: 'top-right'
                    })
                    window.setTimeout(function () {
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
        var url = $(this).data('url');
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
                                text: data.msg,
                                showHideTransition: 'slide',
                                icon: 'success',
                                hideAfter: 2000,
                                stack: 3,
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
        var url = $(this).data('redirecturl');
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
                    console.log(data);

                    $.each(data.error, function (prefix, val) {
                        $('span.' + prefix + '_error').text(val[0])
                    })
                } else {
                    $('#updateUserForm')[0].reset();

                    $.toast({
                        text: data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        position: 'top-right'
                    })

                    window.setTimeout(function () {
                        window.location.href = url;
                    }, 2000);

                }
            }

        })


    })

    $('.profile').click(function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = $(this).data('url');
        $('.error-text').text('');

        $.ajax({
            url: url + '/' + id,
            type: 'GET',
            success: function (data) {
                $('#username').val(data.user.name)
                $('#useremail').val(data.user.email)
                $('#profile_id').val(id)
            }
        })
    })


    $('.avatar').click(function (e) {
        e.preventDefault();
        $('.error-text').text('');
        $('#avatar_file').val('');
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
                        text: data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack: 3,
                        position: 'top-right'
                    })

                    window.setTimeout(function () {
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
                        beforeSend: function () { },
                        success: function (data) {
                            if (data.status != 0) {
                                reloadDatatable.ajax.reload(null, false);
                            }
                            $.toast({
                                text: data.msg,
                                showHideTransition: 'slide',
                                icon: 'success',
                                hideAfter: 2000,
                                position: 'top-right'
                            })
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
                        text: data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack: 3,
                        position: 'top-right'
                    })

                    window.setTimeout(function () {
                        window.location.reload();
                    }, 2000);

                }
            }

        })


    })

    $('#roleForm').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#roleSubmitBtn');
        var url = $(this).data('redirecturl');
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
                        text: data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack: 3,
                        position: 'top-right'
                    })
                    window.setTimeout(function () {
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
        var url = $(this).data('url');
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
                    $.post(url, {
                        checked_roles_ids: checkedRoles,
                        _token: $('[name="_token"]').val(),
                    }, function (data) {
                        if (data.status == 1) {
                            $('#rolelist').DataTable().ajax.reload(null, true);
                            $.toast({
                                text: data.msg,
                                showHideTransition: 'slide',
                                icon: 'success',
                                hideAfter: 2000,
                                stack: 3,
                                position: 'top-right'
                            })
                        }
                    }, 'json');
                }
            })
        }
    })

    $('#updateRoleForm').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#updateRoleBtn');
        event.preventDefault();
        // var url = "'roles/index'";
        var url = $(this).data('redirecturl');
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
                        text: data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack: 3,
                        position: 'top-right'
                    })
                    window.setTimeout(function () {
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
                    $.ajax({
                        url: action,
                        type: 'get',
                        dataType: 'json',
                        success: function (data) {
                            // loader(0);
                            if (data.status != 0) {
                                reloadDatatable.ajax.reload(null, false);
                            }
                            $.toast({
                                text: data.msg,
                                showHideTransition: 'slide',
                                icon: 'success',
                                hideAfter: 2000,
                                position: 'top-right'
                            })
                        }
                    });

                }
            })

        }
    });


    $('#permissionForm').on('submit', function (event) {
        submitForm = $(this);
        submitBtn = $(this).find('#submitPermissionBtn');
        url = $(this).data('redirecturl');
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
                        text: data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack: 3,
                        position: 'top-right'
                    })
                    // window.setTimeout(function () {
                    //     window.location.href = url;
                    // }, 2000);
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

    $('body').delegate('#dynamicTableList .deletepermission', 'click', function () {
        var type = $(this).attr('data-type')
        var id = $(this).attr('data-id')
        var action = $(this).attr('data-action')
        var reloadDatatable = $('#dynamicTableList').DataTable();
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
                        success: function (data) {
                            // loader(0);
                            if (data.status != 0) {
                                reloadDatatable.ajax.reload(null, false);
                            }
                            $.toast({
                                text: data.msg,
                                showHideTransition: 'slide',
                                icon: 'success',
                                hideAfter: 2000,
                                position: 'top-right'
                            })
                        }
                    });

                }
            })

        }
    });

    $(document).on('click', 'input[name="permission_allchkbx"]', function (e) {
        if (this.checked) {
            $('input[name="permission_singlechkbx"]').each(function () {
                this.checked = true;
            })
        } else {
            $('input[name="permission_singlechkbx"]').each(function () {
                this.checked = false;
            })
        }
        togglePerissionBtn()
    })

    $(document).on('click', 'input[name="permission_singlechkbx"]', function (e) {
        if ($('input[name="permission_singlechkbx"]').length == $('input[name="permission_singlechkbx"]:checked').length) {
            $('input[name="permission_allchkbx"]').prop('checked', true);
        } else {
            $('input[name="permission_allchkbx"]').prop('checked', false);
        }
        togglePerissionBtn()
    })

    function togglePerissionBtn() {
        if ($('input[name="permission_singlechkbx"]').length > 0) {
            $('button#permissionDeleteAll').text('Delete').removeClass('d-none')
        }
        else {
            $('button#permissionDeleteAll').addClass('d-none')
        }
    }

    $(document).on('click', 'button#permissionDeleteAll', function () {
        var checkedPermission = [];
        $('input[name="permission_singlechkbx"]:checked').each(function () {
            checkedPermission.push($(this).data('id'))
        })
        var url = $(this).data('url');
        if (checkedPermission.length > 0) {
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
                        checked_permission: checkedPermission,
                        _token: $('[name="_token"]').val(),
                    }, function (data) {
                        if (data.status == 1) {
                            $('#dynamicTableList').DataTable().ajax.reload(null, true);
                            $.toast({
                                text: data.msg,
                                showHideTransition: 'slide',
                                icon: 'success',
                                hideAfter: 2000,
                                stack: 3,
                                position: 'top-right'
                            })
                        }
                    }, 'json');
                }
            })
        }
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
                    $.toast({
                        text: data.msg,
                        showHideTransition: 'slide',
                        icon: 'error',
                        hideAfter: 2000,
                        stack: 3,
                        position: 'top-right'
                    })
                } else {
                    $('#updateManagePermission')[0].reset();
                    $.toast({
                        text: data.msg,
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        stack: 3,
                        position: 'top-right'
                    })
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
            }

        })
    })

    $('.deleteManagePermission').on('click', function (event) {
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
                $.ajax({
                    url: action,
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        $.toast({
                            text: data.msg,
                            showHideTransition: 'slide',
                            icon: 'success',
                            hideAfter: 2000,
                            position: 'top-right'
                        })

                        window.setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                });

            }
        })
    })
});
