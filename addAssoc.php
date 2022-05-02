<html><head><title>Add New Associate</title></head>
<?php
    session_start();
    error_reporting(E_ALL);

    include 'dblogin.php';
   
    try{
        echo ' <a href="associates.php">Go Back</a>'; //goes back to associates page if this is clicked
        
        //add associate to database
        if(isset($_POST["add"])){
            echo("inside add");
            $sql = $pdo->prepare("INSERT INTO ASSOCIATE (NAME, UNAME, PASSWD, ADDRESS, COMMISSION, PRIVLEVEL)
            VALUES(?, ?, ?, ?, ?, ?);"); 
            $sql->execute(array($_POST['name'], $_POST['uname'], $_POST['passwd'], $_POST['addr'], $_POST['comm'], $_POST['priv']));
            $rows = $sql->fetchAll(PDO::FETCH_ASSOC);
        
            echo "<script>alert('Account successfully added!'); window.location='associates.php'</script>";
        }
    
    }

    catch(PDOexception $e){
        echo "Connection to database failed: " . $e->getMessage();
    }
?>

<body>  
    <br/>  
    <div class="container" style="width:500px;">    
    <h1>Add New Associate</h1> 
    <form method="post">  
        <input type="text" name="name" placeholder="Name" class="form-control" style="height:5%"/>  
        <br/><br/>
        <input type="text" name="uname" placeholder="Username" class="form-control" style="height:5%"/>  
        <br/><br/> 
        <input type="password" name="passwd" placeholder ="Password" class="form-control" style="height:5%"/>  
        <br/><br/> 
        <input type="text" name="addr" placeholder="Address" class="form-control" style="height:5%"/>  
        <br/><br/>  
        <input type="text" name="comm" placeholder="Commision" class="form-control" style="height:5%"/>  
        <br/><br/>  
        <input type="text" name="priv" placeholder="Priveledge Level" class="form-control" style="height:5%"/>  
        <br/><br/>  
        <input type="submit" name="add" class="btn btn-info" value="Add"/>  
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

