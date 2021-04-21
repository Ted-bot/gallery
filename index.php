<?php include("includes/header.php"); ?>
<?php 
// Pagination
// check if param page is not empty if not get param page else 1
$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
// limiter for sql statement
$items_per_page = 4;
// count all items
$items_total_count = Photo::count_all();

$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos ";
$sql .= " LIMIT {$items_per_page} ";
// use paginate->offset to set offset in query
$sql .= " OFFSET {$paginate->offset()}";

$photos = Photo::find_by_query($sql);


// $photos = Photo::find_all(); 

?>

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
                <div class="thumbnail row"> 

                <?php foreach($photos as $photo): ?>
                    
                        <div class="col-xs-6 col-md-3">
                            <a class="thumbnail" href="photo.php?id=<?php echo $photo->id; ?>">
                                <img class="img-responsive home_page_photo" src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                            </a>
                        </div>

                <?php endforeach; ?></div>
            </div>
            

            <!-- paginations -->
            <ul class="pager">
                <!-- check if page has items on the next/previous page else show no next -->
                <?php
                    if($paginate->page_total() > 1){
                        if($paginate->has_next()){
                            echo "<li class='next'><a href='index.php?page={$paginate->next()}'>next</a></li>";
                        }

                        if($paginate->has_previous()){
                            echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>previous</a></li>";
                        }
                    }
                    
                    // check if page total is more/equal to i
                    for($i=1; $i <= $paginate->page_total(); $i++){

                        // if $i is equal to current_page display current page nr
                        if($i == $paginate->current_page){
                            echo "<li><a class='active' href='index.php?page={$i}'>{$i}</a></li>";
                        } else {
                        echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                    }

                    } 
                ?>

            
            </ul>
            

            <!-- Blog Sidebar Widgets Column -->
            <!-- <div class="col-md-4"> -->

            
                 <?php //include("includes/sidebar.php"); ?>



        <!-- </div> -->
        <!-- /.row -->

        <?php include("includes/footer.php"); ?>
