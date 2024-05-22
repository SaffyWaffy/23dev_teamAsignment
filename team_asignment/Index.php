<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groepsgenerator</title>
    <link rel="stylesheet" href="css/style.css">
    <header>
        <div class="logo-placeholder">
            <a href="team_asignment/index.php">
                <img src="https://www.firda.nl/themes/custom/corp/logo.svg" alt="Logo">
            </a>
        </div>
        <nav>
            <a class="navButtons" href="./php/csv1.php" class="button">Naam toevoegen</a>
            <a class="navButtons" href="./php/groep.php" class="button">Groepen</a>
            <a class="navButtons" href="./php/groepBeheer.php" class="button">Groepen beheren</a>
            <a class="navButtons" href="./php/persoonBeheer.php" class="button">Personen beheren</a>
        </nav>
        <h1>Groepsgenerator</h1>
    </header>
</head> 
<body>

    <main>
        <button>Toevoegen van namen</button>
        <button href="groep.php">Groep genereren</button>
    </main>
</body>
<!-- footer -->
<div class="footer">
    <?php include 'includes/footer.php'; ?>
</div>
</html>
