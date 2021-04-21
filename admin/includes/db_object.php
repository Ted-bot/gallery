<?php

class Db_object {
    // Abstracting table makes it reusable inside class
    protected static $db_table = "users";

    public static function find_all(){

        // late static binding -> if used outside class it will reference to this function
        // use key word static makes the class method usable in othes classes
        return static::find_by_query("SELECT * FROM ". static::$db_table . "");
    }

    // get user Id
    public static function find_by_id($id){
        // use method from database class that is public
        // call $database inside database.php with global
        global $database;

        // oriented basic
        // $result_set = $database->query("SELECT * FROM table WHERE id='" . $user_id . "' LIMIT 1 ");

        //oriented static 
        // get all data out of database and use func instantiate to assign data to user object/ class
        $the_result_array = static::find_by_query("SELECT * FROM ". static::$db_table ." WHERE id='". $id ."' LIMIT 1");

        // use ternary method/ operator to check if id exist
        // ?(compare) between element/methods or : (else) return false
        // array_shift($array) shifts the first value of the array off and returns it,
        // -> shortening the array by one element and moving everything down. 
        // -> first value is the id
        return !empty($the_result_array) ? array_shift($the_result_array) :false;

    }

    public static function find_by_query($sql){
        global $database;

        $result_set = $database->query($sql);

        // the empty array to put in objects
        $the_object_array = array();
        
        // fetch database table from resul_set 
        while($row = mysqli_fetch_array($result_set)) {
            // use instantation method and loop through columns in record and assign them to object properties
            $the_object_array[] = static::instantiation($row);
        }

        return $the_object_array;
    }

    // assigns array from form/page to class/object props
    public static function instantiation($the_record){
        // retrieve string with the name of the called class and static:: introduces its scope
        $calling_class = get_called_class();

        $the_object = new $calling_class;

        // dynamic way
        // get the_record from the database-> table
        foreach ($the_record as $the_attribute => $value){

            // check the record object has a attribute 
            // if with class function has_the_attribute
            if ($the_object->has_the_attribute($the_attribute)){
                // if the the_attribute is ok assign $value
                $the_object->$the_attribute = $value;

            }
        }
        return $the_object;

    }
    
    private function has_the_attribute($the_attribute){
        // pre defined func get all the properties of current class even if its private
        $object_properties = get_object_vars($this);

        // look if key exist
        // pre defined func array_key_exist needs two elements to compare
        // if the_attribute key matches with a element inside object_properties (class properties e.g. id, username etc.)
        return array_key_exists($the_attribute, $object_properties);
    }

    // abstraction

    // abstracting properties
    protected function properties(){
        // get properties of current class
        // return get_object_vars($this);

        $properties = array();
        // $db_table_fields is a static protected variable
        foreach(static::$db_table_fields as $db_field){
            
            //  Checks if the object or class has a properties of item $db_field
            if(property_exists($this, $db_field)) {
                // if true get property from class and assign it to array $properties
                $properties[$db_field] = $this->$db_field;
            }
        }
        // always return someting to get something from function
        return $properties;
    }

    // cleaning/ sanitizing inserted properties before use, like CRUD
    protected function clean_properties(){
        // use global variable inside class
        global $database;

        // contain sanitized values
        $clean_properties = array();

        // loop through properties for sanitizing
        foreach($this->properties() as $key => $value) {
            //  after value sanitized with database func insert it to $clean_properties
            // set key (contain property name) inside array to prevent nummeric key of set value (0, 1, 2 etc..)
            $clean_properties[$key] = $database->escape_string($value);
        }

        return $clean_properties;
    }

    // CRUD 

    // simplefied CRUD methods
    // save uploaded data
    public function save() {
        // check current id is set if not create new row
        return isset($this->id) ? $this->update() : $this->create();
    }

    // create: new row
    public function create() {
        // to make call to database
        global $database;

        // get all class properties
        $properties = $this->clean_properties();

        // abstracting class properties to dynamically make query 
        // func implode : Join array elements with a string
        // func array_keys : Return all the keys or a subset of the keys of an array
        $sql = "INSERT INTO " . static::$db_table ."(". implode(",", array_keys($properties)) .")";
        // implode inside values parentheses, insert between array values ',' which is needed for query
        $sql .= " VALUES ('" .implode("','", array_values($properties)) ."')";

        // check if upload to database succeeded
        if ($database->query($sql)){

            // database method gets the new id of the last query($sql)
            $this->id = $database->the_insert_id();

            return true;
        } else {
            return false;
        }

    }

    // update: current row
    public function update() {
         // to make call to database
         global $database;

        $properties = $this->clean_properties();
        // contain all pair of keys (column names) and values for update
        $properties_pairs = array();

        // loop through class properties and set form values ready for update
        foreach( $properties as $property => $value){
            // put all pairs inside properties_pairs array that will contain all pairs
          $properties_pairs[] = "{$property}='{$value}'";  
        }

        // dynamic oriented way of updating
        $sql = "UPDATE ". static::$db_table . " SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= "WHERE id=" . $database->escape_string($this->id);

         // check if upload to database succeeded
         $database->query($sql);
        
        //  Returns the number of rows affected by the last INSERT, UPDATE, REPLACE or DELETE query
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    // delete current row
    public function delete() {
        // to make call to database
        global $database;

        // oriented way of deleting
        $sql = "DELETE FROM ". static::$db_table . " ";
        // escape value just in case there sql injection
        $sql .= "WHERE id=" . $database->escape_string($this->id) . " ";
        $sql .= "LIMIT 1";

        // check if upload to database succeeded
        $database->query($sql);
       
       //  Returns the number of rows affected by the last INSERT, UPDATE, REPLACE or DELETE query
       return (mysqli_affected_rows($database->connection) == 1) ? true : false;
   }

    //    count id of from table
   public static function count_all() {
        global $database;

        //    first get table
       $sql = "SELECT COUNT(*) FROM " . static::$db_table;

       $result_set = $database->query($sql);

       $row = mysqli_fetch_array($result_set);
        
       // return first element of array -> id 
       return array_shift($row);
   }

}





?>