document.addEventListener('DOMContentLoaded', () => {
    const groupSizeButtons = document.querySelectorAll('.group-size');
    const refreshButton = document.getElementById('refresh');
    const saveGroupsButton = document.getElementById('saveGroups');

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
        // Send a POST request to refresh the groups
        const formData = new FormData();
        formData.append('refreshGroups', true);
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    });

    saveGroupsButton.addEventListener('click', () => {
        // Send a POST request to save the groups
        const formData = new FormData();
        formData.append('saveGroups', true);
        fetch(window.location.href, {
            method: 'POST',
            body: formData
        }).then(response => {
            if (response.ok) {
                alert('Groups saved successfully!');
            } else {
                alert('Failed to save groups.');
            }
        });
    });
});