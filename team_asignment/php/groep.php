<?php include '../includes/database.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groepsgenerator</title>
    <link rel="stylesheet" href="../css/style.css">
    <?php include '../includes/navbar.php'; ?>
</head>
<body>
       <header> <div class="controls">
            <button id="refresh">Refresh</button>
            <button class="group-size" data-size="2">2 Leden per groep</button>
            <button class="group-size" data-size="3">3 Leden per groep</button>
            <button class="group-size" data-size="4">4 Leden per groep</button>
            <button class="group-size" data-size="5">5 Leden per groep</button>
        </div></header>
         <main>
        <div class="groups">
            <?php
            session_start();
            if (isset($_POST['groupSize'])) {
                $_SESSION['groupSize'] = $_POST['groupSize'];
            }

            $groupSize = isset($_SESSION['groupSize']) ? $_SESSION['groupSize'] : 3;

            $sql = "SELECT voornaam FROM persoon";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $names = [];
                while($row = $result->fetch_assoc()) {
                    $names[] = $row["voornaam"];
                }
                // Shuffle the names array for random groups
                shuffle($names);

                // Calculate the number of groups needed
                $totalNames = count($names);
                $numberOfGroups = ceil($totalNames / $groupSize);
                $groups = array_fill(0, $numberOfGroups, []);

                // Distribute names into groups
                for ($i = 0; $i < $totalNames; $i++) {
                    $groups[$i % $numberOfGroups][] = $names[$i];
                }

                // Display groups
                for ($i = 0; $i < $numberOfGroups; $i++) {
                    echo '<div class="group" id="group'.($i + 1).'"><h3>Personen groep '.($i + 1).'</h3><ul>';
                    foreach ($groups[$i] as $name) {
                        echo '<li>' . $name . '</li>';
                    }
                    echo '</ul></div>';
                }
            } else {
                echo "0 results";
            }
            $conn->close();
            ?>
        </div>
        </main>
    <script src="../javascript/script.js"></script>
</body>
<!-- footer -->
<div class="footer">
    <?php include '../includes/footer.php'; ?>
</div>
</html>