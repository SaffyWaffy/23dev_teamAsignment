<?php include_once '../includes/database.php';?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groepsgenerator</title>
    <link rel="stylesheet" href="../css/style.css">
    <?php include '../includes/navbar.php';?>
</head> 
<body>
    <main>
        
        <button onclick="window.location.href='csv1.php'" title="Persoon toevoegen">
        <img src="https://cdn.icon-icons.com/icons2/3385/PNG/512/profile_business_person_avatar_people_user_plus_add_icon_212612.png" alt="Groep genereren icoon" style="width: 200px; height: 200px; vertical-align: middle;">
        </button>
        <button onclick="window.location.href='groep.php'" title="Groep genereren">
        <img src="https://cdn4.iconfinder.com/data/icons/people-37/512/3-512.png" alt="Groep genereren icoon" style="width: 200px; height: 200px; vertical-align: middle;">
        </button>
    </main>
</body>
<!-- footer -->
<div class="footer">
    <?php include '../includes/footer.php'; ?>
</div>
</html>
