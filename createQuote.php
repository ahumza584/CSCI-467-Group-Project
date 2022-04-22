<html>
<title>createQuote</title>
</head>
<body>
<?php

$username1 = " ";    // zid
$password1 = " ";    // password to db
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

    // Headers
    echo "<h1>Quote System</h1>\n";
    echo "<h3>Create new quote for Customer:</h3>";

    // select customer that needs new quote
    echo "<form action=\"\" method=\"GET\">";
	echo "<select name=\"customer_name\">";

    // get data on customer from LEGACY Database
    $customers = $pdo2->query("SELECT * FROM customers;");
	$cust = $customers->fetchALL(PDO::FETCH_ASSOC);


    // Allows to select from a list of customers from legacy
    foreach($cust as $cus){
        echo "<tr>\n";
        echo "<option value=$cus[id]>" . $cus["name"] . " (ID = " . $cus["id"] . ") </option>";
    }

    echo "<select><input type=\"submit\" />";
	echo "</form>";

}



catch(PDOexception $e) { //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}

?>
</body>
</html>

