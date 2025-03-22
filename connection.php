<?php
session_start();
    $server="localhost";
    $username="root";
    $password="" ;
    $database="printing design";
    $con= mysqli_connect($server ,$username,$password,$database);
    if (!$con) {
        die("Connection failed: " .mysqli_connect_error());
    }else {
        echo "Connected successfully";
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['sign In'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $password=md5($password) ;
   
    $sql="SELECT * FROM users WHERE email='$email' and password='$password'";
    $result=$con->query($sql);
    if($result->num_rows>0){
    $row=$result->fetch_assoc();
    $_SESSION['email']=$row['email'];
    header("Location: design-canvas.html");
    exit();
   }
   else{
    echo "Not Found, Incorrect Email or Password";
   }
}
}
// $con->close();
?>