<?php include("includes/header.php"); ?>

<?php 
// check if user is signed in boolean
    if(!$session->is_signed_in()){
        // if not redirect to ..
        redirect("login.php");
    }
?>
<?php
    $message = "";
    if(isset($_POST['create'])) {

        $user = new User();
        
        if($user) {
            // load submitted form to class properties
            $user->username = $_POST['username'];
            $user->first_name = $_POST['first_name'];
            $user->last_name = $_POST['last_name'];
            $user->password = $_POST['password'];

            $user->set_file($_FILES['user_image']);

            if($user->upload_photo()){
                $message = "Upload Succesfully";
            } else {
                // join( $separator, $array)
                $message = join("<br>", $user->errors);
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
                            Edit
                            <small>Subheading</small>
                        </h1>
                        <?php echo $message; ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-lg-6 col-lg-offset-3">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control">
                                </div>

                                <div class="form-group">
                                    <!-- picture path is photo class function gets image full path -->
                                    <label for="user_image"></label>
                                    <input type="file" name="user_image">
                                </div>

                                <div class="form-group">
                                    <label for="first_name">first name</label>
                                    <input type="text" name="first_name" class="form-control" >

                                </div>

                                <div class="form-group">
                                    <label for="last_name" >last name</label>
                                    <input type="text" name="last_name" class="form-control" >

                                </div>

                                <div class="form-group">
                                    <label for="password">password</label>
                                    <input type="password" name="password" class="form-control" >
                                </div>

                                <div class="info-box-update pull-right">
                                    <input type="submit" name="create" class="btn btn-primary pull-right">
                                </div> 
                                
                            </div>
                        </form>
                </div>
            </div>
        </div>

<?php include("includes/footer.php"); ?>