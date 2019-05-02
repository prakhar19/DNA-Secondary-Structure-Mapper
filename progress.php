<?php

session_start();

/**
 * VERIFICATION
 */



/**
 * END VERIFICATION
 */


require_once('init.php');



if(isset($_GET['error'])) {
    switch($_GET['error']) {
        case 'invalid_seq' :
            $error_msg = "Enter a valid sequence, NCBI Gene Id or NCBI Accession No.";
            break;

        case 'invalid_request' :
            $error_msg = "Invalid Request";
            break;
    } ?>
    <div class="error-box"><?php echo $error_msg; ?></div>
    <?php
}


if(empty($_GET['id'])) {
    die("Invalid Request");
}

$id = $_GET['id'];



$results = $db -> get_row("SELECT * FROM searches WHERE id = $SEARCH_ID");

$status = strtolower($results -> status);
switch($status) {
    case 'finished' :

        break;

    case 'created' :

        break;
    
    case 'error' :

        break;
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Progress</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>
    <!-- Top Header -->
    <?php require_once('inc/header.php'); ?>

    <div id="main">
    
    </div>

    <footer>

    </footer>
</body>
</html>