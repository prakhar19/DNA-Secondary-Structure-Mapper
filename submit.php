<?php

ignore_user_abort(true);
//set_time_limit(0);

session_start();

if(!isset($_POST['sequence']) || empty($_POST['sequence'])) {
    redirect('loading.php?msg=invalid_seq');
    exit();
}

if(!isset($_POST['id']) || $_POST['id'] !== session_id()) {
    redirect('loading.php?msg=invalid_request');
    exit();
}

require('functions.php');

$DATA_DIR = "/Data/Sequences/";

/**
 * SEQUENCE PROCESSING
 * 
 * INPUTS ACCEPTED: Raw Sequence, NCBI Gene Id, NCBI Accession No.
 */

$sequence = trim($_POST['sequence']);


// Check type of input
if(!preg_match('/[^0-9]/', $sequence)) {

    echo download_sequence_FASTA_from_NCBI($sequence);

} else if(preg_match('/^[a-zA-Z]{1,6}_{0,1}\d{5,9}(.\d+){0,1}$/', $sequence)) {

    echo download_sequence_FASTA_from_NCBI($sequence);

} else {

}

$job_id = uniqid();





/**
 * Checks if the sequence is available in the DATA_DIR folder, else downloads it.
 */

function download_sequence_FASTA_from_NCBI($search_term) {
    global $DATA_DIR;

    $search_term = trim($search_term);
    
    $sequence_details = fetch_sequence_details_from_NCBI($search_term);
    if($sequence_details === false) {
        return false;
    }
    
    $filename = $sequence_details -> AccessionVersion . ".fasta";

    $url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=nucleotide&id=" . $search_term . "&rettype=fasta&retmode=text";
    $curl = curl_init(str_replace(' ', '%20', $url));
    
    // Check if file already exists
    if(file_exists(dirname(__FILE__) . $DATA_DIR . $filename) && filemtime(dirname(__FILE__) . $DATA_DIR . $filename) > strtotime($sequence_details -> UpdateDate) && filesize(dirname(__FILE__) . $DATA_DIR . $filename) >= $sequence_details -> Length) {
        return $filename;
    }

    $file = fopen(dirname(__FILE__) . $DATA_DIR . $filename, 'w+');
    
    
    
    curl_setopt($curl, CURLOPT_FILE, $file);

    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $output = curl_exec($curl);
    curl_close($curl);

    fclose($file);

    if($output === true) {
        return $filename;
    }

    return false;
}


/**
 * Fetches details of the DNA sequence from the NCBI website
 */

function fetch_sequence_details_from_NCBI($search_term) {
    $search_term = trim($search_term);

    $query_url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esummary.fcgi?db=nucleotide&id=" . $search_term;

    // cURL Setup
    $curl = curl_init(str_replace(' ', '%20', $query_url));

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($curl);
    curl_close($curl);

    if($result === false) {
        return false;
    }
    
    // Parse the XML output from NCBI
    $output = array();
    try {
        libxml_use_internal_errors(TRUE);
        $xml = new SimpleXMLElement($result);
        
        if(!isset($xml -> DocSum -> Item)) {
            return false;
        }
    
        foreach($xml -> DocSum -> Item as $item) {
            $output[(string)$item['Name']] = (string)$item;
        }
    } catch(Exception $e) {
        return false;
    }
    
    return (object)$output;
}




