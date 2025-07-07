<?php
session_start();
require 'fetch_applications.php';
?>

<H1>Appleasy</H1>
<h2>Keep track of your job applications - the easy way!</h2>

<?php if (isset($_SESSION['success_message'])): ?>
    <script>
        alert("<?= addslashes($_SESSION['success_message']) ?>");
    </script>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <script>
        alert("<?= addslashes($_SESSION['error_message']) ?>");
    </script>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<?php //the following code says: "when this form is submitted, send the data via POST to handle_form.php 
?>
<form method="POST" action="handle_submit_form.php">
    <input type="text" name="compName" placeholder="Company name" required></input> </br>
    <input type="text" name="compLocation" placeholder="Location"></input> </br>
    <input type="date" name="applyDate" placeholder="Application date"></input> </br>
    <textarea name="jobDesc" rows="5" cols="40" placeholder="Job description"></textarea> </br>
    <input type="text" name="vacancyUrl" placeholder="Provide an URL to the job listing"></input> </br>
    <input type="submit" value="Add application"></input>
</form>

<h3>Ongoing applications</h3>
<div id="success-message" style="display: none; color: green;"></div>
<div id="error-message" style="display: none; color: red;"></div>

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
            <th colspan="4">Actions</th>
            <th>Last Edited</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($applications as $application): ?>
            <tr id="row-<?= $application['id'] ?>">
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
                <td>
                    <!-- button to reveal the form -->
                    <button type="button" onclick="showFeedbackForm(<?= $application['id'] ?>)">Add feedback</button>

                    <!-- hidden feedback form -->
                    <form id="feedback-form-<?= $application['id'] ?>" action="handle_feedback.php" method="POST" style="display:none;">
                        <input type="hidden" name="application_id" value="<?= $application['id'] ?>">
                        <textarea name="feedback" rows="3" cols="40" placeholder="Enter your feedback here..."></textarea>
                        <br>
                        <button type="button" onclick="submitFeedback(<?= $application['id'] ?>)">Save</button>
                    </form>
                </td>
                <td>
                    <!-- button to reveal update form -->
                    <button onclick="showEditForm(<?= $application['id'] ?>)">Edit</button>

                    <!-- hidden edit form -->
                    <form id="edit-form-<?= $application['id'] ?>" style="display:none;">
                        <input type="hidden" name="id" value="<?= $application['id'] ?>">
                        <input type="text" name="company_name" value="<?= htmlspecialchars($application['company_name']) ?>" required placeholder="Company Name">
                        <input type="text" name="company_location" value="<?= htmlspecialchars($application['company_location']) ?>" required placeholder="Location">
                        <input type="text" name="description" value="<?= htmlspecialchars($application['description']) ?>" required placeholder="Job Description">
                        <input type="url" name="vacancy_url" value="<?= htmlspecialchars($application['vacancy_url']) ?>" required placeholder="Job URL">

                        <label>
                            <input type="checkbox" name="got_reply" value="1" <?= $application['got_reply'] ? 'checked' : '' ?>>
                            Got a reply
                        </label>
                        <br>
                        <button type="button" onclick="submitEdit(<?= $application['id'] ?>)">Save</button>
                    </form>
                </td>
                <td>
                    <button id="deleteButton" onclick="deleteItem(<?= $application['id'] ?>)">X</button>
                </td>
                <td>
                    <!-- archive -->
                    <form method="POST" action="archive_application.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $application['id'] ?>">
                        <input type="hidden" name="action" value="archive">
                        <button type="submit">Archive</button>
                    </form>
                </td>
                <td>
                    <?php
                    if ($application['last_edited']) {
                        echo date('d F Y, H:i', strtotime($application['last_edited']));
                    } else {
                        echo '—';
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Archived Applications</h3>
<table border="1">
    <thead>
        <tr>
            <th>Company Name</th>
            <th>Location</th>
            <th>Date applied</th>
            <th>Description</th>
            <th>Vacancy URL</th>
            <th>Got a reply?</th>
            <th>Feedback</th>
            <th>Last Edited</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($archived_applications as $application): ?>
            <tr>
                <td><?= htmlspecialchars($application['company_name']) ?></td>
                <td><?= htmlspecialchars($application['company_location']) ?></td>
                <td><?= htmlspecialchars($application['date_applied']) ?></td>
                <td><?= htmlspecialchars($application['description']) ?></td>
                <td><a href="<?= htmlspecialchars($application['vacancy_url']) ?>" target="_blank">View</a></td>
                <td><?= $application['got_reply'] ? '✅' : '—' ?></td>
                <td><?= $application['feedback'] ? htmlspecialchars($application['feedback']) : 'No feedback' ?></td>
                <td>
                    <?php
                    if ($application['last_edited']) {
                        echo date('d F Y, H:i', strtotime($application['last_edited']));
                    } else {
                        echo '—';
                    }
                    ?>
                </td>
                <td>
                    <form method="POST" action="archive_application.php" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $application['id'] ?>">
                        <input type="hidden" name="action" value="unarchive">
                        <button type="submit">Unarchive</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<script src="js/main.js"></script>