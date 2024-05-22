<?php include '../includes/database.php'; ?>
<?php
// Define variables and initialize with empty values
$name = $lastname = "";
$name_err = $lastname_err = "";
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="wrapped">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Naam</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Achternaam</label>
                            <textarea name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>"><?php echo $lastname; ?></textarea>
                            <span class="invalid-feedback"><?php echo $lastname_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="./groepbeheer.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

<?php 

// Initialize variables
$name = $lastname = "";
$name_err = $lastname_err = "";

// require_once "../include/config.php";

// Initialize variables
$name = $lastname = "";
$name_err = $lastname_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate ID
    $id = $_POST["id"];

    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }
    
    // Validate lastname
    $input_lastname = trim($_POST["lastname"]);
    if(empty($input_lastname)){
        $lastname_err = "Please enter a lastname.";     
    } else {
        $lastname = $input_lastname;
    }

    // Check input errors before updating in database
    if(empty($name_err) && empty($lastname_err)){
        // Prepare an update statement
        $sql = "UPDATE persoon SET name=?, lastname=? WHERE id=?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_lastname, $param_id);
            
            // Set parameters
            $param_name = $name;
            $param_lastname = $lastname;
            $param_id = $id;

            // Debugging: Echo out the SQL query
            echo $sql . "<br>";
            echo "Parameters: name=$name, lastname=$lastname, id=$id <br>";
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: ./groepbeheer.php");
                exit();
            } else {
                // Debugging: Echo out any SQL errors
                echo "Error: IT DOES NOT DO IT " . mysqli_error($conn);
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
} else {
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM persoon WHERE id = ?";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    // Fetch result row as an associative array
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $name = $row["name"];
                    $lastname = $row["lastname"];
                } else {
                    echo "ID not found."; // Echo out an error message
                }
                
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($conn);
    } else {
        // URL doesn't contain id parameter. Redirect to error page
        // header("location: ../include/error.php");
        exit();
    }
}
?>
