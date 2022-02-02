<?php


class FacadeDB implements IOprerationsDB
{
    private PDO $connection;
    private $query;

    public function __construct($connection){
        if($connection instanceof PDO)
            $this->connection = $connection;
    }


    public function selectAll()
    {
        $this->query = "SELECT * FROM users";
        $sth = $this->connection->prepare($this->query);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_ASSOC);

    }
    public function insertUser($values)
    {
        $fistName = $values['first_name'];
        $lastName = $values['last_name'];
        $status = (integer)$values['status'];
        $role = $values['role'];

        $this->query = "INSERT INTO `users`(`first_name`, `last_name`, `status`, `role`) VALUES ('$fistName','$lastName','$status','$role')";
        $sth = $this->connection->prepare($this->query);
        return $sth->execute();
    }
    public function selectByID($id){
        $this->query = "SELECT * FROM users WHERE `id` = $id";
        $sth = $this->connection->prepare($this->query);
        $sth->execute(array($id));
        return $sth->fetch(PDO::FETCH_ASSOC);

    }
    public function deleteByID($id)
    {
        $this->query = "DELETE FROM `users` WHERE `id` = ?";
        $sth = $this->connection->prepare($this->query);
        return $sth->execute(array($id));


    }
    public function editByID($id, $values)
    {
        $fistName = $values['first_name'];
        $lastName = $values['last_name'];
        $status = $values['status'];
        $role = $values['role'];

        $this->query = "UPDATE `users` SET `first_name`='$fistName',`last_name`='$lastName',`status`='$status',`role`='$role' WHERE `id` IN($id) ";
        $sth = $this->connection->prepare($this->query);
        return $sth->execute(array($id));

    }


    public function getLastID()
    {
        $this->query = "SELECT MAX(id) FROM users";
        $sth = $this->connection->prepare($this->query);
        $sth->execute();
        return $sth->fetch(PDO::FETCH_COLUMN);
    }

    /* Group Actions */

    public function deleteGroupByID($ids)
    {

        $this->query = "DELETE FROM `users` WHERE `id` IN($ids)";
        $sth = $this->connection->prepare($this->query);
        return $sth->execute();


    }
    public function statusGroupByID($ids, $status)
    {
        $this->query = "UPDATE `users` SET `status`='$status' WHERE `id` IN($ids) ";
        $sth = $this->connection->prepare($this->query);
        return $sth->execute();

    }

    /* Group Actions END */



}