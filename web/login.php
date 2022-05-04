<html><head><title>Quote System Login</title></head>
<?php

/*
    This page also logs you out if visited
    while logged in
*/

    include_once 'activate_debug.php';
    include_once 'dblogin.php';
    include_once 'dbfunctions.php';

    if(array_key_exists('login',$_POST)) {
        if(empty($_POST['id']) || empty($_POST['password'])) {
            $message = '<label>*All fields are required</label>';
        }
        else {
            $res = attempt_login($_POST['id'], $_POST['password']);
            if ($res < 0) { //If no user is found
                $message = '<label>*Incorrect login info. Try again.</label>';
            } else          //Otherwise, go to other
            {
                //Start session upon success, and redirect to quote creation page
                session_start();
                $_SESSION['UID'] = $res;
                header("location:createQuote.php");
            }
        }

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
