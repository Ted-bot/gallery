<?php 

// require_once("config.php");

class Database {
    // make connection available to other classes
    public $connection;

    // initialize when database class used
    function __construct(){
        //call open connection
        $this->open_db_connection();

    }

    // function is publicly available
    public function open_db_connection(){

        // refer to this class connection -> procedural way
        // $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // refer to this class connection -> oriented way
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // when error occurs during attempt of database connection
        // if(mysqli_connect_errno()){

        // when error occurs during attempt of database connection
        // using connect_errno is a build in function from mysqli
        if($this->connection->connect_errno){   
            // exit with message and error
             // using connect_errno is a build in function from mysqli
            die("Database connection failed badly!" . $this->connection->connect_error);
        }
    }

    // function makes query
    public function query($sql) {
        // result makes connection to database and search query
        // procedural way
        // $result = mysqli_query($this->connection, $sql);

        // oriented way
        $result = $this->connection->query($sql);

        // check query fails
        $this->confirm_query($result);

        // return back
        return $result;
    }

    // check is query fails not available outside class
    private function confirm_query($result){
        if(!$result){
            die("Query failed " . $this->connection->error);
        }
    }

    // escape/sanitize strings before it enters the database
    public function escape_string($string){
        // procedural way
        // $escaped_string = mysqli_real_escape_string($this->connection, $string);

        // oriented way
        $escaped_string = $this->connection->real_escape_string($string);

        return $escaped_string;
    }

    // return the new generated inserted id 
    public function the_insert_id(){
        // The mysqli_insert_id() function returns the auto generated id of the last executed query
        return mysqli_insert_id($this->connection);
    }

    // escape strings when uploading data to database
    public function the_inserted_id(){
        return $this->connection->insert_id;
    }

}

// outside class
$database = new Database();

// $database->open_db_connection();



?>