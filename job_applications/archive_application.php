<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'] ?? ''; // Either 'archive' or 'unarchive'

    if ($id && $action) {
        if ($action === 'archive') {
            $stmt = $pdo->prepare("UPDATE applications SET is_archived = 1 WHERE id = ?");
        } elseif ($action === 'unarchive') {
            $stmt = $pdo->prepare("UPDATE applications SET is_archived = 0 WHERE id = ?");
        } else {
            http_response_code(400);
            echo "Invalid action.";
            exit;
        }

        $stmt->execute([$id]);

        header('Location: index.php');
        exit;
    } else {
        http_response_code(400);
        echo "Invalid request.";
    }
}