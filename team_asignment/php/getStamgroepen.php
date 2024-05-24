<?php
include_once '../includes/database.php';
session_start();

if (isset($_GET['cohort'])) {
    $cohort = $_GET['cohort'];
    $sql = "SELECT stamgroepid, stamgroepnaam FROM stamgroep WHERE cohort = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cohort);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $stamgroepen = [];
    while ($row = $result->fetch_assoc()) {
        $stamgroepen[] = $row;
    }
    
    echo json_encode($stamgroepen);
} else {
    echo json_encode([]);
}
?>
