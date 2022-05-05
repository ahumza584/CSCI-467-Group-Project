<?php
include_once 'activate_debug.php';
include_once 'dblogin.php';

/*
 * sql interaction functions
 * - Joshua Sulouff Z1867688
 */

define('IGNORE_OWNERSHIP', 1);
define('ALLOW_ANON_EDITING', 0);

/*
 * returns a table with indexes:
 * 0 -> Base Order info (['QuoteId'],['OwnerId'], ['Email'], ['Description'], ['Subtotal']
        ['LastUpdate'] ['Created'] ['CustomerID'], [DiscountTotal]
 * 1 -> line items (['Charge'], ['Label'], ['Id'])
 * 2 -> notes (['Text'], ['Id'])
 * 3 -> Discounts (['IsPercent'], ['Value'], ['Label], ['Id'])
 */
function GetOrderById(int $QuoteId) {
    global $pdo;
    //  Get header info about the order =========================
    $sql = "select * from SQUOTE where QID = :qid";

    $statement = $pdo->prepare($sql);
    $statement->execute(['qid' => $QuoteId]);

    $QRow = $statement->fetch();

    $Quote['QuoteId']     = $QRow['QID'];
    $Quote['OwnerId']     = $QRow['OWNER'];
    $Quote['Email']       = $QRow['EMAIL'];
    $Quote['Description'] = $QRow['DESCRIPT'];
    $Quote['LastUpdate']  = $QRow['UPDATED'];
    $Quote['Created']  = $QRow['CREATED'];
    $Quote['CustomerId']  = $QRow['CUSTOMERID'];

    switch ($QRow['STATUS']) {
        case "PRELIM":
            $Quote['Status'] = "Preliminary";
            break;
        case "FINAL":
            $Quote['Status'] = "Finalized";
            break;
        case "SANCT":
            $Quote['Status'] = "Sanctioned";
            break;
        default:
            $Quote['Status'] = "UNKNOWN";
            break;
    }

    //  Get a list of line items ================================
    $sql = "select PRICE, DESCRIPT, ID from LINEITEM where QID = :qid";

    $statement = $pdo->prepare($sql);
    $statement->execute(['qid' => $QuoteId]);

    $litems = [];
    $Subtotal = 0.00;
    foreach ($statement as $row){
        $t = [];
        $t['Charge'] = $row['PRICE'];      //Get rows into a more
        $t['Label'] = $row['DESCRIPT'];    //standard naming scheme
        $t['Id'] = $row['ID'];

        $Subtotal += $row['PRICE']; //Add to subtotal
        $litems[] = $t;                     //Append to array
    }
    $Quote['Subtotal'] = $Subtotal;
    $Quote['DiscountTotal'] = $Subtotal;

    //  Get a list of the notes attached to this order ==========
    $sql = "select STATEMENT, ID from NOTE where QID = :qid";
    $argarray = ['qid' => $QuoteId];
    $res = DB_doquery($sql, $argarray);

    $Comments = [];
    foreach ($res as $row){
        $Comments[] = [ 'Text' => $row['STATEMENT'], 'Id' => $row['ID']];     //Retrieve text
    }

    $sql = "select DESCRIPT, AMOUNT, PERCENTAGE, ID from DISCOUNT where QID = :qid";
    $res = DB_doquery($sql, $argarray);

    $Discounts = [];
    foreach ($res as $row) {
        $drow['IsPercent'] = $row['PERCENTAGE'];
        $drow['Value']     = $row['AMOUNT'];
        $drow['Label']     = $row['DESCRIPT'];
        $drow['Id']        = $row['ID'];
        $Discounts[] = $drow;

        if ($row['PERCENTAGE']) {
          $Quote['DiscountTotal'] -= ($Quote['Subtotal'] * $row['AMOUNT']);
        }
        else {
          $Quote['DiscountTotal'] -= ($row['AMOUNT']);
        }
    }


    $mstr = [$Quote, $litems, $Comments, $Discounts];
    return $mstr;
}


// note: haven't tested this one
function compute_final_value($Quote) {
    $base = $Quote[0]['Subtotal'];
    $total = $base;
    foreach ($Quote[3] as $discount) {
        if ($discount['IsPercent']) {
            $base -= $discount['Value'] * $total;
        } else {
            $base -= $discount['Value'];
        }
    }
    return $total;
}

/*
 * Retrieves the info for a given associate
 * returns array:
 * ['Name'] ['Address'] ['Username'] ['Commision'] ['AuthLevel']
 *
 */
function GetAssocInfo(int $AssocId) {
    global $pdo;
    $sql = "select * from ASSOCIATE where ID = :aid";

    $statement = $pdo->prepare($sql);
    $statement->execute(['aid' => $AssocId]);

    $assoc = $statement->fetch();

    $mstr ['Name']      = $assoc['NAME'];
    $mstr ['Address']   = $assoc['ADDRESS'];
    $mstr ['Username']  = $assoc['UNAME'];
    $mstr ['Commision'] = $assoc['COMMISSION'];
    $mstr ['AuthLevel'] = $assoc['PRIVLEVEL'];

    return $mstr;
}

function DB_doquery($sql, $varArray = array()){
    global $pdo;
    $statement = $pdo->prepare($sql);
    if(isset($varArray))
    {
        $statement->execute($varArray);
    } else {
        $statement->execute();
    }


    return $statement->fetchall();
}

function DB_exec($file) {
    global $pdo;
    $sql = file_get_contents($file);

    $statement = $pdo->prepare($sql);
    $statement->execute();
}

/*
 *  Functions for clearing the data set
 *  from within php
 */
function DB_reset() {
    DB_exec("sql/01-START.sql");
}

function DB_load_sample_data() {
    DB_exec("sql/02-EXAMPLEDATA.sql");
}

function DB_reset_to_sample() {
    DB_reset();
    DB_load_sample_data();
}

/*
 * Returns 1 dimensional array of associate IDS
 */
function get_all_associate_ids() {
    $sql = "select ID from ASSOCIATE";
    $res = DB_doquery($sql, []);
    $mstr = [];
    foreach ($res as $i) {
        $mstr[] = $i['ID'];
    }
    return $mstr;
}

function get_all_quote_ids() {
    $sql = "select QID from SQUOTE";
    $res = DB_doquery($sql, []);
    $mstr = [];
    foreach ($res as $i) {
        $mstr[] = $i['QID'];
    }
    return $mstr;
}

function get_orders_for_associate(int $aid) {
    $sql = "select QID from SQUOTE where OWNER = :aid";
    $args = ['aid' => $aid];
    $res = DB_doquery($sql, $args);
    $mstr = [];
    foreach ($res as $i) {
        $mstr[] = $i['QID'];
    }
    return $mstr;
}

/*  Returns a 2 value array.
 *  [0] => Associate ID (Or -1 if login fails)
 *  [1] => Privilege level for associate
 */
function attempt_login($uname, $pass) {
    $sql = "select ID from ASSOCIATE where UNAME = ':uname' and PASSWD = ':passwrd'";
    $res = DB_doquery($sql, ['uname' => $uname, 'passwrd' => $pass]);
    if (empty($res))
    {
        return -1;
    } else {
        return $res[0]['ID'];
    }
}

function GetPrivLevel(int $uid) : int {
  $a = GetAssocInfo($uid);
  return $a['AuthLevel'];
}

function IsAdjuster(int $uid) : bool {
  $a = GetAssocInfo($uid);
  return ($a['AuthLevel'] == 3);
}

function IsAdmin(int $uid) : bool {
  $a = GetAssocInfo($uid);
  return ($a['AuthLevel'] == 5);
}

session_start();

function NewWorkQuote() {
  $mstr = [];
  $mstr[0] = ['QuoteId' => -1, 'OwnerId' => $_SESSION['UID'], 'Email' => "", 'Description' => "", 'Subtotal' => 0.0, 'DiscountTotal' => 0.0, 'Status' => "Preliminary"];
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
  $TargetQuote = intval($_GET['TargetQuote']);
}
else //New Quote///
{
  $WorkQuote = NewWorkQuote();
  $TargetQuote = -1;
}

// Set reference for readability
$QuoteInfo =     &$WorkQuote[0];
$LineItems =     &$WorkQuote[1];
$NoteItems =     &$WorkQuote[2];
$DiscountItems = &$WorkQuote[3];
$TargetQuote =    $QuoteInfo['QuoteId'];

//<a href="dbman.php">go here</a>

?>
