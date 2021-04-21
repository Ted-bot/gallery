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
    if(isset($_FILES['file'])) {
        $photo = new Photo();

        $photo->title = $_POST['title'];
        // set file func takes files keys and values
        $photo->set_file($_FILES["file"]);  

        if($photo->save()){
            $message = "Photo upload Succesfully";
        } else {
            // join( $separator, $array)
            $message = join("<br>", $photo->errors);
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
                            Upload
                            <small>Subheading</small>
                        </h1>
                        <div class="col-md-6">
                            <?php echo $message; ?>
                            <form action="" method="post" enctype="multipart/form-data">

                                <!-- div.form-group>ul>li*5 -->
                                <div class="form-group">
                                    <input type="text" name="title" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="file" name="file" style="display: none;">
                                </div>

                                <input type="submit" class="m-3" name="submit">

                            </form>
                        </div>

                    </div>
                </div>
                <!-- /.row -->

                <div class="row my-3">

                    <div class="col-lg-12">
                        <form action="upload.php" id="my-awesome-dropzone" class="dropzone"></form>
                    </div>

                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>