<?php
session_start();  // Start the session
include 'connection.php';  // Include the database connection file
if($_SERVER['REQUEST_METHOD']==='POST'){

    if(isset($_POST['email']) && isset($_POST['login_password']))
    $email=$_POST['email'];
    $password=$_POST['login_password'];
    $sql="SELECT user_password FROM users where user_email=:email";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':email',$email);

    $stmt->execute();
    $user=$stmt->fetch(PDO::FETCH_ASSOC);

    if($user){

        if(password_verify($password,$user['user_password'])){
           // echo"Login Successful";
           header('Location: design-canvas.html');
        }
        else{
            echo"Invalid email or password";
        }
    }else{
        echo"No account found with that email.";
    }

    $con->close();
}
?>