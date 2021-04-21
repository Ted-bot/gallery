<?php require_once("includes/header.php"); ?>
<?php

// ob_start(); 
// contains all classes
// require_once("init.php"); 
// check if is user is signed in with getter 
global $session;

if($session->is_signed_in()){
    // use public func redirect
    redirect("index.php");
}

// check login form submitted
if(isset($_POST['submit'])){

    // Strip whitespace (or other characters) from the beginning and end of a string's submitted
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    //check inserted username and password submitted inside database
    $user_found = User::verify_user($username, $password);

    // check if user is verified
    if($user_found){
        // sign user in
        $session->login($user_found);
        redirect("index.php");

    } else {

        $the_message = "Your password or username are incorrect";

    }
} else {
    // prevent undefined variable error by unsetting variable to empty string
    $the_message = "";
    $username= "";
    $password = "";
}



?>


<div class="col-md-4 col-md-offset-3">

<h4 class="bg-danger"><?php if (isset($the_message)) {echo $the_message;} ?></h4>
	
<form id="login-id" action="" method="post">
	
<div class="form-group">
	<label for="username">Username</label>
	<input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >

</div>

<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
	
</div>


<div class="form-group">
<input type="submit" name="submit" value="Submit" class="btn btn-primary">

</div>


</form>


</div>