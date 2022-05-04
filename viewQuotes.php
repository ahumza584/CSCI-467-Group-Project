<html>
<title>viewQuotes</title>
</head>
<body>
<?php

// This page will fill the requirments of the second interface, this is where new quotes will go to. From here they can be edited or removed. This is also where
// a discount can be applied for a second time. Notes on quotes can also be viewed and added. After all edits and discounts have been made, the quote is either left unresolved or sanctioned

include 'formatters.php';
include 'dblogin.php';



try {
    // Connection to Database

    // Connection to Legacy Databas

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
