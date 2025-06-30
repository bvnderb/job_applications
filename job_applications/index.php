<?php 
session_start();
require 'fetch_applications.php';
?>

<H1>Appleasy</H1>
<h2>Keep track of your job applications - the easy way!</h2>

<?php 
// displays success message if it's available
if(isset($_SESSION['success_message'])) {
    echo "<p class='success'>{$_SESSION['success_message']}</p>";
    unset($_SESSION['success_message']); // clear the success message after displaying it
}
?>

<?php //the following code says: "when this form is submitted, send the data via POST to handle_form.php ?>
<form method="POST" action="handle_form.php">
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

<script src="js/main.js"></script>

