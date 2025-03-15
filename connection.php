<?php
session_start();
    $server="localhost";
    $username="root";
    $password="" ;
    $database="printing_design";
    $con= mysqli_connect($server ,$username,$password,$database);
    if (!$con) {
        die("Connection failed: " .mysqli_connect_error());
    }else {
        echo "Connected successfully";
    }
<<<<<<< HEAD
    
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
=======
    //echo " Success connecting to the db";

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $sql= "INSERT INTO users(`name`, `email`, `password`) VALUES ( '$name', '$email', '$password');";
    //echo $sql;

    if($con->query($sql) == true){
        echo "Sucessfully recorded the response. Thank you!";
    }
    else{
        echo"Error: $sql <br> $con->error";
    }
    $con->close();
>>>>>>> 0b6697018430470c4bf1dfd763ff027c2ffa9aec
}
}
$con->close();
?>