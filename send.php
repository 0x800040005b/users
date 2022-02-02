<?php
require_once 'main.php';

if (strcasecmp($_POST['method'],'delete') === 0) {
    delete();
}
if (strcasecmp($_POST['method'],'edit') === 0) {
    select();
}
if (strcasecmp($_POST['method'],'update') === 0) {
    update();
}

if (strcasecmp($_POST['method'],'add') === 0) {

    insert();
}

if((strcasecmp($_POST['method'],'groupDelete') === 0)){
    deleteGroupByID();
}
if((strcasecmp($_POST['method'],'groupActive') === 0)){
    statusGroupByID('1');
}
if((strcasecmp($_POST['method'],'groupInactive') === 0)){
    statusGroupByID('0');
}




/* Delete User */
function delete(){
    global $facadeDB;
    $result = $facadeDB->deleteByID($_POST['id']);
    if($result){
        header("HTTP/1.0 200 OK ");
        echo json_encode(['id' => $_POST['id']]);
        return;
    }

    header("HTTP/1.0 203 Non-Authoritative Information");
    echo json_encode(['text' => 'DOn\'t deleted users']);


}
/* Edit User */
function select(){
    global $facadeDB;
    $result = $facadeDB->selectByID($_POST['id']);
    if ($result){
        header("HTTP/1.0 200 OK");
        echo json_encode($result);
        return;
    }
    header("HTTP/1.0 203 Non-Authoritative Information");
    echo json_encode($result);
}
function update(){
    global $facadeDB;
    if(empty($_POST['last_name']) || empty($_POST['first_name'])){
        header("HTTP/1.0 404 Not Found");
        echo json_encode('You Can\'t to update these Values');
        return;
    }

    $values  = ['id' => htmlspecialchars($_POST['id']),'first_name' => htmlspecialchars($_POST['first_name']),
                'last_name' => htmlspecialchars($_POST['last_name']),
                'status' => htmlspecialchars($_POST['status']),
                'role' => htmlspecialchars($_POST['role'])];




    $result = $facadeDB->editByID($_POST['id'], $values);

    if($result){
        header("HTTP/1.0 200 OK");
        echo json_encode(['data' => $values, 'text' => 'Updated successfully']);
        return;

    }

    header("HTTP/1.0 203 Non-Authoritative Information");
    echo json_encode(['text' => 'Non-Authoritative Information']);

}

/* Insert User*/
function insert(){
    global  $facadeDB;
    if(empty($_POST['last_name']) || empty($_POST['first_name'])){
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['text' => 'You Can\'t to insert empty Values']);
        return;
    }

    $values  = ['first_name' => htmlspecialchars($_POST['first_name']),
        'last_name' => htmlspecialchars($_POST['last_name']),
        'status' => htmlspecialchars($_POST['status']),
        'role' => htmlspecialchars($_POST['role'])];



    $result = $facadeDB->insertUser($values);

    if($result){
        header("HTTP/1.0 200 OK");
        $values['id'] = $facadeDB->getLastID();
        echo json_encode(['data' => $values, 'text' => 'insert successfully']);
        return;

    }

    header("HTTP/1.0 203 Non-Authoritative Information");
    echo json_encode(['text' => 'Non-Authoritative Information']);

}

/* Group Actions */
function deleteGroupByID(){
    global $facadeDB;
    $values = implode(',', $_POST['ids']);

    $result = $facadeDB->deleteGroupByID($values);
    if($result){
        header('HTTP/1.0 200 OK');
        echo json_encode(['data' => $_POST['ids'],'text' => 'deleted successfully']);
        return;
    }

    header('HTTP/1.0 404 Not Found');
    echo json_encode(['text' => 'you can\'t deleted these users']);


}
function statusGroupByID($status){
    global $facadeDB;
    $values = implode(',', $_POST['ids']);

    $result = $facadeDB->statusGroupByID($values,$status);
    if($result){
        header('HTTP/1.0 200 OK');
        echo json_encode(['data' => $_POST['ids'], 'status' => $status, 'text' => 'status changed successfully']);
        return;
    }

    header('HTTP/1.0 404 Not Found');
    echo json_encode(['text' => 'you can\'t set status for selected users']);


}


/* Group Actions END */




