<?php
require_once 'Interfaces/IOprerationsDB.php';
require_once 'classes/DB.php';
require_once 'classes/FacadeDB.php';

try {

    $db = new DB('localhost', 'test', 'root', '');
    $facadeDB = new FacadeDB($db->getConnection());





} catch (Exception $exception) {
    echo "Error: ";
}
?>