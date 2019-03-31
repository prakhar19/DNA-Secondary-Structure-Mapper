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
$error_msg = '';


if(isset($_GET['error'])) {
    switch($_GET['error']) {
        case 'info_fetch' :
            $error_msg = "Could not fetch details of the sequence from NCBI.";
            break;

        case 'download' :
            $error_msg = "Could not download the sequence from NCBI.";
            break;

        case 'download_size' :
            $error_msg = "Sequence to be downloaded is greater than " . MAX_DOWNLOAD_SIZE_STRING . ".";
            break;
    }
}
echo $error_msg;

if(isset($_GET['id'])) {
    $SEARCH_ID = $_GET['id'];
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