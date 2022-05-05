<?php

/*
  Quote Details viewer page
  Joshua Sulouff Z1867688
*/

include_once 'activate_debug.php';
include_once 'dbfunctions.php';
include_once 'miscfuncs.php';

print_html_header();


// ============== setup ================== ////

//echo $TargetQuote;

if (!array_key_exists('UID', $_SESSION)) {
  $IsOwner = false;
  $PrivLevel = -1;
}
else {
  $PrivLevel = GetPrivLevel($_SESSION['UID']);
  // Is the owner
  if ($QuoteInfo['OwnerId'] == $_SESSION['UID']){
    $IsOwner = true;
  }
  // Is an admin or adjuster
  else if (IsAdmin($_SESSION['UID']) || IsAdjuster($_SESSION['UID'])) {
    $IsOwner = true;
  }
  // Default to no permissions
  else {
    $IsOwner = false;
  }
}


// ================================================= ////

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
  global $QuoteInfo;
  global $IsOwner;
  //Generate selected first
  $Customers = GetCustomers();
  ////print_r($Customers);

  echo "<label for=\"$label\">". $label ."</label>";
  echo "<select id=\"" . $label . "\" name=\"" . $Name . "\">";

  //If there is a working customer
  if (array_key_exists('CustomerId', $QuoteInfo)) {
    foreach ($Customers as $Customer) {
      echo "<option value=\"" . $Customer['Id'] . "\"";

      if ($Customer['Id'] == $QuoteInfo['CustomerId']) {
        echo " selected ";
      }

      if ((!$IsOwner) && (!IGNORE_OWNERSHIP)) {
        echo "disabled";
      }

      echo ">" . $Customer['Name'] . "</option>";
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
  global $IsOwner;
  echo "<label for=\"" . $Field . "\">" . $label . "</label>";
  echo "<input id=\"". $Field ."\" name=\"". $Field ."\" type=\"text\" value=\"" . $DefaultText . "\"";

  if ((!$IsOwner) && (!IGNORE_OWNERSHIP)) {
    echo " disabled ";
  }

  echo ">";
}

function Generate_Destroy_Link($kind, $id) {
  global $TargetQuote;
  return "<a href=\"QuoteAction.php?Destroy" . $kind ."=" . $id . "&TargetQuote=" . $TargetQuote . "\">Delete</a>";
}

if ($PrivLevel == -1) {
  echo "Logged in as ANONYMOUS";
}
else {
  $Userinfo = GetAssocInfo($_SESSION['UID']);
  echo "Logged in as " . $Userinfo['Name'];
  if ($PrivLevel == 5) {
    echo " (ADMINSTRATOR) ";
  }
  else if ($PrivLevel == 3) {
    echo " (ADJUSTER) ";
  }
  else {
    echo " (USER) ";
  }
  echo "<br>";
}

if (array_key_exists('reply',$_GET)) {
  echo "Reply: " . $_GET['reply'];
}

echo "<h1> Quote editing</h1>";
echo "<form action=\"QuoteAction.php?TargetQuote=". $TargetQuote ."\" method=\"post\">";
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

          if ($IsOwner || IGNORE_OWNERSHIP) {
            echo "<td>" . Generate_Destroy_Link("LIN", $LineItem['Id']) . "</td>";
          }

        echo "</tr>";
      }

    echo "</table>";


    if ($IsOwner || IGNORE_OWNERSHIP) {
      echo "<div> New line item <br>";
      Generate_Textbox("Description: ", "NewLineItemDescript", ""); echo "<br>";
      Generate_Textbox("Price: ", "NewLineItemPrice", ""); echo "<br>";
      echo "</div>";
    }


  }

  { //OUtput comments ////
    echo "<h2>Comments</h2><table>";

      foreach ($NoteItems as $NoteItem) {
        echo "<tr>";
          echo "<td>" . $NoteItem['Text'] . "</td>";

          if ($IsOwner || IGNORE_OWNERSHIP) {
            echo "<td>" . Generate_Destroy_Link("COM", $NoteItem['Id']) . "</td>";
          }

        echo "</tr>";
      }

    echo "</table>";

    if ($IsOwner || IGNORE_OWNERSHIP) {
      echo "<div> New Comment <br>";
      Generate_Textbox("", "NewCommentText", ""); echo "<br>";
      echo "</div>";
    }


  }

  { //output Discoutns //
    echo "<h2>Discounts</h2><table>";
      echo "<tr><th>Amount</th><th>Label</th><th>Percentage?</th></tr>";

      foreach ($DiscountItems as $DiscountItem) {
        //print_r($DiscountItem);
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

          if($IsOwner || IGNORE_OWNERSHIP){
            echo "<td>" . Generate_Destroy_Link("DSC", $DiscountItem['Id']) . "</td>";
          }

        echo "</tr>";
      }


    echo "</table>";

    if ($IsOwner || IGNORE_OWNERSHIP) {
      echo "<div> New discount <br>";
      Generate_Textbox("Description: ", "NewDiscountDescript", ""); echo "<br>";
      Generate_Textbox("Price: ", "NewDiscountAmount", "");

      echo '<input type="checkbox" name="NewDiscountPercent" value="true">
              <label> Percentage </label>
            <br>';
      echo "</div>";
    }

  }
  ////
  if ($PrivLevel == 5) {
    echo '<a href="QuoteAction.php?SanctionQ=1&TargetQuote='. $TargetQuote .'">Sanction Quote</a><br>';
  }
  //disable if not owned
  if ($IsOwner || IGNORE_OWNERSHIP) {
    echo '<a href="QuoteAction.php?FinalizeQ=1&TargetQuote='. $TargetQuote .'">Finalize Quote</a><br>';
    echo "<input type=\"submit\" name=\"Submit\" value=\"Save\" />";
  }
    // code...


  echo "</form>";

  print_html_footer();
?>
