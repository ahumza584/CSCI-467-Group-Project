<head>

</head>

<?php

include_once 'activate_debug.php';
include_once 'dblogin.php';
include_once 'dbfunctions.php';
include_once 'miscfuncs.php';

print_html_header();

session_start();

/*
    Quote viewing and editing page
    Joshua Sulouff
*/

/*
  POST FIELDS :
    TargetQuote -> Quote to be displayed, overrides current working quote

*/

// ====================================
// ======== POST INPUT HANDLING =======
// ====================================

//Put a quote into the system
function Store_Quote() {
  // Update it if it exists,
  if (Check_Quote_Exists()) {
    $sql = "update SQUOTE set
            OWNER = :oid, CUSTOMERID = :custId, EMAIL=:email, DESCRIPT=:descript, UPDATED=(SELECT(CURRENT_TIMESTAMP)) where QID = :qid";
  }
  // or create it if it doesn't
  else {
    $sql = "insert into SQUOTE (OWNER, CUSTOMERID, EMAIL, DESCRIPT STATUS) VALUES
            (:oid, :custId, :email, :descript, 'PRELIM')";
  }

  $args = [
    'oid'      => $_SESSION['WORKQUOTE']['OwnerID'];
    'custid'   => $_SESSION['WORKQUOTE']['CustomerID'];
    'email'    => $_SESSION['WORKQUOTE']['Email'];
    'descript' => $_SESSION['WORKQUOTE']['Description'];
  ]

  DB_doquery($sql, $args);

  // Handle comments
  foreach ($_SESSION['WORK_COMMENTS'] as $comment) {

    //Tag is affixed to new comments
    if (array_key_exists('New', $comment)) {
      $sql = "insert into NOTE (QID, STATEMENT) VALUES (:qid, :str)"
      $args = [':qid = $_SESSION']

    }
  }

  // Handle Lines
  foreach ($_SESSION['WORK_LINES'] as $value) {

  }

  // Handle Discounts
  foreach ($_SESSION['WORK_DISCOUNTS'] as $value) {

  }

  // Destroy work data since its no longer needed
  unset($_SESSION['WORKQUOTE'], $_SESSION['WORK_COMMENTS'], $_SESSION['WORK_LINES'], $_SESSION['WORK_DISCOUNTS']);

  // redirect to management page (debug)
  header("location:dbman.php");
}

function Read_Jobs() {

}

$DestroyJobs = [];

foreach ($_POST as $job => $value) {
  if (strpos($job, 'DestroyLI')) {
    $DestroyJobs[] = $job;
  }
}

{ // Edit Quote according to contents

}

// ====================================
// ======== DISPLAY SECTION ===========
// ====================================

function NewWorkQuote() {
  $mstr = [];
  $mstr[0] = ['QuoteId' => -1, 'OwnerID' => $_SESSION['UID'], 'Email' => "", 'Description' => ""];
  $mstr[1] = [];
  $mstr[2] = [];
  $mstr[3] = [];
  return $mstr;
}

function WorkQuoteFromDb($Quote) {
  return $Quote; //Future proofing
}



echo $_POST['TargetQuote'];

bool $Editing = true;

// If an existing quote is being loaded in, get it
if (array_key_exists('TargetQuote', $_POST)) {
  //Load quote by ID
  $Quote = GetOrderById($_POST)
  if ($Quote['OwnerID'] != $_SESSION['UID']) {
      $Editing = false;
  }

  $_SESSION['WORK_COMMENTS']  = $Quote[2];
  $_SESSION['WORK_LINES']     = $Quote[1];
  $_SESSION['WORK_DISCOUNTS'] = $Quote[3];

  $Quote = WorkQuoteFromDb($Quote[0]);
  $_SESSION['WORKQUOTE']      = $Quote;

}
else if (array_key_exists('NewQuote', $_POST)) {
  $Quote = NewWorkQuote();
  $_SESSION['WORKQUOTE']      = $Quote;
  $_SESSION['WORK_COMMENTS']  = [];
  $_SESSION['WORK_LINES']     = [];
  $_SESSION['WORK_DISCOUNTS'] = [];
}
else if (array_key_exists('WORKQUOTE', $_SESSION)) {
  $Qote = $_SESSION['WORKQUOTE'];
}
else {
  echo "Invalid entry state: no target specified, no working quote specified.";
  exit();
}

//Checks if workquote exists
function Check_Quote_Exists(): bool {
  $sql = "select QID from SQUOTE where QID = :wqid";
  $res = DB_doquery($sql);

  if ($res->first()) {
    return true;
  }
  return false;
}


/*
    Setup references for readability
*/
$WorkQuote    =  &$_SESSION['WORKQUOTE'];
$WorkLine     =  &$_SESSION['WORK_LINE'];
$WorkComment  =  &$_SESSION['WORK_COMMENTS'];
$WorkDiscount =  &$_SESSION['WORK_DISCOUNTS'];

function Display_Quote() {
  echo "<div>"
    echo "<h2> Quote: "  . $WorkQuote['QuoteID'] . "</h2>" .
    echo "Owner: "       . "placeholder" . "<br>"
    echo "Customer: "    . "placeholder" . "<br>"
    echo "Email: "       . "placeholder" . "<br>"
    echo "Description: " . "placeholder" . "<br>"
  echo "</div>"
}

  echo "<h1> Quote" . . "</h1>"

  $q = $_SESSION



print_html_footer();
// ===============================


//Generate a link to destroy the item
function Generate_Destroy_Link($kind, $id) {
  return "<a href=\"QuoteAction?Destroy" . $kind ."=" . $id ."\">";
}



?>
