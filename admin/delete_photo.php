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
        redirect("../photos.php");
    }

    $photo = Photo::find_by_id($_GET['id']);

    if($photo){
        $photo->delete_photo();
        redirect("../photos.php");
    } else {
        redirect("../photos.php");
    }


?>