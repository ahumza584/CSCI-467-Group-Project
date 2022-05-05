<?php 
include('dblogin.php');
$ID=$_GET['id'];

echo ($ID);
?>
<body>

<div class="hero-unit-3">

<?php
$result = $pdo->prepare("SELECT * FROM ASSOCIATE where ID='$ID'");
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
$id=$row['ID'];
?>
<form class="form-horizontal" method="post" action="edit_PDO.php<?php echo '?ID ='.$id; ?>"  enctype="multipart/form-data" style="float: center;">
                                <a href="associates.php" class="btn">Back</a> <br>
                                <h1>Edit Associate Information</h1>
                                
								<div class="control-group">
                                    <label style="font-weight: bold;" class="control-label" for="inputPassword">ID:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="ID" required value=<?php echo $row['ID']; ?>> <br><br>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label style="font-weight: bold;" class="control-label" for="inputPassword">Name:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="NAME" required value=<?php echo $row['NAME']; ?>> <br><br>
                                    </div>
                                </div>
								<div class="control-group">
                                    <label style="font-weight: bold;" class="control-label" for="inputPassword">Username:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="UNAME" required value=<?php echo $row['UNAME']; ?>> <br><br>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label style="font-weight: bold;" class="control-label" for="inputPassword">Address:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="ADDRESS" required value=<?php echo $row['ADDRESS']; ?>> <br><br>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label style="font-weight: bold;" class="control-label" for="inputPassword">Commission:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="COMMISSION" required value=<?php echo $row['COMMISSION']; ?>> <br><br>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label style="font-weight: bold;" class="control-label" for="inputPassword">Password:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="PASSWD" required value=<?php echo $row['PASSWD']; ?>> <br><br>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label style="font-weight: bold;" class="control-label" for="inputPassword">Priveledge Level:</label>
                                    <div class="controls">
                                        <input type="text" style="height:5%" name="PRIVLEVEL" required value=<?php echo $row['PRIVLEVEL']; ?>> <br><br>
                                    </div>
                                </div>
								
								 <div class="control-group">
                                    <div class="controls">

                                        <button type="submit" name="update" class="btn btn-success" style="margin-right: 65px;">Save</button>
                                    </div>
                                </div>
                            </form>
<?php } ?>

</body>
</html>
								