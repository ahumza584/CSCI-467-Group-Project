<html>
<title>viewQuotes</title>
</head>
<body>
<?php

// This page will fill the requirments of the second interface, this is where new quotes will go to. From here they can be edited or removed. This is also where
// a discount can be applied. Notes on quotes can also be viewed and added. After all edits and discounts have been made, the quote is either left unresolved or sanctioned.
// Sanctioned quotes are emailed out to the customer, the email will contain all quote data except the secret notes.


$username1 = "z1913636";    // zid
$password1 = "2000May03";    // password to db
$username2 = "student";
$password2 = "student";

session_start();
error_reporting(E_ALL);

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
    echo "<h3>View Exisiting Quotes:</h3>";








}


catch(PDOexception $e) { //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}


?>
</body>
</html>