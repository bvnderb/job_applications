<?php 
require 'db.php';

// security to prevent SQL injections
// pdo = PHP Data Object
// stmt = Statement / SQL Statement 
$stmt = $pdo->query("SELECT * FROM applications ORDER BY date_applied DESC");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);