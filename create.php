<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $appointmentidError = null;
        $totalamountError = null;
        $covered_by_insuranceError = null;
		$due_dateError = null;
         
        // keep track post values
        $appointmentid = $_POST['appointmentid'];
        $totalamount = $_POST['totalamount'];
        $covered_by_insurance = $_POST['covered_by_insurance'];
		$due_date = $_POST['due_date'];
         
        // validate input
        $valid = true;
        if (empty($appointmentid)) {
            $appointmentidError = 'Please enter appointment id';
            $valid = false;
        }
		
		if($appointmentid<0) {
			$appointmentidError=' please enter a right appointment id';
			$valid = false;
		}
         
        if (empty($totalamount)) {
            $totalamountError = 'Please enter total amount';
            $valid = false;
        }
		
		if($totalamount<0) {
			$totalamountError=' please enter a positive number';
			$valid = false;
		}
		
         
        if (empty($covered_by_insurance)) {
            $covered_by_insuranceError = 'Please enter amount paid by insurance';
            $valid = false;
        }
		
		if($covered_by_insurance<0) {
			$covered_by_insurance=' please enter a positive number';
			$valid = false;
		}
		
		if (empty($due_date)) {
            $due_dateError = 'Please enter due date';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO bill (appointmentid,totalamount,covered_by_insurance,due_date) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($appointmentid,$totalamount,$covered_by_insurance,$due_date));
            Database::disconnect();
            header("Location: index.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create a Bill</h3>
                    </div>
             
                    <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group <?php echo !empty($appointmentidError)?'error':'';?>">
                        <label class="control-label">Appointment ID</label>
                        <div class="controls">
                            <input name="appointmentid" type="number"  placeholder="" value="<?php echo !empty($appointmentid)?$appointmentid:'';?>">
                            <?php if (!empty($appointmentidError)): ?>
                                <span class="help-inline"><?php echo $appointmentidError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($totalamountError)?'error':'';?>">
                        <label class="control-label">Total Amount</label>
                        <div class="controls">
                            <input name="totalamount" id="text1" type="number" step="any" onblur="checkNumber(document.getElementById("text1").value) placeholder="" value="<?php echo !empty($totalamount)?$totalamount:'';?>">
                            <?php if (!empty($totalamountError)): ?>
                                <span class="help-inline"><?php echo $totalamountError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($covered_by_insuranceError)?'error':'';?>">
                        <label class="control-label">Amount Paid by Insurance</label>
                        <div class="controls">
                            <input name="covered_by_insurance" type="number" step="any" placeholder="" value="<?php echo !empty($covered_by_insurance)?$covered_by_insurance:'';?>">
                            <?php if (!empty($covered_by_insuranceError)): ?>
                                <span class="help-inline"><?php echo $covered_by_insuranceError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					  <div class="control-group <?php echo !empty($due_dateError)?'error':'';?>">
                        <label class="control-label">Due Date</label>
                        <div class="controls">
                            <input name="due_date" type="date"  placeholder="" value="<?php echo !empty($due_date)?$due_date:'';?>">
                            <?php if (!empty($due_dateError)): ?>
                                <span class="help-inline"><?php echo $due_dateError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
	
	<script>
	function checkNumber(sNum) {
    var pattern = /^\d+(.\d{1,2})?$/;
    console.log(sNum + " is " + ((pattern.test(sNum)) ? "" : "not ") + "valid.");
    }
	</script>
  </body>
</html>