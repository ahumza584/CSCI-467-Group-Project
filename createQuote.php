<html>
<title>createQuote</title>
</head>
<body>
<?php

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

    // Header
    echo "<h1>Quote System</h1>\n";

    // button that takes to view existing quotes page
    echo "<a href = 'http://students.cs.niu.edu/~z1913636/467GroupProj/viewQuotes.php'>";      //<---------- change this to where your file is (url)
    echo "<input type=\"submit\" value=\"View Existing Quotes\" />";
    echo "</a>";

    echo "<h3>Create new quote for Customer:</h3>";

    // select customer that needs new quote
    echo "<form action=\"\" method=\"GET\">";
	echo "<select name=\"name\">";

    // get data on customer from LEGACY Database
    $customers = $pdo2->query("SELECT * FROM customers;");
	$cust = $customers->fetchALL(PDO::FETCH_ASSOC);


    // Allows to select from a list of customers from legacy
    foreach($cust as $cus){
        echo "<tr>\n";
        echo "<option value=$cus[id]>" . $cus["name"] . " (ID = " . $cus["id"] . ") </option>";
    }

    // submit button to choose customer
    echo "<select><input type=\"submit\" />";
	echo "</form>";



    // after choosing customer, enter information about new quote
    if(isset($_GET["name"])){
        $selectedname = $pdo2->prepare('SELECT * FROM customers WHERE id = ?;');
        $selectedname->execute(array($_GET['name']));
        $singlename = $selectedname->fetchALL(PDO::FETCH_ASSOC);


        // CUSTOMER NAME HEADER
        echo "<h2>";
        $thename = $_GET["name"];
        foreach($singlename as $single){
            echo "$single[name]";
        }
        echo "</h2>";

        // CUSTOMER INFO BELOW HEADER


        // CUSTOMER EMAIL FORM
        echo "<form action=\"\" method=\"POST\">";
        echo "<h3>Quote Information</h3>";
        echo "<input type = \"text\" name = \"EMAIL\" placeholder = \"Enter Customer Email\" />";
        echo "<br><br>";
        

        // LINE ITEMS
        echo "<p>Line Items: <input type = \"button\" name = \"newLine\" value = \"New Item\" /> </p>";
        echo "<br><br>";
        if(isset($_GET["newLine"]))
        {
            echo "<input type = \"textarea\" name = \"PRICE\" />";
            echo "<input type = \"textarea\" name = \"DESCRIPT\" />";
        }
    

        
        // NOTES
        echo "<p>Notes: <input type = \"button\" name = \"newNote\" value = \"New Note\" /> </p>";
        if(isset($_GET["newNote"]))
        {
            echo "<input type = \"textarea\" name = \"STATEMENT\" />";
        }



        // DISCOUNT (NEED TO ADD NAME TO INPUT TEXT)
        echo "<p>Discount: <input type = \"textarea\" placeholder = \"Enter Discount\"</p>";
        echo "</form>";
        



        // SUMBIT QUOTE BUTTON
        echo "<br><br>";
        echo "<input type=\"submit\" name=\"submitQuo\" value=\"Submit Quote\" />";


        // send data to database and print note
        if(isset($_POST["submitQuo"]))
        {
            echo "<br><br>";
            echo "<p>Quote Submitted</p>";

            $name = $_POST["name"];
            $qid = $_POST["id"];
            $email = $_POST["EMAIL"];
            $price = $_POST["PRICE"];
            $descript = $_POST["DESCRIPT"];
            $statement = $_POST["STATEMENT"];

            $query1 = "INSERT INTO SQUOTE(QID, OWNER, EMAIL, DESCRIPT) VALUES('$id', '$name', '$email', '$descript')";
            $query2 = "INSERT INTO LINEITEM(QID, PRICE, DESCRIPT) VALUES('$id', '$price', '$descript')";
            $query3 = "INSERT INTO NOTE(QID, STATEMENT) VALUES('$id', '$statement')";

            $run1 = new PDO($pdo1, $query1);
            $run2 = new PDO($pdo1, $query2);
            $run3 = new PDO($pdo1, $query);

        
        }
        
    }


}


catch(PDOexception $e) { //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}

?>
</body>
</html>

