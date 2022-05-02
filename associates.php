<html><head><title>Associates Info</title></head>

    <!--    
        Maria Sofia
        Z1940447
        Quote System

        This is the associates page for the admin interface.
        The interface allows to view, add, edit and delete sales associate records. 
    -->

<?php

function display_all_associates() {
    echo("
    <table border=solid>
        <tr>
        <th> ID </th>
        <th> Name </th>
        <th> Address </th>
        <th> commission </th>
        <th> Username </th>
        <th> Password </th>
        <th> Privelege Level </th>
        </tr>
    ");
    $assocIds = get_all_associate_ids();
    foreach($assocIds as $AssociateId) {
        $ainfo = GetAssocInfo($AssociateId);
        echo("<tr>");
            echo ("<td>" . $AssociateId        . "</td>");
            echo ("<td>" . $ainfo['Name']      . "</td>");
            echo ("<td>" . $ainfo['Address']   . "</td>");
            echo ("<td>" . $ainfo['Commision'] . "</td>");
            echo ("<td>" . $ainfo['Username']  . "</td>");
            echo ("<td>" . "WITHHELD"          . "</td>");
            echo ("<td>" . $ainfo['AuthLevel'] . "</td>");
            echo '<td><a href="editAssoc.php?id='.$AssociateId.'">Edit</a></td>';
            echo '<td><a href="deleteAssoc.php?id='.$AssociateId.'">Delete</a></td>';
        echo("</tr>");
    }
    //echo("</table>");
}


    session_start();
    error_reporting(E_ALL);

    include 'secrets.php';
    include 'library.php';
    //include 'dbman.php';
    include 'dbfunctions.php';
   
    try{
        //connection
        $dsn = "mysql:host=courses;dbname=z1940447";
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

        echo ' <a href="adminHome.php">Home</a>'; //goes back to admin home page if this is clicked
        display_all_associates();

        if(isset($_POST["add"]))  
        {  
            header("location:addAssoc.php"); 
        }
        
        /*echo ("<h1>\nSales Associates:\n<h1>");
            $rs = $pdo->query("SELECT * FROM ASSOCIATE;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            draw_table($rows);

        echo'<h2>View Records</h2>
            <table width="100%" border="1" style="border-collapse:collapse;">
            <thead>
            <tr>
            <th><strong>S.No</strong></th>
            <th><strong>Name</strong></th>
            <th><strong>Age</strong></th>
            <th><strong>Edit</strong></th>
            <th><strong>Delete</strong></th>
            </tr>
            </thead>
            <tbody>';
        
        $count=1;
        $sel_query="SELECT * FROM ASSOCIATE;";
        $result = mysqli_query($pdo,$sel_query);
        while($row = mysqli_fetch_assoc($result)) {
            echo
            '<tr><td align="center"><?php echo $count; ?></td>
            <td align="center"><?php echo $row["Name"]; ?></td>
            <td align="center"><?php echo $row["PASSWD"]; ?></td>
            <td align="center">
            <a href="edit.php?id=<?php echo $row["ID"]; ?>">Edit</a>
            </td>
            <td align="center">
            <a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a>
            </td>
            </tr>';
            $count++; 
        }
        echo
        '</tbody>
        </table>';*/
    
    }

    catch(PDOexception $e){
        echo "Connection to database failed: " . $e->getMessage();
    }
?>

<body>  
    <br/>  
    <div class="container" style="width:500px;"> 
    <h1> Associates </h1>   
    <form method="POST">  
        <button class="button" style='font-size:14;' name="add">Add New Associate</button>
    </form>  
    <?php  
        if(isset($message))  
        {  
            echo '<label class="text-danger">'.$message.'</label>';  
        }  
    ?>
        </div>  
        <br/>  
</body></html>

