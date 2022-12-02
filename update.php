<?php
require_once "config.php";

$purchaseNumber = $distributorName = $itemName = $itemQuantity = $itemNumber = $dateOrdered = $recipientSignature = "";

$distributorName_err = $itemName_err = $itemQuantity_err = $itemNumber_err = $dateOrdered_err = $recipientSignature_err = "";

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

                $dateOrdered = $row["dateOrdered"];
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
} else {
    $purchaseNumber = $_POST["purchaseNumber"];
    $distributorName= $_POST["distributorName"];
    $itemName= $_POST["itemName"];
    $itemQuantity= $_POST["itemQuantity"];
    $itemNumber= $_POST["itemNumber"];
    $recipientSignature = $_POST["recipientSignature"];
    $dateOrdered= $_POST["dateOrdered"];

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

    if (empty($dateOrdered_err) && empty($distributorName_err) && empty($itemName_err) && empty($itemQuantity_err) && empty($itemNumber_err) && empty($dateReceived_err) && empty($recipientSignature_err)){

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
}

// if(isset($_POST["purchaseNumber"]) && !empty ($_POST["purchaseNumber"])){
//     $purchaseNumber = $_POST["purchaseNumber"];

//     $input_dateOrdered = trim($_POST["dateOrdered"]);
//     if(empty ($input_dateOrdered)){
//         $dateOrdered_err = "Please enter valid Date";
//       } elseif(!filter_var($input_dateOrdered, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/")))){
//         $dateOrdered_err = "Please enter a valid Date";
//       } else {
//         $dateOrderedString = $input_dateOrdered;
//         $dateOrdered = strtotime($dateOrderedString);
//         date("Y-m-d", $dateOrdered);
//       }

//     $input_distributorName = trim($_POST["distributorName"]);
//     if(empty($input_distributorName)){
//         $distributorName_err = "Please enter Distributor Name";
//     } elseif(!filter_var($input_distributorName, FILTER_VALIDATE_REGEXP,
//     array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
//         $distributorName_err = "Please enter a valid name";
//     } else{
//         $distributorName = $input_distributorName;
//     }

//     $input_itemName = trim($_POST["itemName"]);
//     if(empty($input_itemName)){
//         $itemName_err = "Please enter Item Name";
//     } elseif(!filter_var($input_itemName, FILTER_VALIDATE_REGEXP,
//     array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
//         $itemName_err = "Please enter a valid name";
//     } else{
//         $itemName = $input_itemName;
//     }

//     $input_itemQuantity = trim($_POST["itemQuantity"]);
//     if(empty($input_itemQuantity)){
//         $itemQuantity_err = "Please enter Item Quantity";
//     } elseif(!filter_var($input_itemQuantity, FILTER_VALIDATE_REGEXP,
//     array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
//         $itemQuantity_err = "Please enter a valid number";
//     } else{
//         $itemQuantity = $input_itemQuantity;
//     }

//     $input_itemNumber = trim($_POST["itemNumber"]);
//     if(empty($input_itemNumber)){
//         $itemNumber_err = "Please enter Item Quantity";
//     } elseif(!filter_var($input_itemNumber, FILTER_VALIDATE_REGEXP,
//     array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
//         $itemNumber_err = "Please enter a valid number";
//     } else{
//         $itemNumber = $input_itemNumber;
//     }

//     $input_dateReceived = trim($_POST["dateReceived"]);
//     if(empty($input_dateReceived)){
//         $dateReceived_err = "Please enter Date Received";
//     } elseif(!filter_var($input_dateReceived, FILTER_VALIDATE_REGEXP,
//     array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
//         $dateReceived_err = "Please enter a valid date";
//     } else{
//         $dateReceived = $input_dateReceived;
//     }

//     $input_recipientSignature = trim($_POST["recipientSignature"]);
//     if(empty($input_recipientSignature)){
//         $recipientSignature_err = "Please enter Signature";
//     } elseif(!filter_var($input_recipientSignature, FILTER_VALIDATE_REGEXP,
//     array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
//         $recipientSignature_err = "Please enter a valid signature";
//     } else{
//         $recipientSignature = $input_recipientSignature;
//     }

//     if (empty($dateOrdered_err) && empty($distributorName_err) && empty($itemName_err) && empty($itemQuantity_err) && empty($itemNumber_err) && empty($dateReceived_err) && empty($recipientSignature_err)){

//         $sql = "UPDATE sml SET distrubutorName=?, itemName=?, itemQuantity=?, itemNumber=?, dateReceived=?, reciepientSignature=? WHERE purchasenumber=?";

//         if ($stmt = $mysqli->prepare($sql)){
//             $stmt->bind_param("sssi", $param_dateOrdered, $param_distrbutorName, $param_itemName, $param_itemQuantity, $param_itemNumber, $param_dateReceived, $param_reciepientSignature, $param_purchaseNumber);

//             $param_dateOrdered = $dateOrdered;
//             $param_distrbutorName = $distributorName;
//             $param_itemName = $itemName;
//             $param_itemQuantity = $itemQuantity;
//             $param_itemNumber = $itemNumber;
//             $param_dateReceived = $dateReceived;
//             $param_reciepientSignature = $recipientSignature;
//             $param_purchaseNumber = $purchaseNumber;

//             if($stmt->execute()){
//                 header("location: indexLog.php");
//                 exit();
//             } else{
//                 echo "Something went wrong. Please try again later.";
//             }
//         }

//         $stmt->close();
//     }

//     $mysqli->close();

// } else{
    
//     if(isset($_GET["purchaseNumber"]) && !empty(trim($_GET["purchaseNumber"]))){
//         $purchaseNumber = trim($_GET["purchaseNumber"]);

//         $sql = "SELECT * FROM sml WHERE purchaseNumber = ?";
        
//         if($stmt = $mysqli->prepare($sql)){
//             $stmt->bind_param("i", $param_purchaseNumber);

//             $param_purchaseNumber = $purchaseNumber;

//             if($stmt->execute()){
//                 $result = $stmt->get_result();

//                 if($result->num_rows == 1){
//                     $row = $result->fetch_array(MYSQLI_ASSOC);

//                     $distributorName = $row["distributorName"];
//                     $itemName = $row["itemName"];
//                     $itemQuantity = $row["itemQuantity"];
//                     $itemNumber = $row["itemNumber"];
//                     $dateReceived = $row["dateReceived"];
//                     $recipientSignature = $row["recipientSignature"];
//                 } else{
//                     header("location: ErrorPage.html");
//                     exit();
//                 }
//             } else{
//                 echo "Something went wrong. Please try again later.";
//             }
//         }

//         $stmt->close();

//         $mysqli->close();
//     } else{

//         header("location: ErrorPage.html");
//         exit();
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./components/output.css" />
    <title>Dashboard</title>
  </head>
  <body class="bg-slate-200">
    <div class="w-full h-full flex">
      <div
        class="h-full w-[200px] fixed z-10 top-0 left-0 bg-slate-800 overflow-x-hidden text-center shadow-md"
      >
        <h1 class="text-5xl text-slate-100 pb-10 p-5">SML</h1>
        <a
          href="index.html"
          class="text-lg block text-slate-800 bg-slate-200 px-3 py-5 mx-auto"
          ><img
            src="./assets/dash_d.png"
            class="h-10 w-auto mx-auto"
          />Dashboard</a
        >

        <a
          href="indexLogsMain.html"
          class="text-lg block text-slate-200 px-3 py-5 mx-auto"
          ><img
            src="./assets/logs.png"
            class="h-10 w-auto mx-auto"
          />Logs</a
        >

        <a
          href="indexLog.php"
          class="text-lg block text-slate-200 px-3 py-5 mx-auto"
          ><img src="./assets/notes.png" class="h-10 w-auto mx-auto" />
          Notes</a
        >
      </div>
      <div class="ml-[200px] p-10">
        <h1 class="text-4xl font-semibold">Logs</h1>
        <h2 class="text-3xl">Create a record</h2>
        <h3 class="text-2xl">Fill up the form below.</h3>
        <form method="post">
            <input type="hidden" value="<?php echo $purchaseNumber; ?>">
          <div class="form-group">
              <label>Date Ordered (YYYY-MM-DD H:M:S)</label>
              <input type="text" name="dateOrdered" class="form-control <?php echo (!empty($dateOrdered_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dateOrdered; ?>">
          </div>
          <div class="form-group">
              <label>Distributor Name</label>
              <input type="text" name="distributorName" class="form-control <?php echo (!empty($distributorName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $distributorName; ?>">
              <span class="invalid-feedback"><?php echo $distributorName_err;?></span>
          </div>
          <div class="form-group">
              <label>Item Name</label>
              <input type="text" name="itemName" class="form-control <?php echo (!empty($itemName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $itemName; ?>">
              <span class="invalid-feedback"><?php echo $itemName_err;?></span>
          </div>
          <div class="form-group">
              <label>Item Quantity</label>
              <input type="text" name="itemQuantity" class="form-control <?php echo (!empty($itemQuantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $itemQuantity; ?>">
              <span class="invalid-feedback"><?php echo $itemQuantity_err;?></span>
          </div>
          <div class="form-group">
              <label>Item Number</label>
              <input type="text" name="itemNumber" class="form-control <?php echo (!empty($itemNumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $itemNumber; ?>">
              <span class="invalid-feedback"><?php echo $itemNumber_err;?></span>
          </div>
          <div class="form-group">
              <label>Date Received</label>
              <input type="text" name="dateReceived" class="form-control <?php echo (!empty($dateReceived_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dateReceived; ?>">
          </div>
          <div class="form-group">
              <label>Recipient Name</label>
              <input type="text" name="recipientSignature" class="form-control <?php echo (!empty($recipientSignature_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recipientSignature; ?>">
              <span class="invalid-feedback"><?php echo $recipientSignature_err;?></span>
          </div>
          <input type="submit" class="btn btn-primary" value="Submit">
          <a href="indexLog.php" class="btn btn-secondary ml-2">Cancel</a>
        </form>
      </div>
    </div>
  </body>
</html>