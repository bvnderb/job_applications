<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $pdo->prepare("DELETE FROM applications WHERE id = ?");
    $stmt->execute([$id]);

    if ($stmt->rowCount()) {
        echo 'ok';
    } else {
        echo 'error';
    }
}
?>