<?php
require_once "config.php";

  $purchaseNumber = $distributorName = $itemName = $itemQuantity = $itemNumber = $receipientSignature = $dateOrdered = $dateReceived = "";
  $distributorName_err = $itemName_err = $itemQuantity_err = $itemNumber_err = $receipientSignature_err = $dateOrdered_err = $dateReceived_err = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    if (!isset($_GET["purchaseNumber"])){
        header("ErrorPage.html");
        exit;
    }

    $purchaseNumber = trim($_GET["purchaseNumber"]);
    $sql = "SELECT * FROM sml WHERE purchaseNumber = ?";
        
    if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("i", $param_purchaseNumber);

        $param_purchaseNumber = $purchaseNumber;

        if($stmt->execute()){
            $result = $stmt->get_result();

            if($result->num_rows == 1){
                $row = $result->fetch_array(MYSQLI_ASSOC);

$distributorName_err = $itemName_err = $itemQuantity_err = $itemNumber_err = $recipientName_err = $dateOrdered_err = "";
>>>>>>> Stashed changes

if(isset($_POST["purchaseNumber"]) && !empty ($_POST["purchaseNumber"])){
    $purchaseNumber = $_POST["purchaseNumber"];
    $input_dateOrdered = trim($_POST["dateOrdered"]);
    
    if(empty ($input_dateOrdered)){
      $dateOrdered_err = "Please enter valid Date";
    } elseif(!filter_var($input_dateOrdered, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^(((\d{4})(-)(0[13578]|10|12)(-)(0[1-9]|[12][0-9]|3[01]))|((\d{4})(-)(0[469]|1‌​1)(-)([0][1-9]|[12][0-9]|30))|((\d{4})(-)(02)(-)(0[1-9]|1[0-9]|2[0-8]))|(([02468]‌​[048]00)(-)(02)(-)(29))|(([13579][26]00)(-)(02)(-)(29))|(([0-9][0-9][0][48])(-)(0‌​2)(-)(29))|(([0-9][0-9][2468][048])(-)(02)(-)(29))|(([0-9][0-9][13579][26])(-)(02‌​)(-)(29)))(\s([0-1][0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9]))$/")))){
      $dateOrdered_err = "Please enter a valid Date";
    } else {
      $time = strtotime($input_dateOrdered);
      $dateOrdered = date('Y-m-d H:i:s', $time);
    }

    $input_distName = trim($_POST["distributorName"]);
    if(empty ($input_distName)){
      $distributorName_err = "Please enter Distributor Name";
    } elseif(!filter_var($input_distName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))){
      $distributorName_err = "Please enter a valid name";
    } else {
      $distributorName = $input_distName;
    }
          
    $input_itemName = trim($_POST["itemName"]);
    if(empty ($input_itemName)){
      $itemName_err = "Please enter Item Name";
    } elseif(!filter_var($input_itemName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))){
      $itemName_err = "Please enter a valid Item Name";
    } else {
      $itemName = $input_itemName;
    }
          
    $input_itemQuantity = trim($_POST["itemQuantity"]);
    if(empty ($input_itemQuantity)){
      $itemQuantity_err = "Please enter Item Quantity";
    } elseif(!ctype_digit($input_itemQuantity)){
      $itemQuantity_err = "Please enter a valid Item Quantity";
    } else {
      $itemQuantity = $input_itemQuantity;
    }

    $input_itemNumber = trim($_POST["itemNumber"]);
    if(empty ($input_itemNumber)){
      $itemNumber_err = "Please enter Item Number";
    } elseif(!ctype_digit($input_itemNumber)){
      $itemNumber_err = "Please enter a valid Item Number";
    } else {
      $itemNumber = $input_itemNumber;
    }
          

    $input_receipientSignature = trim($_POST["receipientSignature"]);
    if(empty ($input_receipientSignature)){
      $receipientSignature_err = "Please enter Recipient Name";
    } elseif(!filter_var($input_receipientSignature, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))){
      $receipientSignature_err = "Please enter a valid Recipient Name";
    } else {
      $receipientSignature = $input_receipientSignature;
    }

    if (empty($dateOrdered_err) && empty($purchaseNumber_err) && empty($distributorName_err) && empty($itemName_err) && empty($itemQuantity_err) && empty($itemNumber_err) && empty($dateReceived_err) && empty($recipientSignature_err)){

        if($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("sssiissi", $param_dateOrder, $param_distName, $param_itemName, $param_itemQuantity, $param_itemNum, $param_dateReceived, $param_recipient, $param_purchaseNumber);
                
            $param_dateOrder = $dateOrdered;
            $param_distName = $distributorName;
            $param_itemName = $itemName;
            $param_itemQuantity = $itemQuantity;
            $param_itemNum = $itemNumber;
            $param_dateReceived = $dateReceived;
            $param_recipient = $receipientSignature;
            $param_purchaseNumber = $purchaseNumber;

            if($stmt->execute()){
                header("location: indexLog.php");
                exit();
            } else {
            echo "An error occurred. Please try again.";
            }
        }
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