<?php


interface IOprerationsDB
{
    public function selectAll();
    public function selectByID($id);
    public function insertUser($values);
    public function deleteByID($id);
    public function editByID($id, $values);
    public function getLastID();
    public function deleteGroupByID($ids);
    public function statusGroupByID($ids, $status);

}