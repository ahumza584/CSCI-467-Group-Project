<?php
include_once 'dbfunctions.php';
include_once 'formatters.php';
include_once 'miscfuncs.php';
print_html_header();
?>
<h1> System debugger </h1>
<?php

/*
  System debugger page
  Joshua Sulouff Z1867688
*/


if(array_key_exists("DestroySession", $_GET)){
  session_destroy();
  session_start();
}



print_r($_POST);

if(array_key_exists("resetdb", $_POST)){
    DB_reset();
}

if(array_key_exists("loadsample", $_POST)){
    DB_load_sample_data();
}

if(array_key_exists("USwap", $_POST)){
    $_SESSION['UID'] = $_POST['USwap'];
}



?>

<form action="dbman.php" method="post">
<input type="checkbox" name="resetdb"    value="true" checked="true"><label>Reset database</label><br>
<input type="checkbox" name="loadsample" value="true" checked="true"><label>Load sample data</label><br>
<input type="submit">
</form>

<a href="createQuote.php">Create quote dialog</a> <br>
<a href="viewQuotes.php">Quote viewing dialog</a> <br>
<a href="login.php">log out</a> <br>
<a href="dbman.php?DestroySession=a">Destroy session</a> <br>
<a href="QuoteDetails.new.php">New Quote</a> <br>

<?php

function display_quotes_with_edit_button($qids = null) {
    if (is_null($qids)){
        $qids = get_all_quote_ids();
    }
    echo("
    <h2> Quotes </h2>
    <table>
        <tr>
        <th> ID </th>
        <th> Owner </th>
        <th> Email </th>
        <th> Description </th>
        <th> Status </th>
        <th> Line Items </th>
        <th> Discounts </th>
        <th> Comments </th>
        </tr>
    ");

    foreach($qids as $id) {
        $quote = GetOrderById($id);
        echo ("<tr>");
        echo ("<td>" . $quote[0]['QuoteId'] . "</td>");
        echo ("<td>" . $quote[0]['OwnerId'] . "</td>");
        echo ("<td>" . $quote[0]['Email'] . "</td>");
        echo ("<td>" . $quote[0]['Description'] . "</td>");
        echo ("<td>" . $quote[0]['Status'] . "</td>");

        //Echo all line items in a table
        echo ("<td>");
        {
            echo("
                <table class=\"InnerTable\">
                    <tr>
                        <th> Label  </th>
                        <th> Charge </th>
                    </tr>"
            );
            foreach ($quote[1] as $LineItem) {
                echo("
                    <tr>
                    <td> " . $LineItem['Label'] . " </td>
                    <td> " . $LineItem['Charge'] . " </td>
                    </tr>
                ");
            }
            echo("</table>");
        }
        echo("</td>"); //end of LineItem Table

        echo("<td>");
        {
            //print_r($quote[3]);
            echo("
            <table class=\"InnerTable\">
            <tr>
            <th> Label </th>
            <th> Value </th>
            <th> Percentage </th>
            </tr>
            ");
            foreach($quote[3] as $Discount) {
            echo ("<tr>");
                echo("<td>" . $Discount['Label'] . "</td>");
                echo("<td>" . $Discount['Value'] . "</td>");
                echo("<td>" . $Discount['IsPercent'] . "</td>");
            echo ("</tr>");
            }
            echo ("</table>");
        }
        echo("</td>");

        echo("<td>");
        {
            echo("<table class=\"InnerTable\">");
            foreach($quote[2] as $Comment) {
             echo ("<tr><td>" . $Comment['Text'] . "</td></tr>");
            }
            echo("</table>");
        }
        echo("</td>");

        echo("<td>");
          echo "<a href=\"QuoteDetails.new.php?TargetQuote=" . $quote[0]['QuoteId'] . "\">Edit</a>";
        echo("</td>");

        echo("</tr>"); //End of Quote info
    }

    echo("</table>"); //End of overal table

}

function display_associates_with_id_buton($assocIds = null) {
    if (is_null($assocIds)){
        $assocIds = get_all_associate_ids();
    }
    echo("
    <h2> Associates </h2>
    <table>
        <tr>
        <th> ID </th>
        <th> Name </th>
        <th> Address </th>
        <th> Commission Rate</th>
        <th> Commission Accrued </th>
        <th> Username </th>
        <th> Password </th>
        <th> Privelege Level </th>
        <th> CommisionRate </th>
        </tr>
    ");
    foreach($assocIds as $AssociateId) {
        $ainfo = GetAssocInfo($AssociateId);
        echo("<tr>");
            echo ("<td>" . $AssociateId        . "</td>");
            echo ("<td>" . $ainfo['Name']      . "</td>");
            echo ("<td>" . $ainfo['Address']   . "</td>");
            echo ("<td>" . $ainfo['CommisionRate'] . "</td>");
            echo ("<td>" . $ainfo['CommisionAccrued'] . "</td>");
            echo ("<td>" . $ainfo['Username']  . "</td>");
            echo ("<td>" . "WITHHELD"          . "</td>");
            echo ("<td>" . $ainfo['AuthLevel'] . "</td>");
            echo ("<td>");
            echo ("<form action =\"dbman.php\" method=\"post\">");
            echo ("<input type=\"submit\" name=\"USwap\" value=\"" . $AssociateId . "\" text=\"Edit\" method=\"post\">");
            echo ("</form>");
            echo ("</td>");
        echo("</tr>");
    }

    echo ("</table>");
}

display_associates_with_id_buton();
display_quotes_with_edit_button();




?>


<?php print_html_footer(); ?>
