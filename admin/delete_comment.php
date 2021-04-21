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
        redirect("comments.php");
    }

    $comment = Comment::find_by_id($_GET['id']);

    if($comment){
        $comment->delete();
        redirect("comments.php");
    } else {
        redirect("comments.php");
    }


?>