$(document).ready(function () {

    /* front-end */

    let url = 'http://users.loc/send.php';
    let requestMethod = 'POST';
    let dataType = 'JSON';

    let selectAllCheckbox = $("#checkAll");

    let btnAdd = $('.btn-add');
    let btnUser = $('#btn-user');
    let btnOK = $('.btn-ok');
    let btnConfirmDelete = $('.btn-confirm-delete');

    let inputFirstName = $(".form-control[name='first_name']");
    let inputLastName = $(".form-control[name='last_name']");

    let isActiveCheckbox = $('#flexSwitchCheckChecked');
    let roleOptions = $("#role option");
    let circle = $('.circle');
    let circleElement = null;

    let title = $('#userModalLabel');
    let alert = $("#alert");
    let table = $('.my-table');
    let confirmDialogDelete = $('#confirmDialogDelete');
    let tBodyTable = $('#tbody-table');
    let selectGroupAction = $('.select-group-action');
    let formError = $('.form-error');

    /* front-end END */

    let ids = [];
    let id = null;
    let method = null;
    let count = null; // для мультивибору.
    let currentSelect = null;


    /* EVENTS */

    /* Edit OR Add User */
    table.on('click', '.btn-action-edit', buttonEditSelectFunction);
    $(document).on('click', "#btn-user", buttonUserUpdateOrAddFunction);


    /* Add User */
    btnAdd.click(buttonAddFunction);


    /* Delete User */
    table.on('click', '.btn-action-delete', buttonDeleteFunction);
    btnConfirmDelete.on({
        'click': buttonConfirmDeleteFunction
    });


    /* Checkboxes Select Multiple Choice*/

    table.on('change', '.my-check-input', checkCheckboxes);
    table.on('click', '#checkAll', function () {
        ids.splice(0, ids.length);
        if ($(this).prop('checked')) {
            $('.my-check-input').each(function () {
                $(this).prop('checked', true);
                ids.push($(this).val());
            });
        } else {
            $('.my-check-input').each(function () {
                $(this).prop('checked', false);

            });

        }

    });
    btnOK.on({
        'click': btnGroupOKFunction
    });


    selectGroupAction.on({
        'change': selectGroupActionFunction
    });
    /* EVENTS END */


    /* Alerts functions */

    function successAlert() {

        /* Alert Rules */
        alert.addClass('active');
        alert.removeClass('alert-danger');
        alert.addClass('alert-success');
        hideAlert();
    }
    function errorAlert() {
        alert.addClass('active');
        alert.addClass('alert-danger');
        alert.removeClass('alert-success');
        hideAlert();
    }
    function hideAlert() {
        setTimeout(function () {
            alert.removeClass('active');
        }, 3000);
    }

    /* Alerts functions END */


    /* Edit OR Add User Functions */
    function buttonAddFunction() {

        method = 'add';

        inputFirstName.val('');
        inputLastName.val('');
        isActiveCheckbox.prop('checked', true);
        roleOptions.each(function () {
            $(this).removeAttr('selected');

        });

        title.text('Add User');
        btnUser.text('Add User');
        formError.text('');

    }

    function buttonEditSelectFunction() {
        id = $(this).attr('data-id');
        method = 'edit';

        title.text('Edit User');
        btnUser.text('Edit User');
        formError.text('');

        $.ajax({
            url: url,
            method: requestMethod,
            dataType: dataType,
            data: {
                "method": method,
                "id": id,

            },
            success: function (data) {
                inputFirstName.val(data.first_name);
                inputLastName.val(data.last_name);
                data.status === '1' ? isActiveCheckbox.prop('checked', true) : isActiveCheckbox.prop('checked', false);
                roleOptions.each(function () {

                    data.role === $(this).attr('value') ? $(this).prop('selected', true) : $(this).prop('selected', false);

                });

            },
            error: function (data) {
                alert.text('error');
                errorAlert();
            },
        });

    }

    function buttonUserUpdateOrAddFunction() {
        if (method === 'edit') {
            method = 'update';
            let is_active = isActiveCheckbox.is(':checked') ? '1' : '0';
            $.ajax({
                url: url,
                method: requestMethod,
                dataType: dataType,
                data: {
                    "method": method,
                    "id": id,
                    'role': roleOptions.filter(":selected").val(),
                    'first_name': inputFirstName.val(),
                    'last_name': inputLastName.val(),
                    'status': is_active,

                },
                success: function (data) {

                    let tr = $('tr#' + data.data.id);
                    tr.find('td#name').text(data.data.first_name + ' ' + data.data.last_name);
                    circle = tr.find('td#status .circle');
                    if (data.data.status === '1') {
                        circle.removeClass('not-active-status');
                        circle.addClass('active-status');
                    } else {
                        circle.removeClass('active-status')
                        circle.addClass('not-active-status');
                    }
                    tr.find('td#status .text').text(data.data.status);
                    tr.find('td#role').text(data.data.role);

                    alert.text(data.text);
                    successAlert();
                    reset();
                    $('#userModal').modal('hide');


                },
                error: function (data) {
                    formError.text(data.responseJSON);
                    method = 'edit';


                },
            });


        }
        if (method === 'add') {
            let is_active = isActiveCheckbox.is(':checked') ? '1' : '0';
            let request = $.ajax({
                url: url,
                method: requestMethod,
                dataType: dataType,
                data: {
                    "method": method,
                    'role': roleOptions.filter(":selected").val(),
                    'first_name': inputFirstName.val(),
                    'last_name': inputLastName.val(),
                    'status': is_active,

                },
                success: function (data) {
                    data.data.status === '1' ? circleElement = `<div class="circle active-status"></div>` : circleElement = `<div class="circle not-active-status"></div>`

                    let trHTML = `
                           <tr id="${data.data.id}">
                            <td>
                                <div class="form-check">
                                   <input class="form-check-input my-check-input" type="checkbox"  value="${data.data.id}" id="defaultCheck${data.data.id}">
                                    <label class="form-check-label" for="defaultCheck${data.data.id}">
                                    </label>
                                </div>
                            </td>
                            <th scope="row">${data.data.id}</th>
                            <td id="name">
                               ${data.data.first_name} ${data.data.last_name}
                            </td>
                            <td id="status">
                                <div class="text">${data.data.status}</div>
                                 ${circleElement}
                            </td>

                            <td id="role">${data.data.role}</td>
                            <td>
                                <button type="button" data-method="edit" data-id="${data.data.id}" class="btn btn-light btn-action-edit mr-2" data-toggle="modal" data-target="#userModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" data-method="delete" data-toggle="modal" data-target="#confirmDialogDelete" data-id="${data.data.id}" class="btn btn-light btn-action-delete">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
 `;
                    tBodyTable.append(trHTML);
                    alert.text(data.text);

                    successAlert();
                    reset();
                    id = null;
                    $('#userModal').modal('hide');

                },
                error: function (data) {
                    formError.text(data.responseJSON.text);
                },
            });


        }

    }


    /* Delete User Functions */
    function buttonDeleteFunction() {
        id = $(this).attr('data-id');
        method = $(this).attr('data-method');
        confirmDialogDelete.find('.modal-body').text('Do you want to delete this user?');
        confirmDialogDelete.find('#userModalLabel').text('Delete user?');
    }

    function buttonConfirmDeleteFunction() {

        if ($(this).attr('data-confirm') === 'yes') {
            if (method === 'groupDelete') {
                $.ajax({
                    url: url,
                    method: requestMethod,
                    dataType: dataType,
                    data: {
                        "method": method,
                        "ids": ids,
                    },
                    success: function (data) {
                        deleteUserFront(data.data);
                        alert.text(data.text);
                        successAlert();

                        reset();


                    },
                    error: function (data) {
                        alert.text(data.responseText);
                        errorAlert();
                        reset();

                    },
                });


            }
            else {
                $.ajax({
                    url: url,
                    method: requestMethod,
                    dataType: dataType,
                    data: {
                        "method": method,
                        "id": id,
                    },
                    success: function (data) {
                        deleteUserFront(id);

                        reset();
                    },
                    error: function (data) {
                        alert.text('delete failed');
                        errorAlert();
                        reset();
                    },
                });
            }

        }
        reset();


    }


    /* Group Actions */

    function btnGroupOKFunction() {
         let correctSelect = $(this).attr('data-group') === currentSelect;


        if ((method !== '0' && method !== null) && ids.length > 0  && correctSelect) {
            if (method === 'groupActive' || method === 'groupInactive') {
                $.ajax({
                    url: url,
                    method: requestMethod,
                    dataType: dataType,
                    data: {
                        "method": method,
                        "ids": ids,
                    },
                    success: function (data) {
                        changeStatusFront(data.data, data.status);
                        alert.text(data.text);
                        successAlert();
                        reset();


                    },
                    error: function (data) {
                        alert.text(data.responseText);
                        errorAlert();

                        reset();

                    },
                });

            }else{
                deleteGroupFront();
            }


        } else {
            alert.text('You need to sure that you choices users and choices right action');
            errorAlert();
        }
    }

    function selectGroupActionFunction() {
        method = $(this).find('option:selected').val();
        currentSelect = $(this).attr('data-group');
    }

    function changeStatusFront(ids, status) {
        if (Array.isArray(ids)) {
            ids.forEach((item) => {
                $('#' + item).find("#status .text").text(status);
                status === '1' ? $('#' + item).find("#status .circle").removeClass('not-active-status').addClass('active-status')
                    : $('#' + item).find("#status .circle").removeClass('active-status').addClass('not-active-status')


            });

        }
    }


    /* Group Actions END */

    function getCountChecksFunction() {
        return $('.my-check-input').length;
    }

    function checkCheckboxes() {
        count = getCountChecksFunction();
        if ($(this).prop('checked'))
            ids.push($(this).val());
        else {
            ids.splice($.inArray($(this).val(), ids), 1);
        }
        if (count === ids.length)
            selectAllCheckbox.prop('checked', true);
        else
            selectAllCheckbox.prop('checked', false);

    }
    function deleteGroupFront(){
        if (ids.length > 0) {
            btnOK.attr('data-toggle', 'modal');
            btnOK.attr('data-target', '#confirmDialogDelete');
            confirmDialogDelete.find('.modal-body').text('Do you want to delete these users?');
            confirmDialogDelete.find('#userModalLabel').text('Delete Users?')

        } else {
            btnOK.removeAttr('data-toggle');
            btnOK.removeAttr('data-target');



        }

    }

    function deleteUserFront(id) {
        if (Array.isArray(id)) {
            id.forEach((item) => {
                $('#' + item).remove();
            });
        } else {
            $('#' + id).remove();

        }
    }

    function reset() {
        selectGroupAction.each(function () {
            $(this).find('option').first().prop("selected", true);
        });
        $('.form-check-input').each(function () {
            $(this).prop('checked', false);
        });
        ids.splice(0, ids.length);
        btnOK.removeAttr('data-toggle');
        btnOK.removeAttr('data-target');
        method = null;
        formError.text('');


    }


});
