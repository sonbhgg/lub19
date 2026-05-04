<?php
require_once 'config.php';
require_once 'functions.php';

if (!isset($_GET['country'])) {
    sendJsonResponse(['error' => 'Country parameter is required'], 400);
}

$country = $_GET['country'];

$stmt = $pdo->prepare("SELECT c.name FROM cities c 
                       JOIN countries cnt ON c.country_id = cnt.id 
                       WHERE cnt.name = ?");
$stmt->execute([$country]);
$cities = $stmt->fetchAll();

if (empty($cities)) {
    sendJsonResponse(['error' => 'Country not found', 'cities' => []], 404);
}

sendJsonResponse([
    'country' => $country,
    'cities' => array_column($cities, 'name')
]);
?>
