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

        case 'download_size' :
            $error_msg = "Sequence to be downloaded is greater than " . MAX_DOWNLOAD_SIZE_STRING . ".";
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