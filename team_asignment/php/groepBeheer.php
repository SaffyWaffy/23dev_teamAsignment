<?php include '../includes/database.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <?php include '../includes/navbar.php'; ?>
    <title>Groepsbeheer</title>
    <style>
    .container {
            display: flex;
            flex-wrap: wrap;
            width: 50%;
            height: 480px;
            margin-top: 10%;
            gap: 25px;
        }
        .wrapper {
            width: calc(50% - 200px); 
            padding: 10px;
            border: 1px solid #000;
            box-sizing: border-box;
            margin-top: 20px;
            margin-left: 40px;
        }
        .name-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1px;
        }
        .icons {
            display: flex;
            gap: 5px;
        }
    </style>
</head>
<body>
<main>
    <div class="container">
        <div class="wrapper">
            <h2>Personen groep 1</h2>
            <div class="name-container">
                <p>Justin Croes</p>
                <div class="icons">
                    <a href="updateview.php"><i class="fas fa-pen"></i></a>
                  <a href=""><i class="fas fa-trash-can"></i></a>
                </div>
            </div>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <h2>Personen groep 2</h2>
            <div class="name-container">
                <p>Tygo van der Bij</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <h2>Personen groep 3</h2>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <h2>Personen groep 4</h2>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                    <i class="fas fa-trash-can"></i>
                </div>
            </div>
            <div class="name-container">
                <p>Naam</p>
                <div class="icons">
                <a href="updateview.php"><i class="fas fa-pen"></i></a>
                <a href="delete.php"> <i class="fas fa-trash-can"></i></a>
                </div>
            </div>
        </div>
    </div>
</main>
</body>


<!-- footer -->
<div class="footer">
    <?php include '../includes/footer.php'; ?>
</div>
<?php 

// Include config file
// require_once "../include/config.php";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "groep generator";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
// echo "Connected successfully";

//DELETE


// Include config file
// require_once "../include/config.php";

// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){

    
    // Prepare a delete statement
    $sql = "DELETE FROM user WHERE id = ?";
    
    if($stmt = mysqli_prepare($conn, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: ../index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($conn);
 } 

// else{
//     // Check existence of id parameter
//     if(empty(trim($_GET["id"]))){
//         // URL doesn't contain id parameter. Redirect to error page
//         header("location: ../include/error.php");
//         exit();
//     }
// }

// DELETE END
?>
</html>






