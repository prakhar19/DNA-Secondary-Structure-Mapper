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
    <title>Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>

    <!-- Integrative Genomics Viewer (IGV) -->
    <script src="https://cdn.jsdelivr.net/npm/igv@2.2.9/dist/igv.min.js"></script>
</head>
<body>
    <!-- Top Header -->
    <?php require_once('inc/header.php'); ?>

    <div id="genome-viewer">

    </div>
    <script>
        var igvDiv = document.getElementById('genome-viewer');
        var options = {
            reference : {
                "fastaURL" : "/bioinformatics<?php echo $DATA_DIR . $output -> input_sequence . ".fasta";?>",
                "indexed" : false
            },
            locus : "",
            /*tracks : [{
                "name" : "HG00103",
                "url" : "<?php echo $DATA_DIR . $output -> input_sequence . ".fasta";?>",
                "indexURL" : "",
                "format" : "fasta"
            }]*/
        };

        igv.createBrowser(igvDiv, options).then(
            function(browser) {
                console.log("Created");
            }
        );
    </script>
</body>
</html>

<?php

?>