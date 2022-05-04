<?php

  /*
    Quote Details viewer action handler
    Joshua Sulouff
  */

  function CheckGet($str) {
    return array_key_exists($str , $_GET);
  }

  function CheckPost($str) {
    return array_key_exists($str , $_POST);
  }

  { //Deal with Get operations

    //Destroy LineItem
    if (CheckGet("DestroyLIN")) {
      echo "delete line item : " . $_GET["DestroyLIN"] . "<br>";
    }

    if (CheckGet("DestroyCOM")) {
      echo "delete comment item : " . $_GET["DestroyCOM"] . "<br>";
    }

    if (CheckGet("DestroyDSC")) {
      echo "delete line item : " . $_GET["DestroyDSC"] . "<br>";
    }

  }


  //Deal with submisison via post
  {
    if (CheckPost('Submit')) {
      $WorkQuote = &$_POST['WorkQuote'];
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
    else if ($_POST['Reload'])
    {
      echo "Reload quote <br>";
    }
  }



 ?>
 <br>
<a href="QuoteDetails.new.php"> go back </a>
