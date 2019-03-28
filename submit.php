<?php

ignore_user_abort(true);
ini_set('memory_limit', '4000M');
//set_time_limit(0);

session_start();

/** 
 * SECURITY MEASURES
 * 
 * - Prevention against spamming of search requests
 * 
 */

if(!isset($_POST['sequence']) || empty($_POST['sequence'])) {
    // Redirect
    header('loading.php?msg=invalid_seq');
    exit();
}

if(!isset($_POST['id']) || $_POST['id'] !== session_id()) {
    redirect('loading.php?msg=invalid_request');
    exit();
}


/**
 * INCLUDES & DEFINITIONS
 */


require('functions.php');

$DATA_DIR = "/Data/Sequences/";
$error_msg = '';





/**
 * SEQUENCE PROCESSING
 * 
 * INPUTS ACCEPTED: Raw Sequence, NCBI Gene Id, NCBI Accession No.
 */

$input_sequence = trim($_POST['sequence']);


if(!preg_match('/[^0-9]/', $input_sequence)) {
    
    // Gene ID
    $sequence_details = fetch_sequence_details_from_NCBI($search_term);
    $sequence = download_sequence_FASTA_from_NCBI($input_sequence, $sequence_details);

} else if(preg_match('/^[a-zA-Z]{1,6}_{0,1}\d{5,9}(.\d+){0,1}$/', $input_sequence)) {
    
    // Accession number
    $sequence_details = fetch_sequence_details_from_NCBI($search_term);
    $sequence = download_sequence_FASTA_from_NCBI($input_sequence, $sequence_details);

} else if(!preg_match('/[^atgcnATGCN]/', $input_sequence)) {
    
    // Plain sequence
    $sequence = $input_sequence;

} else if(true) {

}



$db = database_init();

$db -> query("INSERT INTO searches (sequence, creation_date, status) VALUES ($sequence, NOW(), 'Started')");

var_dump($db);




/**
 * FUNCTIONS
 */

function read_sequence_from_file($filepath) {
    $file = fopen($filepath, 'r');

    

    fclose($file);
}

function read_sequence($sequence) {

}





