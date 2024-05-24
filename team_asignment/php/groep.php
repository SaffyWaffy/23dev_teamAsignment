<?php include_once '../includes/database.php';
session_start(); 
?>

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
            <button id="saveGroups">Save Groups</button>
        </div></header>
         <main>
        <div class="groups">
        <?php
if (isset($_SESSION['stamgroep']) && isset($_SESSION['cohort'])) {
    $stamgroepid = $_SESSION['stamgroep'];
    $cohort = $_SESSION['cohort'];

   
} else {
    echo "Stamgroep or Cohort not set in session.";
}


if (isset($_POST['groupSize'])) {
    $_SESSION['groupSize'] = $_POST['groupSize'];
}

if (isset($_POST['refreshGroups'])) {
    unset($_SESSION['shuffledNames']);
}

$groupSize = isset($_SESSION['groupSize']) ? $_SESSION['groupSize'] : 3;

if (!isset($_SESSION['shuffledNames'])) {
    $sql = "SELECT voornaam FROM persoon WHERE stamgroepid = '$stamgroepid' AND cohort = '$cohort'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $names = [];
        while ($row = $result->fetch_assoc()) {
            $names[] = $row["voornaam"];
        }
        shuffle($names);
        $_SESSION['shuffledNames'] = $names;
    } else {
        echo "0 results";
        $conn->close();
        exit;
    }
} else {
    $names = $_SESSION['shuffledNames'];
}

// Calculate the number of groups needed
$totalNames = count($names);
$numberOfGroups = ceil($totalNames / $groupSize);
$groups = array_fill(0, $numberOfGroups, []);

// Distribute names into groups
for ($i = 0; $i < $totalNames; $i++) {
    $groups[$i % $numberOfGroups][] = $names[$i];
}

if (isset($_POST['saveGroups'])) {
    // Save groups to the database
    foreach ($groups as $groupId => $group) {
        // Insert group into groep table
        $groupName = 'Group ' . ($groupId + 1);
        $stmt = $conn->prepare("INSERT INTO groep (groepnaam) VALUES (?)");
        $stmt->bind_param("s", $groupName);
        $stmt->execute();

        // Get the last inserted groepid
        $lastGroupId = $stmt->insert_id;

        // Update each person in the group
        foreach ($group as $name) {
            $stmt = $conn->prepare("UPDATE persoon SET groepid = ? WHERE voornaam = ?");
            $stmt->bind_param("is", $lastGroupId, $name);
            $stmt->execute();
        }
    }
    echo "Groups saved successfully";
    exit;
}

// Display groups
for ($i = 0; $i < $numberOfGroups; $i++) {
    echo '<div class="group" id="group' . ($i + 1) . '"><h3>Personen groep ' . ($i + 1) . '</h3><ul>';
    foreach ($groups[$i] as $name) {
        echo '<li>' . $name . '</li>';
    }
    echo '</ul></div>';
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