<html><head><title>Associates Info</title></head>

    <!--    
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

}


    session_start();
    error_reporting(E_ALL);

    include 'dblogin.php';
    include 'library.php';
    include 'dbfunctions.php';
   
    try{

        echo ' <a href="adminHome.php">Home</a>'; //goes back to admin home page if this is clicked
        display_all_associates();

        if(isset($_POST["add"]))  
        {  
            header("location:addAssoc.php"); 
        }
    
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

