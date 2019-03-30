<?php

function read_sequence_from_file($filepath) {
    $file = fopen($filepath, 'r');

    

    fclose($file);
}

function read_sequence($sequence) {

}



/**
 * DATABASE SETUP
 */

function database_init() {
    // Database config  file
    require_once('db-config.php');

    // NOTE: ezSQL needs PHP 7
    require_once('ezSQL/ez_sql_loader.php');

    // Generate an ID for the job
    $job_id = uniqid();

    // Initialise database object and establish a connection
    $db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST, DB_CHARSET);

    return $db;
}


/**
 * Checks if the sequence is available in the DATA_DIR folder, else downloads it.
 */

function download_sequence_FASTA_from_NCBI($search_term, $sequence_details = null) {
    global $DATA_DIR;
    global $error_msg;

    $search_term = trim($search_term);
    
    if(!$sequence_details) {
        $sequence_details = fetch_sequence_details_from_NCBI($search_term);
    }
    
    if($sequence_details === false) {
        return false;
    }

    $filename = $sequence_details -> AccessionVersion . ".fasta";
    $filepath = dirname(__FILE__) . $DATA_DIR . $filename;

    $url = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=nucleotide&id=" . $search_term . "&rettype=fasta&retmode=text";
    $curl = curl_init(str_replace(' ', '%20', $url));
    
    // Check if file already exists
    if(file_exists($filepath) && filemtime($filepath) > strtotime($sequence_details -> UpdateDate) && filesize($filepath) >= $sequence_details -> Length) {
        return $filename;
    }

    if($sequence_details -> Length > 1000000000) {
        $error_msg = "Sequence to be downloaded is greater than 1Gbp (1,000,000,0000 base pairs).";
        return false;
    }

    $file = fopen($filepath, 'w+');
    
    curl_setopt($curl, CURLOPT_FILE, $file);

    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $output = curl_exec($curl);

    if($curl_error = curl_error($curl)) {
        $error_msg = $curl_error;

        curl_close($curl);

        // Delete the file created by the filestream
        unlink($filepath);

        return false;
    }

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
    global $error_msg;

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

    if($curl_error = curl_error($curl)) {
        $error_msg = $curl_error;

        curl_close($curl);
        return false;
    }

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