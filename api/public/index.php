<?php
require_once 'config.php';
require_once 'functions.php';

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'all':
            $stmt = $pdo->query("SELECT * FROM items ORDER BY id DESC");
            sendJsonResponse($stmt->fetchAll());
            break;
            
        case 'get':
            if (!isset($_GET['id'])) {
                sendJsonResponse(['error' => 'ID parameter required'], 400);
            }
            $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $item = $stmt->fetch();
            if (!$item) {
                sendJsonResponse(['error' => 'Item not found'], 404);
            }
            sendJsonResponse($item);
            break;
            
        case 'del':
            if (!isset($_GET['id'])) {
                sendJsonResponse(['error' => 'ID parameter required'], 400);
            }
            $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            if ($stmt->rowCount() === 0) {
                sendJsonResponse(['error' => 'Item not found'], 404);
            }
            sendJsonResponse(['success' => true, 'message' => 'Item deleted']);
            break;
            
        case 'edit':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                sendJsonResponse(['error' => 'Method must be POST'], 405);
            }
            if (!isset($_GET['id'])) {
                sendJsonResponse(['error' => 'ID parameter required'], 400);
            }
            $input = json_decode(file_get_contents('php://input'), true);
            if (!isset($input['title']) || !isset($input['content'])) {
                sendJsonResponse(['error' => 'Title and content required'], 400);
            }
            $stmt = $pdo->prepare("UPDATE items SET title = ?, content = ? WHERE id = ?");
            $stmt->execute([$input['title'], $input['content'], $_GET['id']]);
            if ($stmt->rowCount() === 0) {
                sendJsonResponse(['error' => 'Item not found or no changes made'], 404);
            }
            sendJsonResponse(['success' => true, 'message' => 'Item updated']);
            break;
            
        default:
            sendJsonResponse(['error' => 'Invalid action. Available: all, get, del, edit'], 400);
    }
} catch (Exception $e) {
    sendJsonResponse(['error' => $e->getMessage()], 500);
}
?>
