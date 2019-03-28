<?php

session_start();

$SEARCH_ID = null;

if(isset($_GET['id'])) {
    $SEARCH_ID = $_GET['id'];
} else if(isset($_GET['message'])) {
    
} else {
    die("Invalid Request");
}




/**
 * DATABASE SETUP
 */

// Database config  file
require_once('db-config.php');

/** NOTE: ezSQL needs PHP 7 */
require_once('ezSQL/ez_sql_loader.php');


// Initialise database object and establish a connection
$db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST, DB_CHARSET);

/**
 * END DATABASE SETUP
 */


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