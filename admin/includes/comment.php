<?php

class Comment extends Db_object {

    // Abstracting table makes it reusable inside class
    protected static $db_table = "comments";
    protected static $db_table_fields = array('id', 'photo_id', 'author', 'body');

    // class property 
    public $id;
    public $photo_id;
    public $author;
    public $body;
    

    // class methods

    public static function create_comment($photo_id, $author="user", $body="") {

        // self instantiate comment method
        if(!empty($photo_id) && !empty($author) && !empty($body)){

            $comment = new Comment();
                                    // make sure value is int
            $comment->photo_id  = (int)$photo_id;
            $comment->author    = $author;
            $comment->body      = $body;

            return $comment;
        } else {
            return false;
        }

    }

    // find method o specific id
    public static function find_the_comments($photo_id=0) {
        global $database;

        // use protected static prop to query dynamic
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE photo_id = " . $database->escape_string($photo_id);
        $sql .= " ORDER BY photo_id ASC";

        return self::find_by_query($sql);

    }


} // end of the User class




?>