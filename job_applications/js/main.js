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
    const form = document.getElementById('feedback-form-' + id);
    form.style.display = 'block';
}