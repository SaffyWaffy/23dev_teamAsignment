document.addEventListener('DOMContentLoaded', () => {
    const groupSizeButtons = document.querySelectorAll('.group-size');
    const refreshButton = document.getElementById('refresh');
    const saveGroupsButton = document.getElementById('saveGroups');
    const cohortSelect = document.getElementById('cohortSelect');
    const stamgroepSelect = document.getElementById('stamgroepSelect');

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

    cohortSelect.addEventListener('change', () => {
        const cohort = cohortSelect.value;
        if (cohort) {
            fetch(`../php/getStamgroepen.php?cohort=${cohort}`)
                .then(response => response.json())
                .then(data => {
                    stamgroepSelect.innerHTML = '<option value="">Selecteer Stamgroep</option>';
                    data.forEach(stamgroep => {
                        const option = document.createElement('option');
                        option.value = stamgroep.stamgroepid;
                        option.textContent = stamgroep.stamgroepnaam;
                        stamgroepSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching stamgroepen:', error));
        } else {
            stamgroepSelect.innerHTML = '<option value="">Selecteer Stamgroep</option>';
        }
    });
});
