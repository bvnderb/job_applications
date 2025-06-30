<?php
require 'db.php';

// ADD FEEDBACK code below
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $applicationId = $_POST['application_id'] ?? null;
    $feedback = trim($_POST['feedback'] ?? '');

    if ($applicationId && $feedback !== '') {
        $stmt = $pdo->prepare("UPDATE applications SET feedback = ? WHERE id = ?");
        $stmt->execute([$feedback, $applicationId]);

        echo "OK";
    } else {
        http_response_code(400);
        echo "Invalid input";
    }    
}

?>