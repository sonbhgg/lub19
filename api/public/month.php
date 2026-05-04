<?php
//require_once 'config.php';
require_once 'functions.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$currentMonth = date('m');
sendResponse(['month' => $currentMonth, 'month_name' => date('F'), 'date' => date('Y-m-d')]);
?>
