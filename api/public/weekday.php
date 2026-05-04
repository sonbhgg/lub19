<?php
//require_once 'config.php';
require_once 'functions.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if (!isset($_GET['date'])) {
    sendResponse(['error' => 'Parameter "date" is required. Format: YYYY-MM-DD'], 400);
}

$date = $_GET['date'];
$timestamp = strtotime($date);

if ($timestamp === false) {
    sendResponse(['error' => 'Invalid date format. Use YYYY-MM-DD'], 400);
}

$weekday = date('l', $timestamp);
$weekdayNumber = date('N', $timestamp);

sendResponse([
    'date' => $date,
    'weekday' => $weekday,
    'weekday_number' => $weekdayNumber
]);
?>
