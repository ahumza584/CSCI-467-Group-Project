<html>
<title>createQuote</title>
</head>

<body>
<?php

$username = "z1913636";
$password = "2000May03";

try {
    $dsn = "mysql:host=courses;dbname=z1913636";
	$pdo = new PDO($dsn, $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    // Headers
    echo"<h1>Quote System</h1>\n";
    echo"<h3>Create new quote for Customer:</h3>";

    // Form to select customer that needs new quote
    echo "<form action=\"\" method=\"GET\">";
	echo "<select name=\"customer_name\">";

    // SQL to get data on customer from LEGACY Database
    $customers = $pdo->query("SELECT * FROM customers;");
	$cust = $customers->fetchALL(PDO::FETCH_ASSOC);

}



catch(PDOexception $e) { //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}

?>

</body>
</html>

