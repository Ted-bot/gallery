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
    }

    // get comment by id realated to the photo_id
    $comments = Comment::find_the_comments($_GET['id']);

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
                            comments
                            <small>Subheading</small>
                        </h1>

                        <!-- <a href="add_comment.php" class="btn btn-primary">Add comment</a> -->
                        
                        <div class="col-md-12">
                        
                            <table class="table table-hover">

                            <?php 
                                // will return all data of the record
                                $comments = Comment::find_all();                           
                            ?>
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Author</th>
                                        <th>Body</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <!-- foreac concatenate / connecting multi strings -> : -->
                                    <?php foreach($comments as $comment) : ?>
                                        <tr>
                                            <td><?php echo $comment->id; ?></td>
                                            <td><?php echo $comment->author; ?>
                                            <div class="action_links">
                                                    <!-- insert param oriented / oop way -->
                                                    <a href="delete_comment_photo.php?id=<?php echo $comment->id ?>">Delete</a>
                                                    <a href="edit_comment.php?id=<?php echo $comment->id ?>">Edit</a>
                                                </div>
                                            </td>                                            
                                            <td><?php echo $comment->body; ?></td>
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