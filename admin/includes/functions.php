<?php 

//  using an anonymous function
//  auto load classes by searching for classes through file names inside includes
function classAutoLoader($class) {
    // search for file * CREATE CLASS FILES WITH LOWER CASE *
    $class = strtolower($class);
    // the path dynamically search for loaded class through includes file
    $the_path = "includes/{$class}.php";
     
    // if(file_exists($the_path)){
    //     require_once($the_path);
    // } else {
    //     die("this file name {$class}.php is not found man...!");
    // }

    // using build in functions
    if(is_file($the_path) && !class_exist($class)){
        include $the_path;
    }

}

// spl_autoload_register() allows multiple autoload functions 
// It effectively creates a queue of autoload functions, 
// and runs through each of them in the order they are defined
// put in function name with quotes
spl_autoload_register("classAutoLoader");

function redirect($location){
    header("Location: {$location}");
}


?>