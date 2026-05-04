<?php
require_once 'functions.php';

sendJsonResponse([
    'day' => date('d'),
    'day_of_week' => date('l'),
    'full_date' => date('Y-m-d')
]);
?>
