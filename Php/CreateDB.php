<?php


class CreateDB
{
    public $serverName;
    public $userName;
    public $password;
    public $dbName;
    public $tableName;
    public $con;

    // class constructor
    public function __construct(
        $dbName="",
        $tableName= "",
        $serverName="localhost",
        $userName="root",
        $password=""
    )
    {
    $this->dbName = $dbName;
    $this->serverName = $serverName;
    $this->password = $password;
    $this->tableName = $tableName;
    $this->userName = $userName;

    // Create connection.
        $this->con = mysqli_connect($serverName, $userName, $password);

    // Check connection
        if(!$this->con){
            die("Connection failed:".mysqli_connect_error());
        }

    // Query to create database
    $sql = "create database if not exists $dbName";

    // Execute the query
        if(mysqli_query($this->con,$sql)){
          $this->con = mysqli_connect($serverName, $userName, $password, $dbName);

            // SQL to create Table.
            $sql_query = "create table if not exists $tableName
                    (
                        `productID` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
                        `category` varchar(255) NOT NULL,
                        `productName` varchar(255) NOT NULL UNIQUE,
                        `productPrice` float(30) NOT NULL,
                        `productDiscountPrice` float(30) NOT NULL,
                        `productImg` varchar(255) NOT NULL,
                        `productSummary` varchar(1000) NOT NULL,
                        `sellerName` varchar(255) NOT NULL
                    );";
            if (!mysqli_query($this->con, $sql_query)){
                echo "Error creating table: ".mysqli_error($this->con);
            }else{
                return false;
            }
        }
    }

    // Get all the data from the database
    public function getData(){
        $sql_select = "select * from $this->tableName";
        $result = mysqli_query($this->con, $sql_select);

        if(mysqli_num_rows($result) > 0){
            return $result;
        }
    }

}
?>