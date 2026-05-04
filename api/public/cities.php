<?php
require_once 'config.php';
require_once 'functions.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if (!isset($_GET['country'])) {
    sendResponse(['error' => 'Parameter "country" is required'], 400);
}

$countryName = $_GET['country'];

$stmt = $pdo->prepare("SELECT id FROM country WHERE LOWER(name) = LOWER(?)");
$stmt->execute([$countryName]);
$country = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$country) {
    sendResponse(['error' => 'Country not found', 'cities' => []]);
}

$stmt = $pdo->prepare("SELECT name FROM city WHERE country_id = ? ORDER BY name");
$stmt->execute([$country['id']]);
$cities = $stmt->fetchAll(PDO::FETCH_COLUMN);

sendResponse([
    'country' => $countryName,
    'cities' => $cities
]);
?>
