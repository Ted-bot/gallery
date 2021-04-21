<?php
// session be available anywhere in the app to check if user logged in
class Session {
    // private -> only available inside class, only a method can access property
    private $signed_in = false;
    // public because useful for other things
    public $user_id;

    // output changes to session class
    public $message;

    // keep track
    public $count;

    // use construct to auto start the following...
    function __construct(){
        // start session
        // session remembers inserted key and value
        session_start();    

        // check visitor count inside admin
        $this->visitor_count();

        // auto check user logged in
        $this->check_the_login();
        // check message when signed in
        $this->check_message();
    }

    // message for user
    // set msg str to empty if value is empty
    public function message($msg="") {
        if(!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            // return current message
            return $this->message;
        }
    }

    // check if a messag is set
    public function check_message() {
        // if there is a message stored in session
        if(isset($_SESSION['message'])) {
            // assign session message in class prop message
            $this->message = $_SESSION['message'];
            // unset to clear session message
            unset($_SESSION['message']);
        } else {
            // if no message stored make string empty
            $this->message = "";
        }
    }

    // admin index
    public function visitor_count() {

        if(isset($_SESSION['count'])){

            return $this->count = $_SESSION['count']++;


        } else {
            return $_SESSION['count'] = 1;
        }

    }



    // getter -> return if user signed in
    public function is_signed_in(){
        // return private prop/ getter function
        return $this->signed_in;
    }

    //  sign in user when inserted data is true
    public function login($user){
        if($user){
            // basically assigning two thing two the current class prop
            // gettin user id from user class
            $this->user_id = $_SESSION['user_id'] = $user->id;

            // when user_id is assigned a user->id set signed in to true
            $this->signed_in = true;
        }
    }

    public function logout() {

        // clear sessin user_id and public prop 
        unset($_SESSION['user_id']);
        unset($this->user_id);

        // set private singed_in prop to as false
        $this->signed_in = false;

    }
    
    // function only available inside this class
    private function check_the_login(){

        if(isset($_SESSION['user_id'])){

            // insert session user_id into class prop
            $this->user_id = $_SESSION['user_id'];

            // private prop set to true if user_id is set
            $this->signed_in = true;
        } else {
            // clear property user_id with unset
            unset($this->user_id);

            // set private prop to false
            $this->signed_in = false;

        }

    }

}
// closed class

// make session avaiable outside class as variable
$session = new Session();
$message = $session->message();


?>