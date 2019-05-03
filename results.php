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

$results = json_decode($output -> output);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Results</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script src="main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <!-- Integrative Genomics Viewer (IGV) -->
    <script src="https://cdn.jsdelivr.net/npm/igv@2.2.9/dist/igv.min.js"></script>
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
            <div id="genome-viewer">

            </div>
            <div id="found-sequence-display-legend">
                <strong>Format: </strong>[START_POSITION : END_POSITION] SEQUENCE
            </div>
            <div id="found-sequence-display">
                <?php
                    foreach ($results as $sequence) {
                        $temp = "";
                        $t = str_split($sequence[0]);
                        foreach ($t as $letter) {
                            $temp .= '<span class="' . strtoupper($letter) . '">' . $letter . '</span>';
                        }
                        echo '<span class="individual-sequence"><span class="sequence-length">[<span class="position_start">' . $sequence[1] . '</span>:<span class="position_end">' . ($sequence[1] + strlen($sequence[0])) . '</span>]</span>' . $temp . '</span>';
                    }
                ?>
            </div>
            
            <script>
                var igvDiv = document.getElementById('genome-viewer');
                var options = {
                    reference : {
                        "id" : "<?php echo $output -> input_sequence; ?>",
                        "name" : "<?php echo $output -> input_sequence; ?>",
                        "fastaURL" : "/bioinformatics<?php echo $DATA_DIR . $output -> input_sequence . ".fasta";?>",
                        "indexed" : false,
                        "chromosomeOrder" : "chr",
                    },
                    tracks : [{
                        name : "G-Quadruplex",
                        url : "/bioinformatics<?php echo $RESULT_DIR . $output -> input_sequence . ".bed";?>",
                        indexed : false,
                        format : "bed",
                        visibilityWindow: 1000000000
                    }]
                };

                igv.createBrowser(igvDiv, options).then(
                    function(browser) {
                        console.log("Created");
                    }
                );
            </script>
            <?php
            break;

        case 'created' :
        case 'downloading' :
        case 'searching' :
            ?>
            <script>
                window.location.replace("./progress?id=<?php echo $id; ?>");
            </script>
            <?php
            break;
        
        case 'error' :
            ?>
            <div class="warn"><php echo $output -> output; ?>
            <?php
            break;
    }

    ?>
    </div>
</body>
</html>

<?php

?>