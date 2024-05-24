<?php
$servername = "localhost";
$username = "root"; // replace with your MySQL username
$password = ""; // replace with your MySQL password
$dbname = "firda";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch available cohorts
if (!function_exists('fetchCohorts')) {
    function fetchCohorts($conn) {
        $sql = "SELECT DISTINCT cohort FROM persoon";
        $result = $conn->query($sql);
        $cohorts = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cohorts[] = $row['cohort'];
            }
        }
        return $cohorts;
    }
}

?>
