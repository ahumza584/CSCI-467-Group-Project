<html>
<title>viewQuotes</title>
</head>
<body>
<?php

// This page will fill the requirments of the second interface, this is where new quotes will go to. From here they can be edited or removed. This is also where
// a discount can be applied for a second time. Notes on quotes can also be viewed and added. After all edits and discounts have been made, the quote is either left unresolved or sanctioned

include 'formatters.php';
include 'dblogin.php';

$username2 = "student";
$password2 = "student";


try {
    // Connection to Database

    // Connection to Legacy Database
    $dsn2 = "mysql:host=blitz.cs.niu.edu;dbname=csci467";
	$pdo2 = new PDO($dsn2, $username2, $password2);
	$pdo2->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //header
    echo "<h1>Quote System</h1>\n";
    echo "<h3>Unresolved Quotes:</h3>";

    display_quotes($qids = null);

   
}


catch(PDOexception $e) { //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}


?>
</body>
</html>
