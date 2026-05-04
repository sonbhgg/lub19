<?php
require_once 'functions.php';

sendJsonResponse([
    'month' => date('m'),
    'month_name' => date('F'),
    'year' => date('Y')
]);
?>
