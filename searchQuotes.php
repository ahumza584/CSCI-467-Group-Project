<html><head><title>Quotes Info</title></head>

    <!--    
        Quote System

        This is the quotes page for the admin interface.
        The interface allows to search and view quotes based on 
        status (finalized, sanctioned, ordered), date range, sales associate, and customer. 
    -->

<?php
    session_start();
    error_reporting(E_ALL);

    include 'dblogin.php';
    include 'dbfunctions.php';
    //include 'library.php';
    include 'formatters.php';


        //This is where drawing table starts
        function draw_table($rows){
            echo "<table border=1 cellspacing=1>";
            echo "<tr>";
            foreach($rows[0] as $key => $item ) {
                echo "<th>$key</th>";
            }
            echo "</tr>"; 
            foreach($rows as $row){
                $id = '';
                echo "<tr>";
                foreach($row as $key => $item ) {
                    echo "<td>$item</td>";
                    //$id = $item[0];
                }
                //echo ($rows[0]);
                //echo '<td>.$rows[0].</td>';
                echo '<td><a href="QuoteDetails.new.php/?TargetQuote='.$row['QID'].'">View</a></td>';
                echo "</tr>";
            }
            echo "</table>\n";
        } //finish drawing table
   
    try{
        echo ' <a href="adminHome.php">Home</a>'; //goes back to admin home page if this is clicked

        //echo ("<h1>\nQuotes:\n<h1>");

        
        if(isset($_POST['associate'])) {
            $id = $_POST['associate'];
            $ownerSQL = "SELECT * FROM SQUOTE WHERE OWNER = '$id';";
            $owner = $pdo->query($ownerSQL);
            $ownerRows = $owner->fetchAll(PDO::FETCH_ASSOC);

            echo ("<br><br><h2>Records with owner ID: " .$id. "</h2>");
            if ($ownerRows != false) {
                // display results.
                draw_table($ownerRows);
              } else {
                // there where no results
                echo "<h3>No records founds</h3>";
              }
        }
        else{
            echo ("<br><br><h2>Records for all quotes (owner not specified):</h2>");
            $rs = $pdo->query("SELECT * FROM SQUOTE;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            draw_table($rows);
        }

        $sql="SELECT NAME,ID FROM ASSOCIATE order by NAME"; 
        echo "<br><form method='post'><select name=associate onchange='javascript: submit()' value=''>Associate Name</option>"; // list box select command
        echo "<option value=all>Choose Owner</option>";
        foreach ($pdo->query($sql) as $row){//Array or records stored in $row
            echo "<option value=$row[ID]>($row[ID]) $row[NAME]</option>"; 
            /* Option values are added by looping through the array */ 
        }
        echo "<br></select></form>";// Closing of list box
        


        //sort by status
        if(isset($_POST['status'])) {
            if($_POST['status']== 'all'){
                echo "all stat selected";
                $rs = $pdo->query("SELECT * FROM SQUOTE;");
                $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
                draw_table($rows);
            }
            else{
                $status = $_POST['status'];
                $statusSQL = "SELECT * FROM SQUOTE WHERE STATUS = '$status';";
                $stat = $pdo->query($statusSQL);
                $statRows = $stat->fetchAll(PDO::FETCH_ASSOC);
                echo ("<br><h2>Records with status: " .$status. "</h2>");
                if ($statRows != false) {
                    draw_table($statRows);
                }
                else{
                    // there where no results
                    echo "<h3>No records founds</h3>";
                }
            }
            
        }

        else{
            echo ("<br><h2>Records for all quotes (status not specified):</h2>");
            $rs = $pdo->query("SELECT * FROM SQUOTE;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            draw_table($rows);
        }

        $sql="SELECT DISTINCT STATUS FROM SQUOTE"; 
        //display status dropdown
        echo "<br><form method='post'><select name=status onchange='javascript: submit()' value=''>Quote Status</option>"; // list box select command
        echo "<option value=all>Choose Status</option>";
        foreach ($pdo->query($sql) as $row){//Array or records stored in $row
            echo "<option value=$row[STATUS]>$row[STATUS]</option>"; 
            /* Option values are added by looping through the array */ 
        }
        echo "</select></form>";// Closing of list box




        if(isset($_POST['customer'])) {
            $id = $_POST['customer'];
            $customerSQL = "SELECT * FROM SQUOTE WHERE CUSTOMERID = '$id';";
            $customer = $pdo->query($customerSQL);
            $customerRows = $customer->fetchAll(PDO::FETCH_ASSOC);

            echo ("<br><h2>Records with customer ID: " .$id. "</h2>");
            if ($customerRows != false) {
                // display results.
                draw_table($customerRows);
              } else {
                // there where no results
                echo "<h3>No records founds</h3>";
              }
        }
        else{
            echo ("<br><h2>Records for all quotes (customer not specified):</h2>");
            $rs = $pdo->query("SELECT * FROM SQUOTE;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            draw_table($rows);
        }

        $sql="SELECT CUSTOMERID FROM SQUOTE;"; 
        echo "<br><form method='post'><select name=customer onchange='javascript: submit()' value=''>Customer</option>"; // list box select command
        echo "<option value=all>Choose Customer ID</option>";
        foreach ($pdo->query($sql) as $row){//Array or records stored in $row
            echo "<option value=$row[CUSTOMERID]>$row[CUSTOMERID]</option>"; 
            /* Option values are added by looping through the array */ 
        }
        echo "<br></select></form>";// Closing of list box
        
        

        
        
        //search based on created dates
        echo ("<br><h2>Records for all quotes CREATED BETWEEN chosen dates:</h2>");   
        if(isset($_POST['createdDate'])) {
            $cstartDate = $_POST["cstartDate"];
            $cendDate = $_POST["cendDate"];
            echo("<h2>" .$cstartDate. "    to    " .$cendDate. " </h2>");
            $cDate = $pdo->prepare("SELECT * from SQUOTE 
                        WHERE CREATED BETWEEN ? AND ?;"); 
            $cDate->execute(array($_POST["cstartDate"],$_POST["cendDate"]));
            $cDateRows = $cDate->fetchAll(PDO::FETCH_ASSOC);
       
            if ($cDateRows != false) {
                // display results.
                draw_table($cDateRows);
              } else {
                // there where no results
                echo "<h3>No records founds</h3>";
              }
        }
        echo ('
        <form name="searchCreate" method="post" action="">
            <p class="search_input">
                <label>Start Date:</label>
                <input type="date" name="cstartDate">
                <label>End Date:</label>
                <input type="date" name="cendDate">		 
                <input type="submit" name="createdDate" value="Search" >
                <br><br>
            </p>
        </form>');



        //search based on updated dates
        echo ("<br><h2>Records for all quotes UPDATED BETWEEN chosen dates:</h2>");
        if(isset($_POST['updatedDate'])) {
            echo("<h2>" .$_POST["ustartDate"]. "    to    " .$_POST["uendDate"]. " </h2>");
            $rs = $pdo->prepare("SELECT * from SQUOTE 
                        WHERE UPDATED BETWEEN ? AND ?;"); 
            $rs->execute(array($_POST["ustartDate"],$_POST["uendDate"]));
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
       
            if ($rows != false) {
                // display results.
                //echo ("<br><h2>Records for all quotes created between chosen dates:</h2>");
                draw_table($rows);
              } else {
                // there where no results
                echo "<h3>No records founds</h3>";
              }
        }

        echo('
        <form name="searchUpdate" method="post" action="">
            <p class="search_input">
                <label>Start Date:</label>
                <input type="date" name="ustartDate">
                <label>End Date:</label>
                <input type="date" name="uendDate">		 
                <input type="submit" name="updatedDate" value="Search" >
                <br><br><br><br><br><br><br><br><br><br>
            </p>
        </form>
        ');
  
    }

    catch(PDOexception $e){
        echo "Connection to database failed: " . $e->getMessage();
    }
?>
</html>

