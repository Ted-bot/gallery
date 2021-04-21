<?php

    require("init.php");

    $user = new User();


    if(isset($_POST['image_name'])) {
        // upload new image
        $user->ajax_save_user_image($_POST['image_name'], $_POST['user_id']);
    }

    if(isset($_POST['photo_id'])) {
        // load sidebar
        Photo::display_sidebar_data($_POST['photo_id']);
        // echo "work";
    }

?>