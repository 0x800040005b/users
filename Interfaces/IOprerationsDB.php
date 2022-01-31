<?php


interface IOprerationsDB
{
    public function selectAll();
    public function selectByID(int $id);
    public function insertUser(array $values);
    public function deleteByID(int $id);
    public function editByID( int $id, array $values);
    public function getLastID();

}