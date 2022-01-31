<footer class="footer">

</footer>

<!-- Modals Windows -->

<div id="alert" class="alert  alert-dismissible fade show my-alert" role="alert">
    <div><strong>Holy guacamole!</strong> You should check in on some of those fields below.</div>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
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
                <form class="form" id="formUser" action="#" method="post">
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
                </form>
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
                <button type="button" data-confirm="no" class="btn btn-secondary btn-confirm-delete"
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

<script src="../js/main.js"></script>
<script>
    $(document).ready(function () {

        let ids = [];
        let selectCheckboxes = $('.my-check-input');
        let selectAllCheckbox = $("#checkAll");

        let buttonUser = $('#btn-user');

        let inputFirstName = $("#formUser .form-control[name='first_name']");
        let inputLastName = $("#formUser .form-control[name='last_name']");

        let isActiveCheckbox = $('#flexSwitchCheckChecked');
        let roleOptions = $("#role option");

        let title = $('#userModalLabel');
        let alert = $("#alert");
        let tBodyTable = $('#tbody-table');


        let id = null;
        let method = null;

        /* EVENTS */

        /* Edit User */
        $(document).on('click','.btn-action-edit', buttonEditSelectFunction);
        $(document).on('click','#btn-user', buttonUserUpdateFunction);


        /* Add User */
        $(document).on('click','.btn-add', buttonAddFunction);


        /* Delete User */
        $(document).on('click','.btn-action-delete', buttonDeleteFunction);
        $(document).on('click','.btn-confirm-delete', buttonConfirmDeleteFunction);

        function hideAlert(){
            setTimeout(function (){
                alert.removeClass('active');
            },3000);
        }

        function successAlert(){

            /* Alert Rules */
            alert.addClass('active');
            alert.removeClass('alert-danger');
            alert.addClass('alert-success');
            hideAlert();
        }

        function errorAlert(){
            alert.addClass('active');
            alert.addClass('alert-danger');
            alert.removeClass('alert-success');
            hideAlert();
        }


        function buttonUserUpdateFunction(){
            {
                if (method === 'edit') {
                    method = 'update';
                    let is_active = isActiveCheckbox.is(':checked') ? '1' : '0';

                    $.ajax({
                        url: 'http://users.loc/send.php',
                        method: "POST",
                        dataType: 'JSON',
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
                            tr.find('td#status').text(data.data.status);
                            tr.find('td#role').text(data.data.role);

                            alert.find('div').text(data.text);
                            successAlert();
                            selectCheckboxes = $('.form-check-input');




                        },
                        error: function (data) {
                            alert.find('div').text(data.responseJSON);
                            errorAlert();


                        },
                    });


                }
                if(method === 'add'){
                    let is_active = isActiveCheckbox.is(':checked') ? '1' : '0';

                    $.ajax({
                        url: 'http://users.loc/send.php',
                        method: "POST",
                        dataType: 'JSON',
                        data: {
                            "method": method,
                            'role': roleOptions.filter(":selected").val(),
                            'first_name': inputFirstName.val(),
                            'last_name': inputLastName.val(),
                            'status': is_active,

                        },
                        success: function (data) {
                            console.log(data.data);
                            let trHTML = `
                           <tr id="${data.data.id}">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="${data.data.id}" id="defaultCheck${data.data.id}">
                                    <label class="form-check-label" for="defaultCheck${data.data.id}">
                                    </label>
                                </div>
                            </td>
                            <th scope="row">${data.data.id}</th>
                            <td id="name">
                               ${data.data.first_name} ${data.data.last_name}
                            </td>
                            <td id="status">${data.data.status}</td>
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
                            method = null;
                            id = null;
                            selectCheckboxes = $('.form-check-input')

                        },
                        error: function (data, status, error) {
                            console.log(error);
                        },
                    });


                }
            }
        }
        function buttonConfirmDeleteFunction(){

            if ($(this).attr('data-confirm') === 'yes') {


                $.ajax({
                    url: 'http://users.loc/send.php',
                    method: 'POST',
                    dataType: 'JSON',
                    data: {
                        "method": method,
                        "id": id,
                    },
                    success: function (data) {
                        $('#' + id).remove();


                    },
                    error: function (data) {},
                });

            }


        }
        function buttonDeleteFunction() {
            id = $(this).attr('data-id');
            method = $(this).attr('data-method');
            console.log(id, method);
        }
        function buttonEditSelectFunction(){
            id = $(this).attr('data-id');
            method = 'edit';

            title.text('Edit User');
            buttonUser.text('Edit User');

            $.ajax({
                url: 'http://users.loc/send.php',
                method: "POST",
                dataType: 'JSON',
                data: {
                    "method": method,
                    "id": id,

                },
                success: function (data) {

                    inputFirstName.val(data.first_name);
                    inputLastName.val(data.last_name);

                    data.status === '1' ? isActiveCheckbox.attr('checked', 'checked') : isActiveCheckbox.removeAttr('checked');
                    roleOptions.each(function () {

                        data.role === $(this).attr('value') ? $(this).attr('selected', 'selected') : $(this).removeAttr('selected');

                    });

                },
                error: function (data) {
                    console.log('error: ' + data);
                },
            });

        }

        function buttonAddFunction () {
            method = 'add';

            inputFirstName.val('');
            inputLastName.val('');
            isActiveCheckbox.attr('checked', 'checked');
            roleOptions.each(function () {
                $(this).removeAttr('selected');

            });

            title.text('Add User');
            buttonUser.text('Add User');

        }

    });

</script>
</body>
</html>