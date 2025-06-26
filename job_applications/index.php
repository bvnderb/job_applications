<!-- comment to change commit message.  -->
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
// pdo = PHP Data Object
// stmt = Statement / SQL Statement 
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
// fetch the data from the database

$stmt = $pdo->query("SELECT * FROM applications");
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<textarea name="jobDesc" rows="5" cols="40" placeholder="Job description"></textarea> </br>
<input type="text" name="vacancyUrl" placeholder="Provide an URL to the job listing"></input> </br>
<input type="submit" value="Add application"></input>
</form> 

<h3>Job applications</h3>

<table border="1">
    <thead>
        <tr>
            <th>Company Name</th>
            <th>location</th>
            <th>Date applied</th>
            <th>Description</th>
            <th>Vacancy url</th>
            <th>Got a reply?</th>
            <th>Feedback</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $application): ?>
            <tr>
                <td><?php echo htmlspecialchars($application['company_name']); ?></td>
                <td><?php echo htmlspecialchars($application['company_location']); ?></td>
                <td><?php echo htmlspecialchars($application['date_applied']); ?></td>
                <td><?php echo htmlspecialchars($application['description']); ?></td>
                <td><a href="<?php echo htmlspecialchars($application['vacancy_url']) ?>" target="_blank">View Listing</td>
                <td><?php if ($application['got_reply']): ?>
                    ✅
                <?php else: ?>
                <input type="checkbox" class="reply-checkbox" data-id="<?= $application['id'] ?>">
                <?php endif; ?>
                </td>
                <td>
                    <?php if ($application['feedback']): ?>
                        <?php echo htmlspecialchars($application['feedback']); ?>
                    <?php else: ?>
                        No feedback yet.
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- JavaScript for the reply checkbox -->
<script>
    // debug
    // console.log('Script loaded!');

document.querySelectorAll('.reply-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const appId = this.dataset.id;

        fetch('update_reply.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${appId}`
        })
        .then(res => res.text())
        .then(data => {
            if (data === 'ok') {
                this.disabled = true;
                this.checked = true;
            } else {
                alert('Failed to update reply status.');
                console.error('Server response:', data);
            }
        });
    });
});
</script>
</body>
</html>
