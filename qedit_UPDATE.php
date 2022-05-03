<?php
include 'dblogin.php';
include 'QuoteEdit.php';

$get_qid = $_REQUEST['QID'];

//$ID= $_POST['ID'];
$QID= $_POST['QuoteID'];
$EMAIL= $_POST['EMAIL'];
$STATUS = $_POST['STATUS'];
$DESCRIPT= $_POST['Label'];
$CHARGE= $_POST['Charge'];
$STATEMENT= $_POST['Statement'];
$AMOUNT= $_POST['Amount'];

$sql = "UPDATE SQUOTE SET QID ='$QID', EMAIL = '$EMAIL', STATUS = '$STATUS' WHERE QID = '$get_qid' ";
$sql2 = "UPDATE LINEITEM SET QID = '$QID', DESCRIPT = '$DESCRIPT', PRICE = '$CHARGE' WHERE QID = '$get_qid' ";
$sql3 = "UPDATE NOTE SET QID = '$QID', STATEMENT = '$STATEMENT' WHERE QID = '$get_qid' ";
$sql4 = "UPDATE DISCOUNT SET QID = '$QID', AMOUNT = '$AMOUNT' WHERE QID = '$get_qid' ";
//$query = $pdo->prepare($sql);
$pdo->exec($sql);
$pdo->exec($sql2);
$pdo->exec($sql3);
$pdo->exec($sql4);
echo "<script>alert('Quote Edited!'); window.location='viewQuotes.php'</script>";


?>