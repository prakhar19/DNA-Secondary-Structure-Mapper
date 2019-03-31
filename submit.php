<?php

session_start();


/** 
 * VERIFICATION
 * 
 * - Prevention against spamming of search requests
 * 
 */

if(!isset($_POST['sequence']) || empty($_POST['sequence'])) {
    // Redirect
    header('Location: progress?error=invalid_seq');
    exit();
}

if(!isset($_POST['id']) || $_POST['id'] !== session_id()) {
    redirect('Location: progress?error=invalid_request');
    exit();
}

/**
 * END VERIFICATION
 */


/**
 * SETUP, INCLUDES & DEFINITIONS
 */

ignore_user_abort(true);
ini_set('memory_limit', '4000M');
//set_time_limit(0);

require_once('config.php');
require_once('functions.php');
require_once('sequence-search.php');

$DATA_DIR = "/Data/Sequences/";
$error_msg = '';

$input_sequence = '';
$sequence = '';
$sequence_format = '';

$db = null;

$id = null;



/**
 * SEQUENCE PROCESSING
 * 
 * INPUTS ACCEPTED: Raw Sequence, NCBI Gene Id, NCBI Accession No.
 */

$input_sequence = trim($_POST['sequence']);


if(!preg_match('/[^0-9]/', $input_sequence)) {
    
    // Gene ID
    $sequence_format = 'gene-id';
    $sequence_details = fetch_sequence_details_from_NCBI($input_sequence);

} else if(preg_match('/^[a-zA-Z]{1,6}_{0,1}\d{5,9}(.\d+){0,1}$/', $input_sequence)) {
    
    // Accession number
    $sequence_format = 'accession-no';
    $sequence_details = fetch_sequence_details_from_NCBI($input_sequence);

} else if(!preg_match('/[^atgcnATGCN]/', $input_sequence)) {
    
    // Plain sequence
    $sequence_format = 'plain-sequence';
    $sequence = $input_sequence;

} else if(true) {

    //

}


$db = database_init();

$success = $db -> query("INSERT INTO searches (input_sequence, sequence_format, creation_time, status) VALUES ('$input_sequence', '$sequence_format', NOW(), 'Created')");
if(!$success) {
    die("Database error");
}

$id = $db -> getInsertId();



//var_dump($db);


//** Redirect user to the Progress page */

//location("progress?id=$id");


if($sequence_format === 'accession-no' || $sequence_format === 'gene-id') {

    //** Check if sequence details were successfully fetched from NCBI */
    if(!$sequence_details) {
        if($error_msg == '') {
            $error_msg = "info_fetch";
        }
        header("Location: progress?id=" . $id . "&error=" . $error_msg);
        die();
    }
    
    //** Download sequence from NCBI and error-checking*/
    $sequence = download_sequence_FASTA_from_NCBI($input_sequence, $sequence_details);
    if(!$sequence) {
        if($error_msg == '') {
            $error_msg = "download";
        }
        header("Location: progress?id=" . $id . "&error=" . $error_msg);
        die();
    }

    
    $filepath = dirname(__FILE__) . $DATA_DIR . $sequence;
    
    $file = fopen($filepath, 'r');


} else {
    echo search_GQuadruplex($sequence);
}




$success = $db -> query("UPDATE searches SET status = 'Finished' WHERE id = $id");



