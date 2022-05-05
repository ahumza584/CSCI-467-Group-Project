<?php

  /*
    Quote Details viewer action handler
    Joshua Sulouff
  */

  session_start();

  print_r($_POST);

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

  function CreateLineItem(float $Price, string $Description) {
    global $TargetQuote;
    if ($Price <= 0.00 || is_string($Price)) {
      echo "Bad input for price.";
      return;
    }
    $sql = "insert into LINEITEM (QID, PRICE, DESCRIPT) values (:qid, :price, :description)";
    $args = [
      'qid'         => $TargetQuote,
      'price'       => $Price,
      'description' => $Description
    ];
    DB_doquery($sql, $args);
  }

  function CreateComment(string $Text) {
    if ($Text == '') {
      return;
    }
    global $TargetQuote;
    $sql = "insert into NOTE (QID, STATEMENT) values (:qid, :statement)";
    $args = [
      'qid'         => $TargetQuote,
      'statement'   => $Text,
    ];
    DB_doquery($sql, $args);
  }

  function CreateDiscount(float $Amount, string $Description, bool $PercentBool) {
    global $TargetQuote;
    if ($Amount == 0.0) {
      echo "Bad input for amount.";
      return;
    }
    $sql = "insert into DISCOUNT (QID, AMOUNT, DESCRIPT, PERCENTAGE)
            values (:qid, :amnt, :desc, :percent)";
    $args = [
      'qid'         => $TargetQuote,
      'amnt'        => $Amount,
      'desc'        => $Description,
      'percent'     => $PercentBool,
    ];

    if ($PercentBool) {
      $args['percent'] = "1";
    }
    else {
      $args['percent'] = "0";
    }
    DB_doquery($sql, $args);
  }

  //Udates the existing quote to match the working one
  function UpdateQuote() {
    global $TargetQuote;
    global $pdo;
    if ($TargetQuote == -1) {
      //Upload
      $sql = "insert into SQUOTE (OWNER, CUSTOMERID, EMAIL, DESCRIPT, STATUS)
              values (:uid, :cid, :email, :descript, 'PRELIM')";
      $args = [
        'uid' =>  $_SESSION['UID'],
        'cid' => $_POST['NewCustomerID'],
        'email' => $_POST['NewEmail'],
        'descript' => $_POST['NewDescript']
      ];

      DB_doquery($sql, $args);
      $TargetQuote = $pdo->LastInsertId();

    }
    else {
      $sql = "update SQUOTE set CUSTOMERID = :cid, EMAIL = :email, DESCRIPT = :desc, UPDATED = CURRENT_TIMESTAMP";
      $args = [
        'cid' => $_POST['NewCustomerID'],
        'email' => $_POST['NewEmail'],
        'desc' => $_POST['NewDescript']
      ];

      DB_doquery($sql, $args);
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
    /*
      Update quote info
    */

    if (CheckPost('Submit')) {
      UpdateQuote();
      echo "Edit quote <br>";

      echo "Change Customer ID to "    . $_POST['NewCustomerID'] . "<br>";
      echo "Change Email ID to "       . $_POST['NewEmail']      . "<br>";
      echo "Change Description to "    . $_POST['NewDescript']   . "<br>";

      echo "Change Status to "         . $_POST['NewStatus']   . "<br>";;


      if (CheckPost('NewLineItemDescript') && CheckPost('NewLineItemPrice')) {
        echo "New Line Item: " . $_POST['NewLineItemDescript'] . " Price: " . $_POST['NewLineItemPrice'] . "<br>";
        CreateLineItem(floatval($_POST['NewLineItemPrice']),$_POST['NewLineItemDescript']);
      }

      if (CheckPost('NewCommentText')) {
        echo "New Comment: " . $_POST['NewCommentText'] . "<br>";
        CreateComment($_POST['NewCommentText']);
      }

      if (CheckPost('NewDiscountAmount') && CheckPost('NewDiscountDescript')) {
        echo "New Discount";
        $PercBool = CheckPost('NewDiscountPercent');
        CreateDiscount(floatval($_POST["NewDiscountAmount"]), $_POST["NewDiscountDescript"], $PercBool);
      }

    }
    else if (CheckPost('Reload'))
    {
      echo "Reload quote <br>";
    }
  }

  $retUrl = "QuoteDetails.new.php?TargetQuote=". $TargetQuote;
  if (isset($message)) {
    $retUrl += "&message=" . $message;
  }

  echo "<a href=\"". $retUrl . "\">go back</a>";

 ?>
 <br>
