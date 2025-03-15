<?php
session_start(); 
include 'connection.php';
// if($_SERVER['REQUEST_METHOD'] == 'POST'){
// if(isset($_POST['signup'])){
//     $name=$_POST['name'];
//     $email=$_POST['email'];
//     $password=$_POST['password'];
//     $password=md5($password);
//      $checkEmail="SELECT * From users where email='$email'";
//      $result=$con->query($checkEmail);
//      if($result->num_rows>0){
//         echo "Email Address Already Exists !";
//      }
//      else{
//         $insertQuery="INSERT INTO users(`name`,`email`,`password`)
//                        VALUES ('$name','$email','$password')";
//             if($con->query($insertQuery) == TRUE){
//                 header("location: login.html");
//             }
//             else{
//                 echo "Error: $insertQuery <br> $con->error";
//             }
//      }
// }
// }

// if($_SERVER['REQUEST_METHOD'] == 'POST'){
//     if(isset($_POST['sign In'])){
//     $email=$_POST['email'];
//     $password=$_POST['password'];
//     $password=md5($password) ;
   
//     $sql="SELECT * FROM users WHERE email='$email' and password='$password'";
//     $result=$con->query($sql);
//     if($result->num_rows>0){
//     $row=$result->fetch_assoc();
//     $_SESSION['email']=$row['email'];
//     header("Location: design-canvas.html");
//     exit();
//    }
//    else{
//     echo "Not Found, Incorrect Email or Password";
//    }
// }
// }
// $con->close();

?>