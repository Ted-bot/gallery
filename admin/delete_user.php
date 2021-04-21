<?php include("includes/header.php"); ?>

<?php 
// check if user is signed in boolean
    if(!$session->is_signed_in()){
        // if not redirect to ..
        redirect("login.php");
    }
?>
<?php

    if(empty($_GET['id'])){
        redirect("../users.php");
    }

    $user = User::find_by_id($_GET['id']);

    if($user){

        $session->message("User {$user->username} has been deleted!");

        $user->delete_user();
        redirect("../users.php");
    } else {
        redirect("../users.php");
    }


?>