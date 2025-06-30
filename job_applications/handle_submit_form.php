<?php 
session_start();
// connect to the database
require 'db.php'; 


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

    // sets the current date if no date was provided
    if (empty($date)) {
        $date = date('Y-m-d');
    }

    // prepares and executes an SQL INSERT query to store the data in the database
    if (!empty($company) && !empty($location) && !empty($desc)) {
        $stmt = $pdo->prepare("INSERT INTO applications (company_name, company_location, description, date_applied, vacancy_url) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$company, $location, $desc, $date, $url]);
        
        // return a success respone
        echo json_encode([
            'status' => 'success',
            'message' => "Application added for <strong>$company</strong>!"
        ]);
    } else {
        http_response_code(400); // bad request
        echo json_encode([
            'status' => 'error',
            'message' => "Invalid input. Please ensure all fields are filled."
        ]);
    }    
}

// fetch the data from the database
$stmt = $pdo->query("SELECT * FROM applications");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

