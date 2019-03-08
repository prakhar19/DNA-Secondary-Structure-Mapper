<?php

$DATA_DIR = "/Data/Sequences/";

session_start();

echo(session_id() . "<br>");

if(isset($_POST['sequence'])) {
    if(isset($_POST['id']) && $_POST['id'] === session_id()) {

        $sequence = trim($_POST['sequence']);
        
        $gi = false;
        $accession_no = false;
        
        if(is_int($sequence)) {
            $gi = true;
        }
        
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
            
            echo curl_exec($curl);
            curl_close($curl);

            fclose($file);
        }

        $job_id = uniqid();

    } else {
        exit("Invalid Request");
    }
}