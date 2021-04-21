<?php include("includes/header.php"); ?>

<?php 
// check if user is signed in boolean
    if(!$session->is_signed_in()){
        // if not redirect to ..
        redirect("login.php");
    }
?>
<?php 
if(empty($_GET['id'])) {
    redirect("photos.php");
} else {
    $photo = Photo::find_by_id($_GET['id']);

    if(isset($_POST['update'])) {
        
        if($photo) {
            $photo->title = $_POST[ 'title'];
            $photo->caption = $_POST[ 'caption'];
            $photo->alternate_text = $_POST[ 'alternate_text'];
            $photo->description = $_POST[ 'description'];

            $photo->save();
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
                        
                        <form action="edit_photo.php?id=<?php echo $photo->id; ?>" method="post">
                            <div class="col-lg-8">
                            <div class="form-group">
                                    <label for="caption">Title</label>
                                    <input type="text" name="title" class="form-control" value="<?php echo $photo->title; ?>">

                                </div>

                                <div class="form-group">
                                    <!-- picture path is photo class function gets image full path -->
                                    <a href="" class="thumbnail" ><img src="<?php echo $photo->picture_path(); ?>" alt=""></a>
                                </div>

                                <div class="form-group">
                                    <label for="caption">Captions</label>
                                    <input type="text" name="caption" class="form-control" value="<?php echo $photo->caption; ?>">

                                </div>

                                <div class="form-group">
                                    <label for="alternate_text" >Alternate text</label>
                                    <input type="text" name="alternate_text" class="form-control"  value="<?php echo $photo->alternate_text; ?>">

                                </div>

                                <div class="form-group">
                                    <label for="caption">Description</label>
                                    <textarea type="text" name="description" id="" cols="30" rows="10" class="form-control"><?php echo $photo->description; ?></textarea>
                                </div>
                                
                            </div>
                            <!-- /.row -->

                            
                            <div class="col-md-4" >

                                <div  class="photo-info-box">
                                    <div class="info-box-header">
                                        <h4>Save <span id="toggle" class="glyphicon glyphicon-menu-up pull-right"></span></h4>
                                    </div>
                                    
                                    <div class="inside">
                                        <div class="box-inner">
                                            <p class="text">
                                            <span class="glyphicon glyphicon-calendar"></span> Uploaded on: April 22, 2030 @ 5:26
                                            </p>
                                            <p class="text ">
                                                Photo Id: <span class="data photo_id_box">34</span>
                                            </p>
                                            <p class="text">
                                                Filename: <span class="data">image.jpg</span>
                                            </p>
                                            <p class="text">
                                            File Type: <span class="data">JPG</span>
                                            </p>
                                            <p class="text">
                                            File Size: <span class="data">3245345</span>
                                            </p>
                                        </div>

                                        <div class="info-box-footer clearfix">
                                            <div class="info-box-delete pull-left">
                                                <a  href="delete_photo.php?id=<?php echo $photo->id; ?>" class="btn btn-danger btn-lg ">Delete</a>   
                                            </div>
                                            <div class="info-box-update pull-right ">
                                                <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg ">
                                            </div> 
                                        </div>
                                    </div> 
                                </div> 

                            </div>

                        </form>
                </div>
            </div>
        </div>

<?php include("includes/footer.php"); ?>