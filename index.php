<?php
session_start();

echo(session_id() . " ");

//redirect();
//exit();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Secondary Structure Identifier</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
</head>
<body>
    <header>

    </header>

    <div id="main">
        <form action="submit" method="post">
            <textarea id="sequence-input" name="sequence" rows="15" cols="80"></textarea>
            <input name="id" value="<?php echo session_id(); ?>" type="hidden">
            <input type="submit">
            <div class="note">For custom sequences, maximum length is 16,777,215 base pairs. For longer sequences, use NCBI Gene Id or Accession No.</div>
        </form>
    </div>

    <footer>

    </footer>
</body>
</html>