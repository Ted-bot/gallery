<?php

class Photo extends Db_object {

    // Abstracting table makes it reusable inside class
    protected static $db_table = "photos";
    protected static $db_table_fields = array('id', 'caption', 'title', 'description', 'filename', 'alternate_text', 'type', 'size');

    // class property 
    public $alternate_text;
    public $caption;
    public $id;
    public $title;
    public $description;
    public $filename;
    public $type;
    public $size;

    public $tmp_path;
    public $upload_directory = "images";
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
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];
        }
        
    }


    public function save() {

        if($this->id) {

            $this->update();

        } else {
            
            if(!empty($this->errors)){
                return false;
            }

            if(empty($this->filename) || empty($this->tmp_path)){
                $this->erros[] = "the file was not available";
                return false;
            }

            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->upload_directory . DS . $this->filename;

            // 
            if(file_exists($target_path)){
                $this->errors[] = "The file {$this->filename} already exist";
                return false;
            }
            
            if(move_uploaded_file($this->tmp_path, $target_path)){
                if($this->create()){
                    // clear temp_path
                    unset($this->temp_path);
                    return true;
                }

            } else {
                $this->errors[] = "The file directory does not have permission!";
            }

        }

    }   

    // get upload directory with image file
    public function picture_path(){
        return $this->upload_directory . DS . $this->filename;
    }

    public function delete_photo() {
        if($this->delete()){

            // set path to file
            $target_path = SITE_ROOT . DS . 'admin' . DS . $this->picture_path();


            // delete img from file - ternary operator
            return unlink($target_path) ? true : false;

        } else {

            return false;
        }
    }

    public static function display_sidebar_data($photo_id){

        $photo = Photo::find_by_id($photo_id);
        // display object prop
        $output = "<a class='thumbnail' href='#'><img width='100' src='{$photo->picture_path()}' alt=''></a>";
        $output .= "<p>{$photo->filename}</p>";
        $output .= "<p>{$photo->type}</p>";
        $output .= "<p>{$photo->size}</p>";

        echo $output;
    }

}


?>