<?php

  /*
    Quote Details viewer action handler
    Joshua Sulouff
  */

  include_once 'dbfunctions.php';

  if (array_key_exists('TargetQuote', $_GET)) {
    $TargetQuote = $_GET['TargetQuote'];
  }
  else {
    echo "Invalid entry: no target quote";
  }

  function CheckGet($str) {
    return array_key_exists($str , $_GET);
  }

  function CheckPost($str) {
    return array_key_exists($str , $_POST);
  }

  function DeleteItem($kind,$id) {
    $tablename = "";
    switch ($kind) {
      case 'LIN':
        $tablename = "LINEITEM";
        break;

      case 'COM':
        $tablename = "NOTE";
        break;

      case 'DSC':
        $tablename = "DISCOUNT";
        break;

      default:
        echo "Invalid action type";
        break;
    }

    $sql = "delete from " . $tablename . " where ID=:id";
    echo $sql;
    $args = ['id' => $id];
    DB_doquery($sql, $args);
  }

  function CreateItem($kind) {
    $sql = "";
    $args = array();
    switch ($kind) {
      case 'LIN':
        $sql = "insert into LINEITEM (QID, PRICE, DESCRIPT) values (:qid, :price, :description)";
        $args = [
          'qid'         => $TargetQuote,
          'price'       => $_POST['NewLineItemPrice'],
          'description' => $_POST['NewLineItemDescript']
        ];
        break;

      case 'COM':
        $sql = "insert into NOTE (QID, STATEMENT) values (:qid, :statement)";
        $args = [
          'qid'         => $TargetQuote,
          'statement'   => $_POST['NewCommentText'],
        ];
        break;

      case 'DSC':
        $sql = "insert into DISCOUNT (QID, AMOUNT, DESCRIPT, PERCENTAGE)
                values (:qid, :amnt, :desc, :percent)"
        $PercentBool = ($_POST['NewDiscountPercent']) == 1;
        $args = [
          'qid'         => $TargetQuote,
          'amnt'        => $_POST['NewDiscountAmount'],
          'desc'        => $_POST['NewDiscountDescript']
          'percent'     => $PercentBool,
        ];
        break;

      default:
      echo "Invalid creation type";
        break;
    }

    DB_doquery($sql, $args);
  }

  //Udates the existing quote to match the working one
  function UpdateQuote() {
    if ($TargetQuote == -1) {
      //Upload
    }
    else {
      //Update
    }
  }


  { //Deal with Get operations

    //Destroy LineItem
    if (CheckGet("DestroyLIN")) { //10
      echo "delete line item : " . $_GET["DestroyLIN"] . "<br>";
      DeleteItem("LIN", $_GET["DestroyLIN"]);
    }

    if (CheckGet("DestroyCOM")) {
      echo "delete comment item : " . $_GET["DestroyCOM"] . "<br>";
      DeleteItem("COM", $_GET["DestroyCOM"]);
    }

    if (CheckGet("DestroyDSC")) {
      echo "delete line item : " . $_GET["DestroyDSC"] . "<br>";
      DeleteItem("DSC", $_GET["DestroyDSC"]);
    }

  }


  //Deal with submisison via post
  {
    if (CheckPost('Submit')) {

      echo "Edit quote <br>";

      echo "Change Customer ID to "    . $_POST['NewCustomerID'] . "<br>";
      echo "Change Email ID to "       . $_POST['NewEmail']      . "<br>";
      echo "Change Description to "    . $_POST['NewDescript']   . "<br>";

      echo "Change Status to "         . $_POST['NewStatus']   . "<br>";;


      if (CheckPost('NewLineItemDescript')) {
        echo "New Line Item: " . $_POST['NewLineItemDescript'] . " Price: " . $_POST['NewLineItemPrice'] . "<br>";
      }

      if (CheckPost('NewCommentText')) {
        echo "New Comment: " . $_POST['NewCommentText'] . "<br>";
      }

      if (CheckPost('NewDiscount')) {
        echo "New Discount";
      }

    }
    else if (CheckPost('Reload'))
    {
      echo "Reload quote <br>";
    }
  }

  echo "<a href=\"QuoteDetails.new.php?TargetQuote=". $TargetQuote ."\">go back</a>";

 ?>
 <br>
