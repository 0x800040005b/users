<?php


class DB
{
    private $servername;
    private $dbname;
    private $username;
    private $password;
    private $connection;



    public function __construct($servername, $dbname, $username, $password)
    {
        if (is_null($this->connection)) {
            $this->servername = $servername;
            $this->dbname = $dbname;
            $this->username = $username;
            $this->password = $password;
            try {
                $this->connection = new PDO('mysql:dbname='.$dbname.';host='.$servername, $username, $password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//                echo "connected successfully";

            } catch (PDOException $PDOException) {
                echo "connection failed.";
                $this->disconnect();
                die;

            }
        }
    }

    /**
     * @return PDO
     */
    public function getConnection(){
        if(!is_null($this->connection)) {
            return $this->connection;
        }
    }


    public function disconnect()
    {
        $this->connection = null;
    }

}