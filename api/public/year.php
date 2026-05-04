<?php
//require_once 'config.php';
require_once 'functions.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$currentYear = date('Y');
sendResponse(['year' => $currentYear, 'date' => date('Y-m-d')]);
?>
