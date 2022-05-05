<html>
<title>viewQuotes</title>
</head>
<body>
<?php

// This page will fill the requirments of the second interface, this is where new quotes will go to. From here they can be edited. This is also where
// a discount can be applied for a second time. Notes on quotes can also be viewed and added. After all edits and discounts have been made, the quote is either left unresolved or sanctioned

include 'formatters.php';
include 'dblogin.php';


try {

    //header
    echo "<h1>Quote System</h1>\n";

    // Back to login
    echo "<a href='login.php'>";
	echo "<input type=\"submit\" name=\"submit\" value=\"Back to Login\" />";
    echo "</a><br><br>";

    //New Quote
    echo "<a href='QuoteDetails.new.php'>";
	echo "<input type=\"submit\" name=\"submit\" value=\"New Quote\" />";
    echo "</a><br>";

    echo "<h3>Existing Quotes:</h3>";

    function display_quotes_with_edit_button($qids = null) {
        if (is_null($qids)){
            $qids = get_all_quote_ids();
        }
        echo("
        <h2> Existing Quotes Quotes </h2>
        <table>
            <tr>
            <th> ID </th>
            <th> Owner </th>
            <th> Email </th>
            <th> Description </th>
            <th> Status </th>
            <th> Date Created </th>
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
            echo ("<td>" . $quote[0]['Created'] . "</td>");

    
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
              echo "<a href=\"QuoteDetails.new.php?TargetQuote= " . $quote[0]['QuoteId'] . "\">";
              echo "<input type=\"submit\" name=\"submitEdit\" value=\"Edit\" />";
              echo "</a>";
              echo "<a href=\" removeQuote.php?TargetQuote= " . $quote[0]['QuoteId'] . "\">";
              echo "<input type=\"submit\" name=\"submitEdit\" value=\"Remove\" />";
              echo "</a>";
            echo("</td>");
    
            echo("</tr>"); //End of Quote info
        }
    
        echo("</table>"); //End of overal table
    
    }


    display_quotes_with_edit_button();

   
}


catch(PDOexception $e) { //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}


?>
</body>
</html>
