<?php

 /* This document will display a dialog using the following POST info
  * QuoteId -> The ID of the quote to be modified
  *
  * It will list the line items + 1 blank one
  * self referencing forms should store the contents of the blank
  *
  *
  */
  include 'dblogin.php';
  error_reporting(E_ALL);

  echo "<h1>Edit Quote</h1>";
  $Quoteid = $_GET['QID'];
 ?>

<div class="hero-unit-3">

<?php
$result = $pdo->prepare("SELECT * FROM SQUOTE, LINEITEM, NOTE, DISCOUNT where QID='$Quoteid'");
$result->execute();
echo ($Quoteid);
for($i=0; $row = $result->fetch(); $i++){
$Quoteid=$row['QID'];
?>

<form class="form-horizontal" method="post" action="qedit_UPDATE.php<?php echo '?ID ='.$id; ?>"  enctype="multipart/form-data" style="float: center;">
                                <a href="viewQuotes.php" class="btn">Back</a> <br>
                                <h1>Edit Quote Information</h1>
                                
								<div class="control-group">
                                    <label style="font-weight: bold;" class="control-label">QID:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="QuoteId" required value=<?php echo $row['QID']; ?>> <br><br>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label style="font-weight: bold;" class="control-label">Email:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="EMAIL" required value=<?php echo $row['EMAIL']; ?>> <br><br>
                                    </div>
                                </div>
                                <!-- STATUS UPDATE FORM -->
								<div class="control-group">
                                    <input type = "radio" name = "STATUS" id = "PRELIM" value = "Preliminary">
                                    <label for = "PRELIM">Preliminary</label><br>
                                    <input type = "radio" name = "STATUS" id = "FINAL" value = "Finalized">
                                    <label for = "FINAL">Finalized</label><br>
                                    <input type = "radio" name = "STATUS" id = "SANCT" value = "Sanctioned">
                                    <label for = "SANCT">Sanctioned</label><br>
                                </div>
                                <div class="control-group">
                                    <label style="font-weight: bold;" class="control-label">Line Items:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="Label" required value=<?php echo $row['DESCRIPT']; ?>> <br><br>
                                        <input type="text" style="height:5%" name="Charge" required value=<?php echo $row['PRICE']; ?>> <br><br>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label style="font-weight: bold;" class="control-label">Note:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="Statement" required value=<?php echo $row['STATEMENT']; ?>> <br><br>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label style="font-weight: bold;" class="control-label">Discount:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="Amount" required value=<?php echo $row['AMOUNT']; ?>> <br><br>
                                    </div>
                                </div>
								 <div class="control-group">
                                    <div class="controls">

                                        <button type="submit" name="update" class="btn btn-success" style="margin-right: 65px;">Save</button>
                                    </div>
                                </div>
                            </form>
<?php } ?>

</body>
</html>
