<?php
//session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sequence Searcher</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>
    <!-- Top Header -->
    <?php require_once('inc/header.php'); ?>

    <div id="main">
        <form id="input-sequence-form" action="submit" method="post">
            <div id="input-sequence-block">
                <label for="sequence-input">Input Sequence :</label>
                <textarea id="sequence-input" name="sequence" rows="10" cols="100"></textarea>
                <input name="id" value="<?php //echo session_id(); ?>" type="hidden">
                <div class="note"><strong>Note:</strong> For custom sequences, maximum length is 16,777,215 base pairs. For longer sequences, use NCBI Gene Id or Accession No.</div>
            </div>
            
            <input type="submit">
        </form>
    </div>

    <footer>

    </footer>
</body>
</html>