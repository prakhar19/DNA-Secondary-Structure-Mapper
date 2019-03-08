<?php
session_start();

var_dump($_SESSION);
var_dump($_POST);
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
        </form>
    </div>

    <footer>

    </footer>
</body>
</html>