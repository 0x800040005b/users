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
                            <label for="first-name" class="col-form-label">First Name:</label>
                            <input id="first-name" type="text" class="form-control" name="first_name" placeholder="First name">
                        </div>
                        <div class="col">
                            <label for="last-name" class="col-form-label">Last Name:</label>
                            <input id="last-name" type="text" class="form-control" name="last_name" placeholder="Last name">
                        </div>

                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="isActive" class="custom-control-input" id="flexSwitchCheckChecked">
                                <label class="col-form-label custom-control-label" for="flexSwitchCheckChecked">Is Active?</label>
                            </div>
                   </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="role" class="col-form-label">Role User</label>
                                <select name="role" class="form-control role" id="role">
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                        </div>

                    </div>
            </div>
            <div class="modal-footer">
                <button id="btn-user" type="button" class="btn btn-primary">Add User</button>
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
                Do you want to delete this user?
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


<script src="../js/index.js"></script>

</body>
</html>