<?php
/*
 * Replace these fields with the login info
 * of the host account
 */
$uname   = "YOUR SQL USERNAME";
$pass    = "YOUR SQL PASSWORD";
$db_name = "YOUR DATABASE NAME";

try {
    $dsn = "mysql:host=courses;dbname=" . $db_name;
    $pdo = new PDO($dsn, $uname, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOexception $e) {
    echo "Database connection failed, " . $e;
    exit();
}
    ?>
