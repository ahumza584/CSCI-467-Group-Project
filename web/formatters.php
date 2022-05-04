 <?php

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

function generate_quote_edit($qid) {
    $quote = GetOrderById($qid);
    echo "<form>";


    echo "</form>";
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
             echo ("<tr><td>" . $Comment['Text'] . "</td></tr>");
            }
            echo("</table>");
        }
        echo("</td>");

        echo("<td>");
        QuoteEditButton($quote[0]['QuoteId']);
        echo("</td>");

        echo("</tr>"); //End of Quote info
    }

    echo("</table>"); //End of overal table

}

function QuoteEditButton($qid) {
  echo "<form action =\"QuoteDetails.php\" method=\"post\">";
  echo "<input type=\"submit\" name=\"TargetQuote\" value=\"" . $qid . "\" text=\"Edit\" method=\"post\">";
  echo "</form>";
}

?>
