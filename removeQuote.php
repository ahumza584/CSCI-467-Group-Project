<html>
<title>removeQuote</title>
</head>
<body>
<?php

include 'formatters.php';
include 'dblogin.php';

try{

$id = $_GET['TargetQuote'];
$delete = "DELETE from SQUOTE where QID = $id";
$stmnt = $pdo->prepare($delete);
$stmnt->execute([$id => 'QID']);


if($stmnt)
{
    echo "<p>Quote Removed.</p>";

} else {
    echo "<p>Error Quote Not Deleted.</p>";
}



echo "<a href='viewQuotes.php'>";
echo "<input type=\"submit\" name=\"submit\" value=\"Back to Quotes\" />";
echo "</a><br>";


}

catch(PDOexception $e) { //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}


?>
</body>
</html>