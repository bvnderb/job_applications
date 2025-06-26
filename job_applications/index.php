<?php 
session_start(); // starts the session to store success messages
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
// security to prevent SQL injections
$stmt = $pdo->prepare("INSERT INTO applications (company_name, company_location, description, date_applied, vacancy_url) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$company, $location, $desc, $date, $url]);

// user confirmation that the insert worked by showing a success message
echo "<p>Application added for <strong>$company</strong>!</p>";

// store success message in session
$_SESSION['success_message'] = "Application added for <strong>$company</strong>!";

// redirect to the same page (GET request) to prevent form resubmission
header('Location: ' . $_SERVER['PHP_SELF']);
exit;
}
?>


<H1>Appleasy</H1>
<h2>Keep track of your job applications - the easy way!</h2>

<?php 
if(isset($_SESSION['success_message'])) {
    echo "<p class='success'>{$_SESSION['success_message']}</p>";
    unset($_SESSION['success_message']); // clear the success message after displaying it
}
?>

<form method="POST" action="">
<input type="text" name="compName" placeholder="Company name" required></input> </br>
<input type="text" name="compLocation" placeholder="Location"></input> </br>
<input type="date" name="applyDate" placeholder="Application date"></input> </br>
<input type="text" name="vacancyUrl" placeholder="Provide an URL to the job listing"></input> </br>
<textarea name="jobDesc" rows="5" cols="40" placeholder="Job description"></textarea> </br>
<input type="submit" value="Add application"></input>
</form> 