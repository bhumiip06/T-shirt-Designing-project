<?php
// session_start();
    $server="localhost";
    $username="root";
    $password="" ;
    $database="printing design";
    $con= mysqli_connect($server ,$username,$password,$database);
    // if (!$con) {
    //     die("Connection failed: " .mysqli_connect_error());
    // }else {
    //     echo "Connected successfully";
    // }
//PDO initialize
    try{
        $pdo=new PDO("mysql:host=$server;dbname=$database",$username,$password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOEXCEPTION $e){
        die("Connection failed:".$e->getMessage());
    }
?>