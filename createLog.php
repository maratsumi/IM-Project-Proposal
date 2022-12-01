<?php
  require_once "config.php";
  $purchaseNumber = $distributorName = $itemName = $itemQuantity = $itemNumber = $recipientName = "";
  $purchaseNumber_err = $distributorName_err = $itemName_err = $itemQuantity_err = $itemNumber_err = $recipientName_err = "";

  date_default_timezone_get();
  $dateOrdered = date('Y-m-d H:i:s', time());

  if($SERVER["REQUEST METHOD"] == "POST"){
    $input_purchaseNum = trim($_POST["purchaseNumber"]);
    if(empty ($input_purchaseNum)){
      $purchaseNumber_err = "Please enter Purchase Number";
    } elseif(!ctype_digit($input_purchaseNum)){
      $purchaseNumber_err = "Please enter a valid Purchase Number";
    } else {
      $purchaseNumber = $input_purchaseNum;
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
      $purchaseNumber_err = "Please enter Item Number";
    } elseif(!filter_var($input_itemName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))){
      $itemName_err = "Please enter a valid Item Number";
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
      $itemNumber_err = "Please enter Purchase Number";
    } elseif(!ctype_digit($input_itemNumber)){
      $itemNumber_err = "Please enter a valid Purchase Number";
    } else {
      $itemNumber = $input_itemNumber;
    }
          
    date_default_timezone_get();
    $dateReceived = date('Y-m-d H:i:s', time());

    $input_recipientName = trim($_POST["recipientName"]);
    if(empty ($input_recipientName)){
      $recipientName_err = "Please enter Purchase Number";
    } elseif(!filter_var($input_recipientName, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))){
      $recipientName_err = "Please enter a valid Purchase Number";
    } else {
      $recipientName = $input_recipientName;
    }
          
    if(empty($purchaseNumber_err) && empty($purchaseNumber_err) && empty($distributorName_err) && empty($itemName_err) && empty($itemNumber_err) && empty($recipientName_err)){
      $sql = "INSERT INTO sml (dateOrdered, purchaseNumber, distributorName, itemName, itemQuantity, itemNumber, dateReceived, receipientSignature) VALUES (?, ?, ?, ?, ?, ?, ?)";
      if($stmt = $mysqli->prepare($sql)){
        $stmt->bind_param("sss", $param_dateOrder, $param_purchaseNum, $param_distName, $param_itemName, $param_itemQuantity, $param_itemNum, $param_dateReceived, $param_recipient);
                
        $param_dateOrder = $dateOrdered;
        $param_purchaseNum = $purchaseNumber;
        $param_distName = $distributorName;
        $param_itemName = $itemName;
        $param_itemQuantity = $itemQuantity;
        $param_itemNum = $itemNumber;
        $param_dateReceived = $dateReceived;
        $param_recipient = $recipientName;

        if($stmt->execute()){
          header("location: indexLog.php");
          exit();
        } else {
          echo "An error occurred. Please try again.";
        }
      }
    }
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
          href="indexLog.html"
          class="text-lg block text-slate-200 px-3 py-5 mx-auto"
          ><img src="./assets/notes.png" class="h-10 w-auto mx-auto" />
          Notes</a
        >
      </div>
      <div class="ml-[200px] p-10">
        <h1 class="text-4xl font-semibold">Logs</h1>
        <h2 class="text-3xl">Create a record</h2>
        <h3 class="text-2xl">Fill up the form below.</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group">
              <label>Date Ordered</label>
              <input type="text" name="dateOrdered" class="form-control <?php echo (!empty($dateOrdered_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dateOrdered; ?>">
          </div>
          <div class="form-group">
              <label>Purchase Number</label>
              <input type="text" name="purchaseNumber" class="form-control <?php echo (!empty($purchaseNumber_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $purchaseNumber; ?>">
              <span class="invalid-feedback"><?php echo $purchaseNumber_err;?></span>
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
              <input type="text" name="recipientName" class="form-control <?php echo (!empty($recipientName_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $recipientName; ?>">
              <span class="invalid-feedback"><?php echo $recipientName_err;?></span>
          </div>
          <input type="submit" class="btn btn-primary" value="Submit">
          <a href="indexLog.php" class="btn btn-secondary ml-2">Cancel</a>
        </form>
      </div>
    </div>
  </body>
</html>