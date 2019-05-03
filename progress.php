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


$output = $db -> get_row("SELECT * FROM searches WHERE id = $id");
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
    <?php
    $status = strtolower($output -> status);
    switch($status) {
        case 'finished' :
            ?>
            <script>
                window.location.replace("./results?id=<?php echo $id; ?>");
            </script>
            <?php
            break;

        case 'created' :
        case 'downloading' :
        case 'searching' :
            ?>
            <div id="progress-box">
                <table>
                    <tr>
                        <td><label><strong>Search ID:</strong></label></td>
                        <td><span><?php echo $id; ?></span></td>
                    </tr>
                    <tr>
                        <td><label><strong>Status:</strong></label></td>
                        <td><?php echo $output -> status; ?></span></td>
                    </tr>
                    <tr>
                        <td><label><strong>Time taken:</strong></label></td>
                        <td><span id="minutes"><?php echo (int)((time() - strtotime($output -> creation_time)) / 60);?></span>:<span id="seconds"><?php echo (time() - strtotime($output -> creation_time)) % 60; ?></span></td>
                    </tr>
                </table>
            </div>
            <div class="note"><strong>Note:</strong> The page automatically refreshes every 5 seconds.</div>

            <script>
                var minutesLabel = document.getElementById("minutes");
                var secondsLabel = document.getElementById("seconds");
                var totalSeconds = <?php echo time() - strtotime($output -> creation_time); ?>;
                setInterval(setTime, 1000);

                function setTime() {
                    ++totalSeconds;
                    secondsLabel.innerHTML = pad(totalSeconds % 60);
                    minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
                }

                function pad(val) {
                    var valString = val + "";
                    if (valString.length < 2) {
                        return "0" + valString;
                    } else {
                        return valString;
                    }
                }

                var startSeconds = 0;
                function reloadPage() {
                    ++startSeconds;
                    if(startSeconds >= 5) {
                        location.reload();
                    }
                }
                setInterval(reloadPage, 1000);
                </script>
            <?php
            break;
        
        case 'error' :
            ?>
            <script>
                window.location.replace("./results?id=<?php echo $id; ?>");
            </script>
            <?php
            break;
        
        default :
            ?>
            <script>
                window.location.replace("./results?id=<?php echo $id; ?>");
            </script>
            <?php
    }

    ?>
    </div>

    <footer>

    </footer>
</body>
</html>