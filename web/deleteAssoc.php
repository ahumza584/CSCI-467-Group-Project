<html><head><title>Add New Associate</title></head>
<?php
    session_start();
    error_reporting(E_ALL);

    include 'dblogin.php';

    try{
      
        if(isset($_POST["yes"])){
            $rs = $pdo->prepare("DELETE FROM ASSOCIATE
            WHERE ID = ?"); 
            $rs->execute(array($_GET['id']));
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            echo "<script>alert('Account successfully deleted!'); window.location='associates.php'</script>";
        }

        if(isset($_POST["no"])){
            header('location:associates.php');
        }
    
    }

    catch(PDOexception $e){
        echo "Connection to database failed: " . $e->getMessage();
    }
?>

<body>  
    <br/>  
    <div class="container" style="width:500px;">    
    <form method="POST">  
        <strong>ARE YOU SURE YOU WANT TO DELETE THIS USER?</strong>
        <button class="button" style='font-size:14;' name="yes">YES</button>
        <button class="button" style='font-size:14;' name="no">NO</button> 
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

