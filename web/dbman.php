<?php
include_once 'dbfunctions.php';
include_once 'miscfuncs.php';
print_html_header();
?>
<h1> Database debugger </h1>
<?php

if(array_key_exists("resetdb", $_POST)){
    DB_reset();
}

if(array_key_exists("loadsample", $_POST)){
    DB_load_sample_data();
}

function display_associates($assocIds = null) {
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
        <th> commission </th>
        <th> Username </th>
        <th> Password </th>
        <th> Privelege Level </th>
        </tr>
    ");
    foreach($assocIds as $AssociateId) {
        $ainfo = GetAssocInfo($AssociateId);
        echo("<tr>");
            echo ("<td>" . $AssociateId        . "</td>");
            echo ("<td>" . $ainfo['Name']      . "</td>");
            echo ("<td>" . $ainfo['Address']   . "</td>");
            echo ("<td>" . $ainfo['Commision'] . "</td>");
            echo ("<td>" . $ainfo['Username']  . "</td>");
            echo ("<td>" . "WITHHELD"          . "</td>");
            echo ("<td>" . $ainfo['AuthLevel'] . "</td>");
        echo("</tr>");
    }

    echo ("</table>");
}

function print_inner_table($table) {
    if (count($table) == 0) {
        echo ("None");
        return;
    }

    echo("<table class=\"InnerTable\">");

        echo("<tr>");
        foreach(array_keys($table) as $key) {
            echo("<th>" . $key . "</th>");
        }
        echo("</tr>");

        foreach($table as $row) {
            echo ("<tr>");
            foreach ($row as $value){
                echo("<td>". $value ."</td>");
            }
            echo ("</tr>");
        }



    echo("</table>");
}

function display_quotes($qids = null) {
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
             echo ("<tr><td>" . $Comment . "</td></tr>");
            }
            echo("</table>");
        }
        echo("</td>");

        echo("<td>")
        echo("
            <form action=\"QuoteEdit.php\" method=\"post\">
            <input name=\"ORDERNUMBER\" value=\"" . $quote[0]['QuoteId'] . "\">
            <input type=\"submit\" value=\"Edit\">
            </form>
        ");
        echo("</td>")

        echo("</tr>"); //End of Quote info
    }

    echo("</table>"); //End of overal table

}

?>

<form action="dbman.php" method="post">
<input type="checkbox" name="resetdb"    value="true" checked="true"><label>Reset database</label><br>
<input type="checkbox" name="loadsample" value="true" checked="true"><label>Load sample data</label><br>
<input type="submit">
</form>

<?php

display_associates();
display_quotes();




?>


<?php print_html_footer(); ?>
