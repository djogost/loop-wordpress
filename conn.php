<?php
$username = "root";
$password = "";
try {
    $pdo = new PDO('mysql:host=localhost;dbname=wordpress;charset=utf8', $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
ob_start( );

?>