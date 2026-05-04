<?php
//require_once 'config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once 'functions.php';

$currentDay = date('d');
sendResponse(['day' => $currentDay, 'date' => date('Y-m-d')]);
?>
