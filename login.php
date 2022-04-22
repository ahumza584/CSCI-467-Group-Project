<html><head><title>Quote System Login</title></head>
<?php
    session_start();
    error_reporting(E_ALL);

    $username = ' ';    //  zid
    $password = ' ';    //  password to db

    try{
        //connection
        $dsn = "mysql:host=courses;dbname=z193636";  // <----- change to your zid
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);

        if(isset($_POST["login"]))  
      {  
           if(empty($_POST["id"]) || empty($_POST["password"]))  
           {  
                $message = '<label>*All fields are required</label>';  
           }  
           else  
           {  
                $username2 = $_POST['id'];
			    $password2 = $_POST['password'];
                
                $sql = "SELECT * FROM ASSOCIATE WHERE ID=? AND PASSWD=? ";
			    $query = $pdo->prepare($sql);
			    $query->execute(array($username2,$password2));
   
                $count = $query->rowCount();  
                if($count > 0)  
                {   
                     header("location:createQuote.php");  
                }  
                else  
                { 
                    $message = '<label>*Incorrect login info. Try again.</label>';  
                }  
           }  
      }
    
    }

    catch(PDOexception $e){
        echo "Connection to database failed: " . $e->getMessage();
    }
?>

<body>  
    <br/>  
    <div class="container" style="width:500px;">  
    <?php  
        if(isset($message))  
        {  
            echo '<label class="text-danger">'.$message.'</label>';  
        }  
    ?>  
    <h1>Associate Login for Quote System</h1> 
    <form method="post">  
        <input type="text" name="id" placeholder="Enter Associate ID" class="form-control" style="height:5%"/>  
        <br/><br/>   
        <input type="password" name="password" placeholder ="Password" class="form-control" style="height:5%"/>  
        <br/><br/> 
        <input type="submit" name="login" class="btn btn-info" value="Login"/>  
    </form>  
        </div>  
        <br/>  
</body></html>

