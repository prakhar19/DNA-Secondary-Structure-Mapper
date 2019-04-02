<?php

session_start();

/**
 * VERIFICATION
 */

if(empty($_GET['id'])) {

    
}

/**
 * END VERIFICATION
 */

require_once('init.php');

$id = $_GET['id'];





$output = $db -> get_row("SELECT * FROM searches WHERE id = $id");

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

</body>
</html>

<?php

?>