
    <header>
    <div class="logo-placeholder">
        <a href="homepage.php">
            <img src="https://www.firda.nl/themes/custom/corp/logo.svg" alt="Logo">
        </a>
    </div>
    <title>Groepsgenerator</title>
    <nav>
        <a class="navButtons" href="./csv1.php">Naam toevoegen</a>
        <a class="navButtons" href="./groep.php">Groepen</a>
        <a class="navButtons" href="./groepBeheer.php">Groepen beheren</a>
        <a class="navButtons" href="./persoonBeheer.php">Personen beheren</a>
        <form id="cohortForm" action="../php/setCohort.php" method="post">
    <label for="cohort">Selecteer Cohort:</label>
    <select name="cohort" id="cohortSelect" required>
        <option value="">Selecteer Cohort</option>
        <?php
        $cohorts = fetchCohorts($conn);
        foreach ($cohorts as $cohort) {
            echo '<option value="' . $cohort . '">' . $cohort . '</option>';
        }
        ?>
    </select>
    <label for="stamgroep">Selecteer Stamgroep:</label>
    <select name="stamgroep" id="stamgroepSelect" required>
        <option value="">Selecteer Stamgroep</option>
    </select>
    <button type="submit">Bevestigen</button>
</form>
    </nav>
</header>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const cohortSelect = document.getElementById('cohortSelect');
    const stamgroepSelect = document.getElementById('stamgroepSelect');

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
</script>