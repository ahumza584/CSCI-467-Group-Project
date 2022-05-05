<html>
<title>removeQuote</title>
</head>
<body>
<?php

include 'formatters.php';
include 'dblogin.php';
include 'QuoteAction.php';

try{

DestroyQuote();

echo "<p>Quote Removed.</p>";

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