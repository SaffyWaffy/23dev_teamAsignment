<?php include '../includes/database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Naam Toevoegen</title>
     <link rel="stylesheet" href="../css/style.css">
     <?php include '../includes/navbar.php'; ?>
  
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative; /* Voeg toe */
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: #f00;
            margin-top: 5px;
        }
        .success-message {
            text-align: center;
            margin-top: 20px; /* Verander de marge naar wens */
        }
    </style>
</head>
<body>
    <h2>Naam Toevoegen</h2>
    <div class="container">
        <form action="csv1.php" method="post">
            <label for="voornaam">Voornaam:</label><br>
            <input type="text" id="voornaam" name="voornaam" required><br><br>
            <label for="achternaam">Achternaam:</label><br>
            <input type="text" id="achternaam" name="achternaam" required><br><br>
            <label for="achternaam">Student Nummer:</label><br>
            <input type="text" id="studentnummer" name="studentnummer" required><br><br>
            <button type="submit">Toevoegen</button>
        </form>
        <?php
        
        if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
 
// Controleer of het formulier voor het toevoegen van namen is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['voornaam']) && isset($_POST['achternaam']) && isset($_POST['studentnummer'])) {
    // Gegevens van het formulier ophalen en ontsnappen om SQL-injectie te voorkomen
    $voornaam = $conn->real_escape_string($_POST['voornaam']);
    $achternaam = $conn->real_escape_string($_POST['achternaam']);
    $studentnummer = $conn->real_escape_string($_POST['studentnummer']);
 
    // SQL-query om gegevens in te voeren
    $sql = "INSERT INTO persoon (VOORNAAM, ACHTERNAAM, STUDENTNUMMER) VALUES ('$voornaam', '$achternaam', '$studentnummer')";
 
    if ($conn->query($sql) === TRUE) {
        echo "<div class='success-message'>Gegevens succesvol toegevoegd.</div>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
 
// Controleer of het formulier voor het importeren van CSV-bestand is verzonden
$imported = false; // Initiëren van de variabele
 
if (isset($_POST["import"])) {
    $filename = $_FILES['file']['tmp_name'];
    if ($_FILES['file']['size'] > 0) {
        $file = fopen($filename, 'r');
        // Eerste regel overslaan als het een header bevat
        fgetcsv($file);
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            // Zorg ervoor dat alle kolommen correct worden opgehaald en geescaped
            $voornaam = $conn->real_escape_string($column[0]);
            $achternaam = $conn->real_escape_string($column[1]);
            $studentnummer = $conn->real_escape_string($column[2]);
 
            $sqlInsert = "INSERT INTO persoon (voornaam, achternaam, studentnummer) VALUES ('$voornaam', '$achternaam', '$studentnummer')";
            $result = mysqli_query($conn, $sqlInsert);
            if (!empty($result)) {
                $imported = true;
            } else {
                echo "Er is een probleem opgetreden met de volgende query: $sqlInsert<br>";
                echo "Error: " . $conn->error . "<br>";
            }
        }
        if ($imported == true) {
           echo "CSV is goed geïmporteerd!";
        }
    }
}
 
$conn->close();
?>
        
<form class="form-horizoontal" action="" method="post" name="uploadCsv" enctype="multipart/form-data">
    <div>
        <label>Kies CSV-bestand</label>
        <input type="file" name="file" accept=".csv">
        <button type="submit" name="import">Importeren</button>
    </div>
</form>

 </div>
 </body>
 <div class="footer">
    <?php include '../includes/footer.php'; ?>
</div>