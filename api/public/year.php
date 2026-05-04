<?php
require_once 'functions.php';

sendJsonResponse([
    'year' => date('Y'),
    'is_leap' => date('L') ? 'Yes' : 'No'
]);
?>
