
<html><head><title>Quote System Login</title></head>

    <!--    
        Maria Sofia
        Z1940447
        Quote System

        This is the home page for the admin interface.
        The admin has the option to either go to the 
        associates.php page or quotes.php page
    -->

<?php
    session_start();
    error_reporting(E_ALL);

    include 'dblogin.php';
   
    try{

      if(isset($_POST["assoc"]))  
      {  
        header("location:associates.php"); 
      }

      if(isset($_POST["quotes"]))  
      {  
        header("location:quotes.php"); 
      }
    
    }

    catch(PDOexception $e){
        echo "Connection to database failed: " . $e->getMessage();
    }
?>

<body>  
    <br/>  
    <div class="container" style="width:500px;">    
    <h1>What would you like to view?</h1>
    <form method="post">  
        <br/> 
        <input type="submit" name="assoc" class="btn btn-info" value="View Associates"/>  
        <input type="submit" name="quotes" class="btn btn-info" value="View Quotes"/>  
        <br/><br/>

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

