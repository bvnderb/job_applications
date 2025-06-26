<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id && is_numeric($id)) {
        $stmt = $pdo->prepare("UPDATE applications SET got_reply = 1 WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo 'ok';
            exit;
        } else {
            echo 'no rows updated';
            exit;
        }
    } else {
        echo 'invalid id';
        exit;
    }
}

echo 'invalid request';