<html>
<title>viewQuotes</title>
</head>
<body>
<?php

// This page will fill the requirments of the second interface, this is where new quotes will go to. From here they can be edited or removed. This is also where
// a discount can be applied for a second time. Notes on quotes can also be viewed and added. After all edits and discounts have been made, the quote is either left unresolved or sanctioned


$username1 = "z1913636";    // zid
$password1 = "2000May03";    // password to db
$username2 = "student";
$password2 = "student";

session_start();
error_reporting(E_ALL);


    // Function for draw table
    function draw_table($rows){
        echo "<table border=1 cellspacing=1>";
        echo "<tr>";
        foreach($rows[0] as $key => $item ) {
            echo "<th>$key</th>";
        }
        echo "</tr>"; 
        foreach($rows as $row){
            echo "<tr>";
            foreach($row as $key => $item ) {
                echo "<td>$item</td>";
            }
            echo "</tr>";
        }
        echo "</table>\n";





?>
</body>
</html>
