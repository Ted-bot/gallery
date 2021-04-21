<?php include("includes/header.php"); ?>

<?php 
// check if user is signed in boolean
    if(!$session->is_signed_in()){
        // if not redirect to ..
        redirect("login.php");
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
                            Photos
                            <small></small>
                        </h1>
                        
                        <div class="col-md-12">
                        
                            <table class="table table-hover">

                            <?php 
                                // will return all data of the record
                                $photos = Photo::find_all();                           
                            ?>
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Id</th>
                                        <th>file Name</th>
                                        <th>Title</th>
                                        <th>Size</th>
                                        <th>comments</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <!-- foreac concatenate / connecting multi strings -> : -->
                                    <?php foreach($photos as $photo) : ?>
                                        <tr>
                                            <td><img class="admin-user-thumbnail" src="<?php echo $photo->picture_path(); ?>" alt="" >

                                                <div class="action_links">
                                                    <!-- insert param oop way -->
                                                    <a class="delete_link" href="delete_photo.php/?id=<?php echo $photo->id ?>">Delete</a>
                                                    <a href="edit_photo.php?id=<?php echo $photo->id ?>">Edit</a>
                                                    <a href="../photo.php?id=<?php echo $photo->id ?>">View</a>
                                                </div>
                                            
                                            </td>
                                            <td><?php echo $photo->id; ?></td>
                                            <td><?php echo $photo->filename; ?></td>
                                            <td><?php echo $photo->title; ?></td>
                                            <td><?php echo $photo->size; ?></td>
                                            <th>
                                                <a href="photo_comment.php?id=<?php echo $photo->id; ?>">
                                                    <?php 
                                                    
                                                    $comments = Comment::find_the_comments($photo->id); 
                                                    // count amout of comments
                                                    echo count($comments);

                                                    ?>       
                                                </a>                                     
                                            </th>
                                        </tr>
                                    <!-- foreach ending concatenation -->
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>