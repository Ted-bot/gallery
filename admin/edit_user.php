<?php include("includes/header.php"); ?>
<?php include("includes/photo_library_modal.php"); ?>
<?php 
// check if user is signed in boolean
    if(!$session->is_signed_in()){
        // if not redirect to ..
        redirect("login.php");
    }
?>
<?php 
if(empty($_GET['id'])) {
    redirect("users.php");
} else {
    $user = User::find_by_id($_GET['id']);

    if(isset($_POST['update'])) {
        
        if($user) {
            $user->username = $_POST['username'];
            $user->first_name = $_POST['first_name'];
            $user->last_name = $_POST['last_name'];
            $user->password = $_POST['password'];

            if(empty($_FILES['user_image'])) {
                $user->save();
                // redirect("edit_user.php?id={$user->id}");
                redirect("users.php");
                $session->message("The user has been updated");
            } else {
                $user->set_file($_FILES['user_image']);
                $user->upload_photo();

                $user->save();
                
                // redirect("edit_user.php?id={$user->id}");
                redirect("users.php");
                $session->message("The user has been updated");
            }
        }

    }
}


?>




        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
            <!-- Brand and toggle get grouped for better mobile display -->
            <?php include("includes/top_nav.php"); ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php include("includes/side_nav.php"); ?>

        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            User
                            <small>Edit</small>
                        </h1>

                        <div class="col-lg-6 user_image_box">

                            <a href="" data-toggle="modal" data-target="#photo-library"><img class="user-image-edit " src="<?php echo $user->image_path_and_placeholder(); ?>" alt=""></a>      

                        </div>
                        
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="user_image">image</label>
                                    <input type="file" name="user_image">

                                </div>


                                <div class="form-group">
                                    <label for="username">username</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">

                                </div>
                                
                                <div class="form-group">
                                    <label for="first_name">first name</label>
                                    <input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name; ?>">

                                </div>

                                <div class="form-group">
                                    <label for="last_name">last name</label>
                                    <input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?>">

                                </div>

                                <div class="form-group">
                                    <label for="password" >new password</label>
                                    <input type="password" name="password" class="form-control"  value="<?php echo $user->password; ?>">

                                </div>

                                <div class="form-group">
                                    <a id="user-id" class="btn btn-danger btn-lg" href="delete_user.php?id=<?php echo $user->id; ?>">delete</a>
                                    <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg pull-right">
                                </div> 
                                
                            </div>

                        </form>
                </div>
            </div>
        </div>

<?php include("includes/footer.php"); ?>