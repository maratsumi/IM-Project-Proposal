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

                $dateOrdered = $row["dateOrdered"];
                $distributorName = $row["distributorName"];
                $itemName = $row["itemName"];
                $itemQuantity = $row["itemQuantity"];
                $itemNumber = $row["itemNumber"];
                $dateReceived = $row["dateReceived"];
                $receipientSignature = $row["receipientSignature"];
            } else{
                header("location: ErrorPage.html");
                exit();
            }
        } else{
            echo "Something went wrong. Please try again later.";
        }
    }
} else {
    $purchaseNumber = $_GET["purchaseNumber"];
    $distributorName= $_POST["distributorName"];
    $itemName= $_POST["itemName"];
    $itemQuantity= $_POST["itemQuantity"];
    $itemNumber= $_POST["itemNumber"];
    $dateOrdered= $_POST["dateOrdered"];
    $dateReceived = $_POST["dateReceived"];
    $receipientSignature = $_POST["receipientSignature"];

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

    if (empty($dateOrdered_err) && empty($distributorName_err) && empty($itemName_err) && empty($itemQuantity_err) && empty($itemNumber_err) && empty($receipientSignature_err)){
        $sql = "UPDATE sml SET dateOrdered=?, distributorName=?, itemName=?, itemQuantity=?, itemNumber=?, dateReceived=?, receipientSignature=? WHERE purchasenumber=?";

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
}
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
              <input type="text" name="receipientSignature" class="form-control <?php echo (!empty($receipientSignature_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $receipientSignature; ?>">
              <span class="invalid-feedback"><?php echo $receipientSignature_err;?></span>
          </div>
          <input type="submit" class="btn btn-primary bg-blue-400" value="Submit">
          <a href="indexLog.php" class="btn btn-secondary ml-2">Cancel</a>
        </form>
      </div>
    </div>
  </body>
</html>