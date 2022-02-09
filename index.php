<?php
require_once 'main.php';

?>
<?php require_once 'parts/header.php'; ?>

<main class="main">
    <div class="container">
        <div class="row justify-content-end mb-2 p-2">
            <div class="col-3 offset-md-4">
                <div class="form-controls">
                    <button id="add" type="button" class="btn btn-light mr-3 btn-add" data-toggle="modal" data-target="#userModal"> Add </button>
                    <select  name="select" data-group="select-1" class="select-group-action select-control mr-3 form-control form-control-sm">
                        <option value="0" selected>Please select</option>
                        <option value="groupActive">Set active</option>
                        <option value="groupInactive">Set not active</option>
                        <option value="groupDelete">Delete</option>
                    </select>
                    <button type="button" data-group="select-1" class="btn btn-light btn-ok"> OK</button>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <table class="table my-table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="checkAll">
                                <label class="form-check-label" for="defaultCheck1">
                                    Select ALL
                                </label>
                            </div>
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Role</th>
                        <th scope="col">Options</th>
                    </tr>
                    </thead>
                    <tbody id="tbody-table">
                    <?php
                    foreach ($facadeDB->selectAll() as $record) {?>
                        <tr id="<?=$record['id']?>" class="tr">
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input my-check-input" type="checkbox" value="<?=$record['id']?>" id="defaultCheck<?=$record['id']?>">
                                    <label class="form-check-label" for="defaultCheck<?=$record['id']?>">
                                    </label>
                                </div>
                            </td>
                            <th scope="row"><?=$record['id']?></th>
                            <td id="name">
                                <?=$record['first_name'].' '. $record['last_name']?>
                            </td>
                            <td id="status">
                                <div class="text"><?=$record['status']?></div>
                                <div class="circle <?php if($record['status'] === '1') echo 'green'; else echo 'red';?>"></div>
                            </td>
                            <td id="role"><?=$record['role']?></td>
                            <td>
                                <button type="button" data-method="edit" data-id="<?=$record['id']?>" class="btn btn-light btn-action-edit mr-2" data-toggle="modal" data-target="#userModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" data-method="delete" data-toggle="modal" data-target="#confirmDialogDelete" data-id="<?=$record['id']?>" class="btn btn-light btn-action-delete">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>

                    <?php    }
                    ?>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="row justify-content-end mt-2">
            <div class="col-3">
                <div class="form-controls">
                    <button type="button" class="btn btn-light mr-3 btn-add" data-toggle="modal" data-target="#userModal"> Add </button>
                    <select name="select" data-group="select-2" class="select-group-action select-control mr-3 form-control form-control-sm">
                        <option value="0" selected>Please select</option>
                        <option value="groupActive">Set active</option>
                        <option value="groupInactive">Set not active</option>
                        <option value="groupDelete">Delete</option>
                    </select>
                    <button type="button" data-group="select-2" class="btn btn-light btn-ok"> OK</button>
                </div>

            </div>
        </div>

    </div>
    <!-- data-toggle="modal" data-target="#userModal"-->

</main>
<?php require_once 'parts/footer.php'; ?>