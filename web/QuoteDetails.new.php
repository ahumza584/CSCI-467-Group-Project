<?php

include_once 'activate_debug.php';
include_once 'dbfunctions.php';
include_once 'miscfuncs.php';

print_html_header();


// ============== setup ================== //

session_start();

function NewWorkQuote() {
  $mstr = [];
  $mstr[0] = ['QuoteId' => -1, 'OwnerID' => $_SESSION['UID'], 'Email' => "", 'Description' => ""];
  $mstr[1] = [];
  $mstr[2] = [];
  $mstr[3] = [];

  return $mstr;
}

function LoadWorkQuote(int $qid) {
  $Quote = GetOrderById($qid);

  return $Quote;
}

if (array_key_exists('TargetQuote', $_GET)) {
  $WorkQuote = LoadWorkQuote($_GET['TargetQuote']);
}
else //New Quote
{
  $WorkQuote = NewWorkQuote();
}

// Set reference for readability
$QuoteInfo =     &$WorkQuote[0];
$LineItems =     &$WorkQuote[1];
$NoteItems =     &$WorkQuote[2];
$DiscountItems = &$WorkQuote[3];
$TargetQuote =    $QuoteInfo['QuoteId'];


print_r($LineItems);

$Owner = ($QuoteInfo['OwnerId'] == $_SESSION['UID']);

// ================================================= //

// returns: [[Name, Id], ... ]
function GetCustomers() {
  global $extpdo;
  $sql = "select * from customers";
  $res = $extpdo->query($sql);
  $res = $res->fetchALL(PDO::FETCH_ASSOC);

  //print_r($res);

  $mstr = [];
  foreach ($res as $customer) {
    $mstr[] = [
      'Name' => $customer['name'],
      'Id' => $customer['id']
    ];
  }
  return $mstr;
}

// generates a dropdown box for selecting customers
// Uses $Name as the field name or default
function Generate_Customer_Choice($label ,$Name="CustomerId") {
  //Generate selected first
  $Customers = GetCustomers();
  ////print_r($Customers);

  echo "<label for=\"$label\">". $label ."</label>";
  echo "<select id=\"" . $label . "\" name=\"" . $Name . "\">";

  //If there is a working customer
  if (array_key_exists($QuoteInfo['CustomerId'])) {
    foreach ($Customers as $Customer) {
      echo "<option value=\"" . $Customer['Id'] . "\"";

      if ($Customer['Id'] == $QuoteInfo['CustomerId']) {
        echo " selected ";
      }

      echo ">" . $Customer['Name'] . "<>";
    }
  }
  else {
    foreach ($Customers as $Customer) {
      echo "<option value=\"" . $Customer['Id'] . "\"> ". $Customer['Name'] ." </option>";
    }
  }

  echo "</select>";
}

function Generate_Textbox($label, $Field, $DefaultText = "") {
  echo "<label for=\"" . $Field . "\">" . $label . "</label>";
  echo "<input id=\"". $Field ."\" name=\"". $Field ."\" type=\"text\" value=\"" . $DefaultText . "\">";
}

function Generate_Destroy_Link($kind, $id) {
  global $TargetQuote;
  return "<a href=\"QuoteAction.php?Destroy" . $kind ."=" . $id . "&TargetQuote=" . $TargetQuote . "\">Delete</a>";
}

echo "<h1> Quote editing</h1>";
echo "<form action=\"QuoteAction.php\" method=\"post\">";
  echo "Quote #" . $QuoteInfo['QuoteId'] . "<br>";
  echo "Subtotal: $" . $QuoteInfo['Subtotal'] . "<br>";
  echo "Subtotal (with discounts): $" . $QuoteInfo['DiscountTotal'] . "<br>";
  echo "<div>";
    Generate_Customer_Choice("Customer: ", "NewCustomerID"); echo "<br>";
    Generate_Textbox("Email: ", "NewEmail", $QuoteInfo['Email']);  echo "<br>";
    Generate_Textbox("Description: ", "NewDescript", $QuoteInfo['Description']);  echo "<br>";
    "Status: " . $QuoteInfo['Status'] . "<br>";
    echo "</div>";

  { //Output line items
    echo "<h2>Line Items</h2><table>";
      echo "<tr><th>Charge</th><th>Label</th></tr>";

      foreach ($LineItems as $LineItem) {
        echo "<tr>";
          echo "<td>" . $LineItem['Charge'] . "</td>";
          echo "<td>" . $LineItem['Label'] . "</td>";
          echo "<td>" . Generate_Destroy_Link("LIN", $LineItem['Id']) . "</td>";
        echo "</tr>";
      }

    echo "</table>";
    echo "<div> New line item <br>";
    Generate_Textbox("Description: ", "NewLineItemDescript", ""); echo "<br>";
    Generate_Textbox("Price: ", "NewLineItemPrice", ""); echo "<br>";
    echo "</div>";
  }

  { //OUtput comments ////
    echo "<h2>Comments</h2><table>";

      foreach ($NoteItems as $NoteItem) {
        echo "<tr>";
          echo "<td>" . $NoteItem['Text'] . "</td>";
          echo "<td>" . Generate_Destroy_Link("COM", $NoteItem['Id']) . "</td>";
        echo "</tr>";
      }

    echo "</table>";
    echo "<div> New Comment <br>";
    Generate_Textbox("", "NewCommentText", ""); echo "<br>";
    echo "</div>";
  }

  { //output Discoutns //
    echo "<h2>Discounts</h2><table>";
      echo "<tr><th>Amount</th><th>Label</th><th>Percentage?</th></tr>";

      foreach ($DiscountItems as $DiscountItem) {
        print_r($DiscountItem);
        echo "<tr>";
          echo "<td>" . $DiscountItem['Value'] . "</td>";
          echo "<td>" . $DiscountItem['Label'] . "</td>";

          echo "<td>";
          if ($DiscountItem['IsPercent']) {
            echo "Yes (Real value: " . $QuoteInfo['Subtotal'] * $DiscountItem['Value'] . ")";
          }
          else {
            echo "No";
          }
          echo "</td>";

          echo "<td>" . Generate_Destroy_Link("DSC", $DiscountItem['Id']) . "</td>";
        echo "</tr>";
      }



    echo "</table>";
    echo "<div> New line item <br>";
    Generate_Textbox("Description: ", "NewLineItemDescript", ""); echo "<br>";
    Generate_Textbox("Price: ", "NewLineItemPrice", ""); echo "<br>";
    echo "</div>";
  }
  //disable if not owned
  echo "<input type=\"submit\" name=\"Submit\" value=\"Save\" />";
  echo "</form>";

  print_html_footer();
?>
