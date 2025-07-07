    // debug
    // console.log('Script loaded!');

// event listener for the form
document.querySelector('form').addEventListener('submit', function (event) {
    event.preventDefault(); // prevent the default form submission

    const formData = new FormData(this); // collect form data

    //send the form data via AJAX = Asynchronous Javascript and XML (fetch request)
    fetch('handle_submit_form.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // parse the response as JSON
    .then(data => {
        const successMessageContainer = document.getElementById('success-message');
        const errorMessageContainer = document.getElementById('error-message');

        if (data.status === 'success') {
            // if the submission was succesful, we will display the success message
            successMessageContainer.innerHTML = data.message;
            successMessageContainer.style.display = 'block';
            errorMessageContainer.style.display = 'none';

            // // hide the message after a few seconds
            // setTimeout(() => {
            //     successMessageContainer.style.display = 'none';
            // }, 5000); // hide after 5 seconds    
        } else {
            // if there was an error, we will display the error message
            errorMessageContainer.innerHTML = data.message;
            errorMessageContainer.style.display = 'block';
            successMessageContainer.style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Error submitting form:', error);
    });
 });


// script for the reply checkbox
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
            location.reload();
        });
    });
});

// function to show the feedback form
function showFeedbackForm(id) {
    document.getElementById('feedback-form-' + id).style.display = 'block';
}

// function to submit the feedback form
function submitFeedback(id) {
    const form = document.getElementById('feedback-form-' + id);
    const formData = new FormData(form);

    fetch('handle_feedback.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.text();
    })
    .then(data => {
        alert('Feedback added successfully!');
        form.style.display = 'none';

        // reload the page to reflect the changes in the DB
        location.reload();
    })
    .catch(error => {
        alert('Error: Could not save feedback.');
        console.error(error);
    });
}

function deleteItem(id) {
    if (!confirm("Are you sure you want to delete this application?")) return;

    fetch('delete_application.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + encodeURIComponent(id)
    })
    .then(res => res.text())
    .then(data => {
        if (data === 'ok') {
            const row = document.getElementById('row-' + id);
            if (row) row.remove();
        } else {
            alert('Failed to delete application.');
            console.error('Server response:', data);
        }
    })
    .catch(err => {
        console.error('Request failed:', err);
        alert('Something went wrong.');
    });
}

function showEditForm(id) {
    const form = document.getElementById('edit-form-' + id);
    if (form) {
        form.style.display = 'block';
    }
}

function submitEdit(id) {
    const form = document.getElementById('edit-form-' + id);
    const formData = new FormData(form);

    fetch('handle_edit.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data === 'ok') {
            alert('Application updated successfully!');
            location.reload(); // refresh the page to show updates
        } else {
            alert('Error updating application.');
            console.error(data);
        }
    })
    .catch(error => {
        alert('Something went wrong.');
        console.error(error);
    });
}