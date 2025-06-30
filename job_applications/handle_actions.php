<?php 
session_start();
// connect to the database
require 'db.php'; 


// CHECKBOX code below
// checks if the form was submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST')  {
    // retrieves form input values from the $_POST superglobal (or sets empty string of not provided)
    $company = $_POST['compName'] ?? '';
    $location = $_POST['compLocation'] ?? '';
    $date = $_POST['applyDate'] ?? '';
    $url = $_POST['vacancyUrl'] ?? '';
    $desc = $_POST['jobDesc'] ?? '';


    // ensure the URL start with http:// or https://
    if (!preg_match('/^https?:\/\//', $url)) {
        $url = 'https://' . $url; // adds https:// if missing
    }

// prepares and executes an SQL INSERT query to store the data in the database
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


// add feedback code below




?>

