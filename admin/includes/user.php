<?php

class User extends Db_object{

    // Abstracting table makes it reusable inside class
    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image');

    // class property 
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public $user_image;
    public $type;
    public $size;
    public $tmp_path;

    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/400x400&text=image";

     // use when error occurs when path when try to move file 
     public $errors = array();
     // usse for $_FILES[name][error] to see which error occurs
     public $upload_errors_array = array(
         UPLOAD_ERR_OK => 'There is no error, the file uploaded with success',
         UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
         UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
         UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
         UPLOAD_ERR_NO_FILE => 'No file was uploaded',
         UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
         UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
         UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
     );
    

    // class methods

    // insert place holder inside image if user_image is empty
    public function image_path_and_placeholder(){
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory . DS . $this->user_image;
    }

    public static function verify_user($username, $password) {
        // use global variable object
        global $database;

        // use database global object/class method to sanitize strings
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        // query request to check username and password
        $sql = "SELECT * FROM users WHERE ";
        $sql .= "username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";

        // oriented static way
        // get all data of user by user id
        $the_result_array = self::find_by_query($sql);

        // use ternary method/ operator to check if user id exist
        // ?(compare) between element/methods or : (else) return false
        return !empty($the_result_array) ? array_shift($the_result_array) :false;

    }

    // This is passing $_FILES['upload_file] as an argument
    public function set_file($file){
        // before doing anything check the file for errors
        if(empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded here";
            // stap stop function and return false if error occurs
            return false;
        // if the file error doesnt match 0 means that there is an error
        } elseif($file['error'] != 0 ) {
            // assign exact error by passing file[error] to upload_errors_array to get exact error
            $this->errors[] = $this->upload_errors_array[$file['error']];
            // return false
            return false;
        } else {
            // assign inserted file values to class properties

            // The basename() function in PHP is an inbuilt function
            // which is used to return the base name of a file if the path
            // of the file is provided as a parameter to the basename()
            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];
        }
    }

    public function upload_photo() {
            
            if(!empty($this->errors)){
                return false;
            }

            if(empty($this->user_image) || empty($this->tmp_path)){
                $this->errors[] = "the file was not available";
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;

            // 
            if(file_exists($target_path)){
                $this->errors[] = "The file {$this->user_image} already exist";
                return false;
            }
            
            if(move_uploaded_file($this->tmp_path, $target_path)){
                if($this->id) {
                    $this->update();
                    } elseif($this->create()) {
                    unset($this->tmp_path);
                    return true;
                    
                    }

            } else {
                $this->errors[] = "The file directory does not have permission!";
            }

    } 


    public function delete_user() {
        if($this->delete()){

            // set path to file
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->user_image;


            // delete img from file - ternary operator
            return unlink($target_path) ? true : false;

        } else {

            return false;
        }
    }

    // update data
    public function ajax_save_user_image($user_image, $user_id){
        global $database;

        // sanitize new items with class database func esc_str
        $user_image = $database->escape_string($user_image);
        $user_id = $database->escape_string($user_id);

        // set new items and id ready for upload
        $this->user_image = $user_image;
        $this->id = $user_id;

        // 
        $sql = "UPDATE ". self::$db_table;
        $sql .= " SET user_image = '{$this->user_image}' ";
        $sql .= "WHERE id = {$this->id}";

        $update_image = $database->query($sql);

        echo $this->image_path_and_placeholder();
        // $this->save();
    }


} // end of the User class




?>