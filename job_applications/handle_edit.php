<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $company = $_POST['company_name'] ?? '';
    $location = $_POST['company_location'] ?? '';
    $desc = $_POST['description'] ?? '';
    $url = $_POST['vacancy_url'] ?? '';
    $gotReply = isset($_POST['got_reply']) ? 1 : 0;

    if (!preg_match('/^https?:\/\//', $url)) {
        $url = 'https://' . $url;
    }

    if ($id && $company && $location && $desc) {
        $stmt = $pdo->prepare("UPDATE applications
                               SET company_name = ?, company_location = ?, description = ?, vacancy_url = ?, got_reply = ?, last_edited = NOW()
                               WHERE id = ?");
        $stmt->execute([$company, $location, $desc, $url, $gotReply, $id]);

        echo 'ok';
    } else {
        http_response_code(400);
        echo 'Invalid input.';
    }
}