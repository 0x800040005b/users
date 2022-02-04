<footer class="footer">

</footer>

<!-- Modals Windows -->

<div id="alert" class="alert  alert-dismissible fade show my-alert" role="alert">
    <div><strong>Holy guacamole!</strong> You should check in on some of those fields below.</div>
</div>

<!-- Modal for Add User and Edit User -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col">
                            <input type="text" class="form-control" name="first_name" placeholder="First name">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="last_name" placeholder="Last name">
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-check form-switch">
                                <input class="form-check-switch" name="isActive" type="checkbox"
                                       id="flexSwitchCheckChecked">
                                <label class="form-check-label" for="flexSwitchCheckChecked">Is Active? </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="role">Role User</label>
                                <select name="role" class="form-control role" id="role">
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button id="btn-user" type="button" data-dismiss="modal" class="btn btn-primary">Add User</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Add User and Edit User END -->

<div class="modal fade" id="confirmDialogDelete" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you want to delete this record?
            </div>
            <div class="modal-footer">
                <button type="button" data-confirm="no" class="btn btn-secondary"
                        data-dismiss="modal">No
                </button>
                <button type="button" data-confirm="yes" data-dismiss="modal" aria-label="Close"
                        class="btn btn-primary btn-confirm-delete">Yes
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Modals Windows END -->

<script src="https://kit.fontawesome.com/0b4b2506a1.js" crossorigin="anonymous"></script>

<script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
<script
        src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF"
        crossorigin="anonymous"></script>


<script>
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
        let tBodyTable = $('#tbody-table');
        let selectGroupAction = $('.select-group-action');

        /* front-end END */

        let ids = [];
        let id = null;
        let method = null;
        let count = null;


        /* EVENTS */

        /* Edit OR Add User */
        table.on('click', '.btn-action-edit', buttonEditSelectFunction);
        $(document).on('click', "#btn-user", buttonUserUpdateFunction);


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
            if ($(this).prop('checked')) {
                $('.my-check-input').each(function () {
                    $(this).prop('checked', true);
                    ids.push($(this).val());
                });
            } else {
                $('.my-check-input').each(function () {
                    $(this).prop('checked', false);
                    ids.splice($.inArray($(this).val, ids), 1);
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
            isActiveCheckbox.attr('checked', 'checked');
            roleOptions.each(function () {
                $(this).removeAttr('selected');

            });

            title.text('Add User');
            btnUser.text('Add User');

        }
        function buttonEditSelectFunction() {
            id = $(this).attr('data-id');
            method = 'edit';

            title.text('Edit User');
            btnUser.text('Edit User');

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

                        data.role === $(this).attr('value') ? $(this).attr('selected', 'selected') : $(this).removeAttr('selected');

                    });

                },
                error: function (data) {
                    alert.text('error');
                    errorAlert();
                },
            });

        }
        function buttonUserUpdateFunction() {
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
                            circle.removeClass('red');
                            circle.addClass('green');
                        } else {
                            circle.removeClass('green')
                            circle.addClass('red');
                        }
                        tr.find('td#status .text').text(data.data.status);
                        tr.find('td#role').text(data.data.role);

                        alert.text(data.text);
                        successAlert();
                        method = null;
                        reset();


                    },
                    error: function (data) {
                        alert.text(data.responseJSON);
                        errorAlert();
                        method = null;
                        reset()


                    },
                });


            }
            if (method === 'add') {
                let is_active = isActiveCheckbox.is(':checked') ? '1' : '0';
                $.ajax({
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
                        data.data.status === '1' ? circleElement = `<div class="circle green"></div>` : circleElement = `<div class="circle red"></div>`

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
                        alert.text(data.text)
                        successAlert();
                        reset();
                        method = null;
                        id = null;

                    },
                    error: function (data) {
                        console.log(data);
                        alert.text(data.responseJSON.text);
                        errorAlert();
                        method = null;
                        reset();
                    },
                });


            }

        }


        /* Delete User Functions */
        function buttonDeleteFunction() {
            id = $(this).attr('data-id');
            method = $(this).attr('data-method');
        }
        function buttonConfirmDeleteFunction() {

            if ($(this).attr('data-confirm') === 'yes') {


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
                        method = null;
                        reset();
                    },
                    error: function (data) {
                        alert.text('delete failed');
                        errorAlert();
                        method = null;
                        reset();
                    },
                });

            }


        }


        /* Group Actions */

        function btnGroupOKFunction() {
            if ((method !== '0' && method !== null) && ids.length > 0) {
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
                            method = null;
                            reset();


                        },
                        error: function (data) {
                            alert.text(data.responseText);
                            errorAlert();
                            method = null;
                            reset();

                        },
                    });

                }
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
                            method = null;
                            reset();


                        },
                        error: function (data) {
                            alert.text(data.responseText);
                            errorAlert();
                            method = null;
                            reset();

                        },
                    });

                }


            } else {
                alert.text('You need to sure that you choices users and choices right action');
                errorAlert();
            }
        }

        function selectGroupActionFunction() {

            method = $(this).find('option:selected').val();
        }
        function changeStatusFront(ids, status) {
            if (Array.isArray(ids)) {
                ids.forEach((item) => {
                    $('#' + item).find("#status .text").text(status);
                    status === '1' ? $('#' + item).find("#status .circle").removeClass('red').addClass('green')
                        : $('#' + item).find("#status .circle").removeClass('green').addClass('red')


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
            console.log(count, ids, ids.length);
            if (count === ids.length)
                selectAllCheckbox.prop('checked', true);
            else
                selectAllCheckbox.prop('checked', false);

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
            $('.form-check-input').each(function (){
               $(this).prop('checked', false);
            });
            ids.splice(0,ids.length)

        }


    });

</script>

</body>
</html>