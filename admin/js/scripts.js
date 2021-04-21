$(window).on('load', function(){

    let user_href;
    let user_href_splitted;
    let user_id;
    let image_src;
    let image_href_splitted;
    let image_name;
    let photo_id;

    $(".modal_thumbnails").on("click", function(){
        // get id and set prop disabled to false
        $("#set_user_image").prop("disabled", false);

        // get href prop from id user-id
        user_href = $("#user-id").prop('href');
        // split equal sign (=) from the url 
        user_href_splitted = user_href.split("=");
        // get user id
        // of the href prop get second value by reducing with one
        user_id = user_href_splitted[user_href_splitted.length - 1];
        
        //  this refers to the item that is being clicked on
        image_src = $(this).prop("src");
        image_href_splitted = image_src.split("/");
        image_name = image_href_splitted[image_href_splitted.length - 1];

        // get attr data to get photo_id
        photo_id = $(this).attr("data");

        $.ajax({
            url: "includes/ajax_code.php",
            data:{photo_id: photo_id},
            type: "POST",
            success: function(data){
                // if there is an error
                if(!data.error){
                    // insert data into side_bar
                    $("#modal_sidebar").html(data);
                    // console.log("data: ", data);

                }
            }
        });
    });

    $("#set_user_image").on("click", function(){
        // ajax call to update server with new post(s)
        $.ajax({
            url: "includes/ajax_code.php",
            data:{image_name: image_name, user_id: user_id},
            type: "POST",
            success: function(data){
                // if there is an error
                if(!data.error){
                    // reload so user can see image immediately
                    // location.reload();

                    // replace image by replace src value with value od data
                    $(".user_image_box a img").prop('src', data);

                }
            }
        });
    });

});

// slide function for edit_photo info-box-header
$(".info-box-header").on("click", function(){
    // toggle effect
    $(".inside").slideToggle("fast");
    // toggle for smoothe transition
    ("#toggle").toggleClass("glyphicon-menu-down, glyphicon glyphicon-menu-up")
})

// delete function
$(".delete_link").on("click", function(){
    return confirm("are you sure you want to delete this item");
})