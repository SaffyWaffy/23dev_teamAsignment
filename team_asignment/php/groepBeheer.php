<?php 
include '../includes/database.php'; 
session_start(); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Groepen Beheren</title>
    <link rel="stylesheet" href="../css/style.css">
    <?php include '../includes/navbar.php'; ?>
</head>
<body>
    <main>
        <div class="groups">
            <?php
            if (isset($_SESSION['stamgroep']) && isset($_SESSION['cohort'])) {
                $stamgroepid = $_SESSION['stamgroep'];
                $cohort = $_SESSION['cohort'];
            
               
            } else {
                echo "Stamgroep or Cohort not set in session.";
            }


            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['groupId']) && isset($_POST['groupName'])) {
                // Update group name in the database
                $groupId = $_POST['groupId'];
                $groupName = $_POST['groupName'];

                $stmt = $conn->prepare("UPDATE groep SET groepnaam = ? WHERE groepid = ?");
                $stmt->bind_param("si", $groupName, $groupId);
                
                if ($stmt->execute()) {
                    echo "<div class='success-message'>Group name updated successfully!</div><br>";
                } else {
                    echo "<div class='error'>Failed to update group name.</div><br>";
                }
                $stmt->close();
            }
          

             // Fetch groups and their members from the database
             $sql = "SELECT g.groepid, g.groepnaam, p.voornaam 
             FROM groep g 
             LEFT JOIN persoon p ON g.groepid = p.groepid
             WHERE p.stamgroepid = ? AND p.cohort = ?
             ORDER BY g.groepid, p.voornaam";

                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("is", $stamgroepid, $cohort);
                    $stmt->execute();
                    $result = $stmt->get_result();
    
                    if ($result->num_rows > 0) {
                        $groups = [];
                        while ($row = $result->fetch_assoc()) {
                            $groupId = $row['groepid'];
                            if (!isset($groups[$groupId])) {
                                $groups[$groupId] = [
                                    'groepnaam' => $row['groepnaam'],
                                    'personen' => []
                                ];
                            }
                            if ($row['voornaam']) {
                                $groups[$groupId]['personen'][] = $row['voornaam'];
                            }
                        }
    
                        foreach ($groups as $groupId => $group) {
                            echo "<div class='group'>";
                            echo "<form method='POST' action='groepBeheer.php'>";
                            echo "<input type='hidden' name='groupId' value='$groupId'>";
                            echo "<label for='groupName$groupId'>Group Name: </label>";
                            echo "<input type='text' id='groupName$groupId' name='groupName' value='" . htmlspecialchars($group['groepnaam']) . "' required>";
                            echo "<button type='submit'>Update</button>";
                            echo "</form>";
                            echo "<ul>";
                            foreach ($group['personen'] as $persoon) {
                                echo "<li>" . htmlspecialchars($persoon) . "</li>";
                            }
                            echo "</ul>";
                            echo "</div>";
                        }
                    } else {
                        echo "No groups found.";
                    }
    
                    $stmt->close();
                } else {
                    echo "Failed to prepare the SQL statement.";
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
