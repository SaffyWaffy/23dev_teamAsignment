document.addEventListener('DOMContentLoaded', () => {
    const groupSizeButtons = document.querySelectorAll('.group-size');
    const refreshButton = document.getElementById('refresh');

    groupSizeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const groupSize = button.getAttribute('data-size');
            // Send the group size to the server
            const formData = new FormData();
            formData.append('groupSize', groupSize);
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    window.location.reload();
                }
            });
        });
    });

    refreshButton.addEventListener('click', () => {
        // Refresh the page to randomize groups
        window.location.reload();
    });
});
