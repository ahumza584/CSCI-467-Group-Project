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


try {
    // Connection to Database
    $dsn1 = "mysql:host=courses;dbname=z1913636";      // <----- change to your zid
	$pdo1 = new PDO($dsn1, $username1, $password1);
	$pdo1->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    // Connection to Legacy Database
    $dsn2 = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
	$pdo2 = new PDO($dsn2, $username2, $password2);
	$pdo2->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //header
    echo "<h1>Quote System</h1>\n";
    echo "<h3>Unresolved Quotes:</h3>";

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
    }

    // Display quotes
    $rs = $pdo1->query("SELECT * FROM SQUOTE;");
    $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
    draw_table($rows);
    


}


catch(PDOexception $e) { //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}


?>
</body>
</html>
