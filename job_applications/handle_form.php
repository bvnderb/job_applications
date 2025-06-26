<?php 
session_start();
// connect to the database
require 'db.php'; 

// checks if there was a request by a user submitting a form
if ($_SERVER['REQUEST_METHOD'] === 'POST')  {
    $company = $_POST['compName'] ?? '';
    $location = $_POST['compLocation'] ?? '';
    $date = $_POST['applyDate'] ?? '';
    $url = $_POST['vacancyUrl'] ?? '';
    $desc = $_POST['jobDesc'] ?? '';


    // url http/https handling
    if (!preg_match('/^https?:\/\//', $url)) {
        $url = 'https://' . $url; // automatically adds https:// if missing
    }

$stmt = $pdo->prepare("INSERT INTO applications (company_name, company_location, description, date_applied, vacancy_url)
                       VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$company, $location, $desc, $date, $url]);

// user confirmation that the insert worked by showing a success message
echo "<p>Application added for <strong>$company</strong>!</p>";

// store success message in session
$_SESSION['success_message'] = "Application added for <strong>$company</strong>!";

header('Location: index.php');
exit;

}
// fetch the data from the database

$stmt = $pdo->query("SELECT * FROM applications");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

