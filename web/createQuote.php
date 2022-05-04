<html>
<title>createQuote</title>
</head>
<body>
<?php

include_once 'activate_debug.php';
include_once 'dblogin.php';

$pdo1 = $pdo;           // alias pdo as pdo1
$pdo2 = $extpdo;

session_start();

try {

    if (array_key_exists('NewLineItem', $_POST)) {
      $_SESSION['']
    }


    // Header
    echo "<h1>Quote System</h1>\n";

    // button that takes to view existing quotes page
    echo "<a href = 'viewQuotes.php'>";      //<---------- change this to where your file is (url)
    echo "<input type=\"submit\" value=\"View Existing Quotes\" />";
    echo "</a>";

    echo "<h3>Create new quote for Customer:</h3>";

    // select customer that needs new quote
  echo "<form action=\"\" method=\"GET\">";
	echo "<select name=\"CustomerID\">";

    // get data on customer from LEGACY Database
    $customerStatement = $pdo2->query("SELECT * FROM customers;");
	  $customerList = $customers->fetchALL(PDO::FETCH_ASSOC);


    // Allows to select from a list of customers from legacy
    foreach($customerList as $customer){
        echo "<tr>\n";
        echo "<option value=$customer[id]>" . $customer["name"] . " (ID = " . $customer["id"] . ") </option>";
    }

    // submit button to choose customer
    echo "<select><input type=\"submit\" />";
	echo "</form>";



    // after choosing customer, enter information about new quote
    if(isset($_GET["CustomerID"])){
        $RetrieveCustomerStmnt = $pdo2->prepare('SELECT * FROM customers WHERE id = ?;');
        $RetrieveCustomerStmnt -> execute(array($_GET['name']));
        $singlename = $RetrieveCustomerStmnt->fetchALL(PDO::FETCH_ASSOC);

        function newLine($DefPrice, $DefText)
        {
            echo "<tr><td>"
            echo "<input type = \"textarea\" value=". $DefPrice ." name = \"PRICE\" />";
            echo "<input type = \"textarea\" name = \"DESCRIPT\" value=". $DefPrice ."/>";
            echo "</td></tr>"
        }

        function newNote()
        {
            echo "<input type = \"textarea\" name = \"STATEMENT\" />";
            echo "<br><br>";
        }


        // CUSTOMER NAME HEADER
        echo "<h2> Order for ";
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
        echo "<p>Line Items: <input type = \"submit\" class = \"button\" name = \"newLine\" value = \"New Item\" /> </p>";
        echo "<table>"
        echo "<tr>"
            echo "<th> Price </th>";
            echo "<th> Description </th>";
        echo "</tr>"
        if(array_key_exists($_SESSION['newLines'], $_POST))
        {
              foreach ($_SESSION['NewLines']) {
                newLine($_SESSION['NewLines']['Price'], $_SESSION['NewLines']['Text']);
              }
        }
        echo "</table>"


        // NOTES
        echo "<p>Notes: <input type = \"submit\" class = \"button\" name = \"newNote\" value = \"New Note\" /></p>";
        echo "<br><br>";
        if(array_key_exists('newNotes', $_POST))
        {
            newNote();
        }



        // DISCOUNT (NEED TO ADD NAME TO INPUT TEXT)
        echo "<p>Discount: <input type = \"textarea\" placeholder = \"Enter Discount\"</p>";


        echo "<br><br>";
        echo "<input type=\"submit\" name=\"submitQuo\" value=\"Submit Quote\" />";
        echo "</form>";

        $name = $_POST["name"];
        $qid = $_POST["id"];
        $email = $_POST["EMAIL"];
        $price = $_POST["PRICE"];
        $descript = $_POST["DESCRIPT"];
        $statement = $_POST["STATEMENT"];

        // send data to database and print note
        if(isset($_POST["submitQuo"]))
        {
            echo "<br><br>";
            echo "<p>Quote Submitted</p>";

            $query1 = "INSERT INTO SQUOTE(QID, OWNER, EMAIL, DESCRIPT) VALUES('$id', '$name', '$email', '$descript')";
            $query2 = "INSERT INTO LINEITEM(QID, PRICE, DESCRIPT) VALUES('$id', '$price', '$descript')";
            $query3 = "INSERT INTO NOTE(QID, STATEMENT) VALUES('$id', '$statement')";

            $run1 = new PDO($pdo1, $query1);
            $run2 = new PDO($pdo1, $query2);
            $run3 = new PDO($pdo1, $query3);


        }


    }


}


catch(PDOexception $e) { //handle that expection
	echo "Connection to database failed: " . $e->getMessage();
}

?>
</body>
</html>
