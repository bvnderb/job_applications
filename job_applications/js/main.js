    // debug
    // console.log('Script loaded!');

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
        });
    });
});

// function to show the feedback form
function showFeedbackForm(id) {
    document.getElementById('feedback-form-' + id).style.display = 'block';
}

// function to submit the feedback, 
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
    })
    .catch(error => {
        alert('Error: Could not save feedback.');
        console.error(error);
    });
}