<?php
require_once 'functions.php';

if (!isset($_GET['date'])) {
    sendJsonResponse(['error' => 'Date parameter is required'], 400);
}

$date = $_GET['date'];
$timestamp = strtotime($date);

if (!$timestamp) {
    sendJsonResponse(['error' => 'Invalid date format. Use YYYY-MM-DD'], 400);
}

$daysOfWeek = [
    'Sunday', 'Monday', 'Tuesday', 'Wednesday', 
    'Thursday', 'Friday', 'Saturday'
];

sendJsonResponse([
    'date' => $date,
    'weekday' => $daysOfWeek[date('w', $timestamp)],
    'weekday_ru' => ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'][date('w', $timestamp)]
]);
?>
