<?php
require_once 'functions.php';

if (!isset($_GET['date1']) || !isset($_GET['date2'])) {
    sendJsonResponse(['error' => 'Both date1 and date2 parameters are required'], 400);
}

$date1 = $_GET['date1'];
$date2 = $_GET['date2'];

$timestamp1 = strtotime($date1);
$timestamp2 = strtotime($date2);

if (!$timestamp1 || !$timestamp2) {
    sendJsonResponse(['error' => 'Invalid date format. Use YYYY-MM-DD'], 400);
}

$diff = abs($timestamp2 - $timestamp1);
$days = floor($diff / (60 * 60 * 24));

sendJsonResponse([
    'date1' => $date1,
    'date2' => $date2,
    'days_between' => $days
]);
?>
