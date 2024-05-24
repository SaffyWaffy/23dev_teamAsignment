<?php
session_start();
include_once '../includes/database.php';

if (isset($_POST['cohort']) && isset($_POST['stamgroep'])) {
    $cohort = $_POST['cohort'];
    $stamgroep = $_POST['stamgroep'];
    $_SESSION['cohort'] = $cohort;
    $_SESSION['stamgroep'] = $stamgroep;
    
    header('Location: ../php/homepage.php'); // Redirect to your desired page
    exit;
} else {
    echo "Cohort or Stamgroep not set properly.";
}
?>

