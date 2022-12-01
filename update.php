<?php
require_once "config.php";

<<<<<<< Updated upstream
$purchaseNumber = $distributorName = $itemName = $itemQuantity = $itemNumber = $recipientName = $dateOrdered = "";

$purchaseNumber_err = $distributorName_err = $itemName_err = $itemQuantity_err = $itemNumber_err = $recipientName_err = $dateOrdered_err = "";
=======
$distributorName = $itemName = $itemQuantity = $itemNumber = $recipientName = $dateOrdered = "";

$distributorName_err = $itemName_err = $itemQuantity_err = $itemNumber_err = $recipientName_err = $dateOrdered_err = "";
>>>>>>> Stashed changes

if(isset($_POST["purchaseNumber"]) && !empty ($_POST["purchaseNumber"])){
    $purchaseNumber = $_POST["purchaseNumber"];
    $input_dateOrdered = trim($_POST["dateOrdered"]);
    
    if(empty ($input_dateOrdered)){
        $dateOrdered_err = "Please enter valid Date";
      } elseif(!filter_var($input_dateOrdered, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/")))){
        $dateOrdered_err = "Please enter a valid Date";
      } else {
        $dateOrderedString = $input_dateOrdered;
        $dateOrdered = strtotime($dateOrderedString);
        date("Y-m-d", $dateOrdered);
      }

    $input_distributorName = trim($_POST["distributorName"]);
    if(empty($input_distributorName)){
        $distributorName_err = "Please enter Distributor Name";
    } elseif(!filter_var($input_distributorName, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $distributorName_err = "Please enter a valid name";
    } else{
        $distributorName = $input_distributorName;
    }

    $input_itemName = trim($_POST["itemName"]);
    if(empty($input_itemName)){
        $itemName_err = "Please enter Item Name";
    } elseif(!filter_var($input_itemName, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $itemName_err = "Please enter a valid name";
    } else{
        $itemName = $input_itemName;
    }

    $input_itemQuantity = trim($_POST["itemQuantity"]);
    if(empty($input_itemQuantity)){
        $itemQuantity_err = "Please enter Item Quantity";
    } elseif(!filter_var($input_itemQuantity, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $itemQuantity_err = "Please enter a valid number";
    } else{
        $itemQuantity = $input_itemQuantity;
    }

    $input_itemNumber = trim($_POST["itemNumber"]);
    if(empty($input_itemNumber)){
        $itemNumber_err = "Please enter Item Quantity";
    } elseif(!filter_var($input_itemNumber, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $itemNumber_err = "Please enter a valid number";
    } else{
        $itemNumber = $input_itemNumber;
    }

    $input_dateReceived = trim($_POST["dateReceived"]);
    if(empty($input_dateReceived)){
        $dateReceived_err = "Please enter Date Received";
    } elseif(!filter_var($input_dateReceived, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $dateReceived_err = "Please enter a valid date";
    } else{
        $dateReceived = $input_dateReceived;
    }

    $input_recipientSignature = trim($_POST["recipientSignature"]);
    if(empty($input_recipientSignature)){
        $recipientSignature_err = "Please enter Signature";
    } elseif(!filter_var($input_recipientSignature, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $recipientSignature_err = "Please enter a valid signature";
    } else{
        $recipientSignature = $input_recipientSignature;
    }

    if (empty($dateOrdered_err) && empty($purchaseNumber_err) && empty($distributorName_err) && empty($itemName_err) && empty($itemQuantity_err) && empty($itemNumber_err) && empty($dateReceived_err) && empty($recipientSignature_err)){

        $sql = "UPDATE sml SET distrubutorName=?, itemName=?, itemQuantity=?, itemNumber=?, dateReceived=?, reciepientSignature=? WHERE purchasenumber=?";

        if ($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("sssi", $param_dateOrdered, $param_distrbutorName, $param_itemName, $param_itemQuantity, $param_itemNumber, $param_dateReceived, $param_reciepientSignature, $param_purchaseNumber);

            $param_dateOrdered = $dateOrdered;
            $param_distrbutorName = $distributorName;
            $param_itemName = $itemName;
            $param_itemQuantity = $itemQuantity;
            $param_itemNumber = $itemNumber;
            $param_dateReceived = $dateReceived;
            $param_reciepientSignature = $recipientSignature;
            $param_purchaseNumber = $purchaseNumber;

            if($stmt->execute()){
                header("location: indexLog.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        $stmt->close();
    }

    $mysqli->close();

} else{
    
    if(isset($_GET["purchaseNumber"]) && !empty(trim($_GET["purchaseNumber"]))){
        $purchaseNumber = trim($_GET["purchaseNumber"]);

        $sql = "SELECT * FROM sml WHERE purchaseNumber = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("i", $param_purchaseNumber);

            $param_purchaseNumber = $purchaseNumber;

            if($stmt->execute()){
                $result = $stmt->get_result();

                if($result->num_rows == 1){
                    $row = $result->fetch_array(MYSQLI_ASSOC);

                    $distributorName = $row["distributorName"];
                    $itemName = $row["itemName"];
                    $itemQuantity = $row["itemQuantity"];
                    $itemNumber = $row["itemNumber"];
                    $dateReceived = $row["dateReceived"];
                    $recipientSignature = $row["recipientSignature"];
                } else{
                    header("location: ErrorPage.html");
                    exit();
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        $stmt->close();

        $mysqli->close();
    } else{

        header("location: ErrorPage.html");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>purchaseNumber</label>
                            <input type="text" name="purchaseNumber" class="form-control <?php echo (!empty($purchaseNumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $purchaseNumber; ?>">
                            <span class="invalid-feedback"><?php echo $purchaseNumber_err;?></span>
                        </div>
                        <input type="hidden" name="purchaseNumber" value="<?php echo $purchaseNumber; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>