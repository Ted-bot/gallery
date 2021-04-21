<!-- turn output buffering on used for redirection -->
<?php
    // already inside login.php
    ob_start(); 
    require_once("init.php"); 
    
    // check if user is signed in boolean
    // if(!session->is_signed_in){
        // if not redirect to ..
    //     redirect("login.php");
    // }
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Bootstrap Admin Template</title>

    <!-- Bootstrap Core CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"> -->

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Dropzone -->
    <link href="css/dropzone.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="css/style.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- WYSIWYG EDITOR -->
    <script src="https://cdn.tiny.cloud/1/aufvc277h1f0jxotagu7oh8kcvm0fr7rk2btdjcg809ako7c/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</head>

<body>

    <div id="wrapper">