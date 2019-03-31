<?php

session_start();

/**
 * VERIFICATION
 */



/**
 * END VERIFICATION
 */


require_once('config.php');
require_once('functions.php');




$SEARCH_ID = null;

if(isset($_GET['id'])) {
    $SEARCH_ID = $_GET['id'];
} else if(isset($_GET['message'])) {
    
} else {
    die("Invalid Request");
}



$db = database_init();


$results = $db -> get_row("SELECT * FROM searches WHERE id = $SEARCH_ID");




?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <header>
    <div id="logo"></div>
    </header>

    <div id="main">
    
    </div>

    <footer>

    </footer>
</body>
</html>