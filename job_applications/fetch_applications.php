<?php 
require 'db.php';

// security to prevent SQL injections
// pdo = PHP Data Object
// stmt = Statement / SQL Statement 

// fetch avtive (not archived)
$stmt = $pdo->query("SELECT * FROM applications WHERE is_archived = 0 ORDER BY date_applied DESC");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// fetch archived
$stmt_archived = $pdo->query("SELECT * FROM applications WHERE is_archived = 1 ORDER BY date_applied DESC");
$archived_applications = $stmt_archived->fetchAll(PDO::FETCH_ASSOC);