<?php 
// connect to the database
require 'db.php'; 

// checks if there was a request by a user submitting a form
if ($_SERVER['REQUEST_METHOD'] === 'POST')  {
    $company = $_POST['compName'] ?? '';
    $location = $_POST['compLocation'] ?? '';
    $date = $_POST['applyDate'] ?? '';
    $url = $_POST['vacancyUrl'] ?? '';
    $desc = $_POST['jobDesc'] ?? '';

// security to prevent SQL injections
$stmt = $pdo->prepare("INSERT INTO applications (company_name, company_location, description, date_applied, vacancy_url) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$company, $location, $desc, $date, $url]);

// user confirmation that the insert worked by showing a success message
echo "<p>Application added for <strong>$company</strong>!</p>";
}
?>


<H1>JOB APPLICATIONS 2025</H1>
<form method="POST" action="">
<input type="text" name="compName" placeholder="Company name" required></input> </br>
<input type="text" name="compLocation" placeholder="Location"></input> </br>
<input type="date" name="applyDate" placeholder="Application date"></input> </br>
<input type="url" name="vacancyUrl" placeholder="Provide an URL to the job listing"></input> </br>
<textarea name="jobDesc" rows="5" cols="40" placeholder="Job description"></textarea> </br>
<input type="submit" value="Add application"></input>
</form> 