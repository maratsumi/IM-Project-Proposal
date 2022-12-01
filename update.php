<?php
require_once "config.php";

$purchaseNumber = $distributorName = $itemName = $itemQuantity = $itemNumber = $dateReceived = $recipientSignature = "";

$purchaseNumber_err = $distributorName_err = $itemName_err = $itemQuantity_err = $itemNumber_err = $dateReceived_err = $recipientSignature_err = "";

if(isset($_POST["purchaseNumber"]) && !empty ($_POST["purchaseNumber"])){
    $id = $_POST["purchaseNumber"];

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
        $itemNumber = "Please enter a valid number";
    } else{
        $itemNumber = $input_itemNumber;
    }

    $input_dateReceived = trim($_POST["dateReceived"]);
    if(empty($input_dateReceived)){
        $dateReceived_err = "Please enter Date Received";
    } elseif(!filter_var($input_dateReceived, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $dateReceived = "Please enter a valid date";
    } else{
        $dateReceived = $input_dateReceived;
    }

    $input_recipientSignature = trim($_POST["recipientSignature"]);
    if(empty($input_recipientSignature)){
        $recipientSignature_err = "Please enter Signature";
    } elseif(!filter_var($input_recipientSignature, FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $recipientSignature = "Please enter a valid signature";
    } else{
        $recipientSignature = $input_recipientSignature;
    }

    if (empty($distributorName_err) && empty($itemName_err) && empty($itemQuantity_err) && empty($itemNumber_err) && empty($dateReceived_err) && empty($recipientSignature_err)){

        $sql = "UPDATE test.sml SET distrubutorName=?, itemName=?, itemQuantity=?, itemNumber=?, dateReceived=?, reciepientSignature=? WHERE purchasenumber=?";

        if ($stmt = $mysqli->prepare($sql)){
            $stmt->bind_param("sssi", $param_distrbutorName, $param_itemName, $param_itemQuantity, $param_itemNumber, $param_dateReceived, $param_reciepientSignature, $param_purchaseNumber);

            $param_distrbutorName = $distributorName;
            $param_itemName = $itemName;
            $param_itemQuantity = $itemQuantity;
            $param_itemNumber = $itemNumber;
            $param_dateReceived = $dateReceived;
            $param_reciepientSignature = $recipientSignature;
            $param_purchaseNumber = $purchaseNumber;

            if($stmt->execute()){
                header("location: index.php");
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

        $sql = "SELECT * FROM test.sml WHERE purchaseNumber = ?";
        
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
                    header("location: error.php");
                    exit();
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        $stmt->close();

        $mysqli->close();
    } else{

        header("location: error.php");
        exit();
    }
}

