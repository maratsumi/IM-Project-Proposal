<?php
require_once "config.php";

$purchaseNumber = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["purchaseNumber"])){
        header("ErrorPage.html");
        exit;
    }

    $purchaseNumber = trim($_GET["purchaseNumber"]);
    $sql = "DELETE FROM sml WHERE purchaseNumber = ?";

    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("i", $param_id);
        $param_id = trim($_GET["purchaseNumber"]);

        if($stmt->execute()){
            header("location: indexLog.php");
            exit();
        } else{
            echo "An error has occurred. Please try again later.";
        }
    }
    $mysqli->close();

} else {
    if (empty(trim($_GET["purchaseNumber"]))) {
        header("location: ErrorPage.html");
        exit();
    }
}
?>

<!-- // <?php
// Process delete operation after confirmation
// if(isset($_POST["purchaseNumber"]) && !empty($_POST["purchaseNumber"])){
//     // Include config file
//     require_once "config.php";
    
//     Prepare a delete statement
//     $sql = "DELETE FROM sml WHERE purchaseNumber = ?";
    
//     if($stmt = mysqli_prepare($link, $sql)){
//         // Bind variables to the prepared statement as parameters
//         mysqli_stmt_bind_param($stmt, "i", $param_purchaseNumber);
        
//         // Set parameters
//         $param_purchaseNumber = trim($_POST["purchaseNumber"]);
        
//         // Attempt to execute the prepared statement
//         if(mysqli_stmt_execute($stmt)){
//             // Records deleted successfully. Redirect to landing page
//             header("location: indexLog.php");
//             exit();
//         } else{
//             echo "Oops! Something went wrong. Please try again later.";
//         }
//     }
     
//     // Close statement
//     mysqli_stmt_close($stmt);
    
//     // Close connection
//     mysqli_close($link);
// } else{
//     // Check existence of purchaseNumber parameter
//     if(empty(trim($_GET["purchaseNumber"]))){
//         // URL doesn't contain purchaseNumber parameter. Redirect to error page
//         header("location: ErrorPage.html");
//         exit();
//     }
// }
// ?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./components/output.css" />
    <title>Delete Record</title>
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container mx-auto sm:px-4 max-w-full">
            <div class="grid-row: auto;">
                <div class="col-span-12">
                    <h2 class="mt-5 mb-3">Delete Record</h2>
                    <form method="post">
                        <div class="flex space-x-2">
                            <input type="hidden" name="purchaseNumber" value="<?php echo trim($_GET["purchaseNumber"]); ?>"/>
                            <p>Are you sure you want to delete this record?</p>
                            <p>
                                <input type="submit" value="Yes" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                                <a href="indexLog.php" class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>

