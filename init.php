<?php

require_once('config.php');
require_once('functions.php');

require_once('ezSQL/ez_sql_loader.php');



$DATA_DIR = "/Data/Sequences/";
$RESULT_DIR = "/Data/Results/";

$id = null;
$error_msg = '';


//** DATABSE INITIALIZATION */

global $db;
$db = new ezSQL_mysqli(DB_USER, DB_PASSWORD, DB_NAME, DB_HOST, DB_CHARSET);

