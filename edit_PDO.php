<?php
include 'dblogin.php';
include 'editAssoc.php';

$get_id=$_REQUEST['ID'];

//$ID= $_POST['ID'];
$NAME= $_POST['NAME'];
$UNAME= $_POST['UNAME'];
$PASSWD= $_POST['PASSWD'];
$PRIVLEVEL= $_POST['PRIVLEVEL'];
$COMMISSION= $_POST['COMMISSION'];
$ADDRESS= $_POST['ADDRESS'];

$sql = "UPDATE ASSOCIATE SET NAME ='$NAME', UNAME ='$UNAME', PASSWD ='$PASSWD', PRIVLEVEL ='$PRIVLEVEL', 
COMMISSION ='$COMMISSION', ADDRESS ='$ADDRESS' WHERE ID = '$get_id' ";
//$query = $pdo->prepare($sql);
$pdo->exec($sql);
echo "<script>alert('Successfully Edited The Account!'); window.location='associates.php'</script>";


?>

