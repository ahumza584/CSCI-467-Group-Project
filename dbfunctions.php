<?php
include 'activate_debug.php';
include 'dblogin.php';

/*
 * sql interaction functions
 * - Joshua Sulouff Z1867688
 */


/*
 * returns a table with indexes:
 * 0 -> Base Order info (['OwnerID'], ['Email'], ['Description'], ['Subtotal']
 * 1 -> line items (['Charge'], ['Label'])
 * 2 -> notes (Raw text)
 */
function GetOrderById(int $QuoteId) {
    global $pdo;
    //  Get header info about the order =========================
    $sql = "select * from SQUOTE where QID = :qid";

    $statement = $pdo->prepare($sql);
    $statement->execute(['qid' => $QuoteId]);

    $QRow = $statement->fetch();

    $Quote['OwnerID']     = $QRow['OWNER'];
    $Quote['Email']       = $QRow['EMAIL'];
    $Quote['Description'] = $QRow['DESCRIPT'];

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
    $sql = "select PRICE, DESCRIPT from LINEITEM where QID = :qid";

    $statement = $pdo->prepare($sql);
    $statement->execute(['qid' => $QuoteId]);

    $litems = [];
    $Subtotal = 0.00;
    foreach ($statement as $row){
        $t = [];
        $t['Charge'] = $row['PRICE'];      //Get rows into a more
        $t['Label'] = $row['DESCRIPT'];    //standard naming scheme

        $Subtotal += $row['PRICE']; //Add to subtotal
        $litems[] = $t;                     //Append to array
    }


    //  Get a list of the notes attached to this order ==========
    $sql = "select STATEMENT from NOTE where QID = :qid";

    $statement = $pdo->prepare($sql);
    $statement->execute(['qid' => $QuoteId]);

    $Comments = [];
    foreach ($statement as $row){
        $Comments[] = $row['STATEMENT'];     //Retrieve text
    }

    $mstr = [$Quote, $litems, $Comments];
    return $mstr;
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

function DB_doquery($sql, $varArray){
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

}

?>

<a href="dbman.php">go here</a>
