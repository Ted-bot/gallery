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
    redirect("comments.php");
} else {
    $comment = Comment::find_by_id($_GET['id']);

    if(isset($_POST['update'])) {
        
        if($comment) {
            $comment->author = $_POST['author'];
            $comment->body = $_POST['body'];
            $comment->save();
                
            redirect("edit_comment.php?id={$comment->id}");
            }
        }
}

$comment = Comment::find_by_id($_GET['id']);

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
                        
                        <form action="" method="post" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="title">title</label>
                                    <input type="text" class="form-control" name="author" value="<?php echo $comment->author; ?>">
                                </div>

                                <div class="form-group">
                                    <label for="body">Body</label>
                                    <textarea type="text" name="body" class="form-control"><?php echo $comment->body; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <a id="user-id" class="btn btn-danger btn-lg" href="delete_comment.php?id=<?php echo $comment->id; ?>">delete</a>
                                    <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg pull-right">
                                </div> 
                                
                            </div>

                        </form>
                </div>
            </div>
        </div>

<?php include("includes/footer.php"); ?>