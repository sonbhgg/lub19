<?php
$host = 'localhost';
$dbname = 'trofimova_db';
$username = 'postgres';
$password = 'password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$pdo->exec("CREATE TABLE IF NOT EXISTS countries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    country_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE
)");

$pdo->exec("CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$stmt = $pdo->query("SELECT COUNT(*) as count FROM countries");
$count = $stmt->fetch()['count'];
if ($count == 0) {
    $countries = [
        'Россия' => ['Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань'],
        'США' => ['Нью-Йорк', 'Лос-Анджелес', 'Чикаго', 'Хьюстон', 'Финикс'],
        'Германия' => ['Берлин', 'Гамбург', 'Мюнхен', 'Кёльн', 'Франкфурт']
    ];
    
    foreach ($countries as $countryName => $cities) {
        $pdo->prepare("INSERT INTO countries (name) VALUES (?)")->execute([$countryName]);
        $countryId = $pdo->lastInsertId();
        foreach ($cities as $city) {
            $pdo->prepare("INSERT INTO cities (country_id, name) VALUES (?, ?)")->execute([$countryId, $city]);
        }
    }
}
?>
