<?php
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
 * 
 * INPUTS ACCEPTED: Raw Sequence, NCBI Gene Id, NCBI Accession No.
 */

$sequence = trim($_POST['sequence']);

$gi = false;
$accession_no = false;

// Check if input is Gene ID
if(is_int($sequence)) {
    $gi = true;
}

// Check if input is Accession Number
if(preg_match('/^[a-zA-Z]{1,2}_{0,1}(\d{5,6}|\d{8})(.\d+){0,1}$/', $sequence)) {
    $accession_no = true;
}

if($gi || $accession_no) {
    $search_id = $sequence;

    $url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=nucleotide&id=" . $search_id . "&rettype=fasta&retmode=text";
    $filename = "a";
    
    $curl = curl_init(str_replace(' ', '%20', $url));

    $file = fopen(dirname(__FILE__) . $DATA_DIR . $filename, 'w+');

    curl_setopt($curl, CURLOPT_FILE, $file);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    curl_exec($curl);
    curl_close($curl);

    fclose($file);
}


echo fetch_accession_no($sequence);


/**
 * Returns Accession Number of the DNA sequence from the NCBI website
 */

function fetch_accession_no($search_term) {
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

    // Parse the XML output from NCBI
    try {
    
        libxml_use_internal_errors(TRUE);
        $xml = new SimpleXMLElement($result);
    
    } catch(Exception $e) {
        return false;
    }
    
    foreach($xml -> DocSum -> Item as $item) {
        if((string) $item['Name'] === 'AccessionVersion' && sizeof((string)$item) > 0) {
            return (string) $item;
        }
    }

    return false;
}





$job_id = uniqid();

