<?php 
// connect to the database
require 'db.php'; 

// checks if there was a request by submitting a form
if ($_SERVER['REQUEST METHOD'] === 'POST')  {
    $company = $_POST['compName'] ?? '';
    $location = $_POST['compLocation'] ?? '';
    $date = $_POST['applyDate'] ?? '';
    $desc = $_POST['jobDesc'] ?? '';

// security to prevent SQL injections
$stmt = $pdo->prepare("INSERT INTO applications (company_name, company_location, description, date_applied) VALUES (?, ?, ?, ?)");
$stmt->execute([$company, $location, $desc, $date]);

// user confirmation that the insert worked by showing a success message
echo "<p>Application added for <strong>$company</strong>!</p>";
}
?>


<H1>JOB APPLICATIONS 2025</H1>
<form method="POST" action="">
<input type="text" name="compName" placeholder="Company name" required></input> </br>
<input type="text" name="compLocation" placeholder="Location"></input> </br>
<input type="date" name="applyDate" placeholder="Application date"></input> </br>
<textarea name="jobDesc" rows="5" cols="40" placeholder="Job description"></textarea> </br>
<input type="submit" value="Add application"></input>
</form> 