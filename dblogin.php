<?php
$uname   = "z1913636";
$pass    = "2000May03";
$db_name = "z1913636";

try {
    $dsn = "mysql:host=courses;dbname=z1913636";
    $pdo = new PDO($dsn, $uname, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOexception $e) {
    echo "Database connection failed, " . $e;
    exit();
}
    ?>