<html><head><title>Quotes Info</title></head>

    <!--    
        Maria Sofia
        Z1940447
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
    include 'library.php';
   
    try{
        echo ' <a href="adminHome.php">Home</a>'; //goes back to admin home page if this is clicked

        echo ("<h1>\nQuotes:\n<h1>");

        $sql="SELECT NAME,ID FROM ASSOCIATE order by NAME"; 
        echo "<form method='post'><select name=associate onchange='javascript: submit()' value=''>Associate Name</option>"; // list box select command
        echo "<option value=all>All</option>";
        foreach ($pdo->query($sql) as $row){//Array or records stored in $row
            echo "<option value=$row[ID]>($row[ID]) $row[NAME]</option>"; 
            /* Option values are added by looping through the array */ 
        }
        echo "<br></select></form>";// Closing of list box
        
        if(isset($_POST['associate'])) {
            $id = $_POST['associate'];
            $rs = $pdo->query("SELECT * FROM SQUOTE WHERE OWNER = $id;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            if ($rows != false) {
                // display results.
                draw_table($rows);
              } else {
                // there where no results
                echo "<h3>No records founds</h3>";
              }
        }

        $sql="SELECT DISTINCT STATUS FROM SQUOTE"; 

        echo "<form method='post'><select name=status onchange='javascript: submit()' value=''>Quote Status</option>"; // list box select command
        echo "<option value=all>All Status</option>";
        foreach ($pdo->query($sql) as $row){//Array or records stored in $row
            echo "<option value=$row[STATUS]>$row[STATUS]</option>"; 
            /* Option values are added by looping through the array */ 
        }
        echo "<br></select></form>";// Closing of list box

        if(isset($_POST['status'])) {
            $status = $_POST['status'];
            $rs = $pdo->query("SELECT * FROM SQUOTE WHERE STATUS = $status;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            if ($rows != false) {
                // display results.
                draw_table($rows);
              } else {
                // there where no results
                echo "<h3>No records founds</h3>";
              }
        }

        else{
            $rs = $pdo->query("SELECT * FROM SQUOTE;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            draw_table($rows);
        }

    
    }

    catch(PDOexception $e){
        echo "Connection to database failed: " . $e->getMessage();
    }
?>

<body>  
     
</body></html>

