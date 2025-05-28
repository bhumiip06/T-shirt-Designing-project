<?php
session_start();  // Start the session
include 'connection.php';  // Include the database connection file
if($_SERVER['REQUEST_METHOD']==='POST'){

    if(isset($_POST['email']) && isset($_POST['login_password']))
    $email=$_POST['email'];
    $password=$_POST['login_password'];
    $sql="SELECT user_id,user_password,user_name FROM users where user_email=:email";
    $stmt=$pdo->prepare($sql);
    $stmt->bindParam(':email',$email);

    $stmt->execute();
    $user=$stmt->fetch(PDO::FETCH_ASSOC);

    if($user){

        if(password_verify($password,$user['user_password'])){
           // echo"Login Successful";
           $_SESSION['user_id']=$user['user_id'];
           $_SESSION['username']=$user['user_name']; //sets username in the session
           $_SESSION['user_email']=$email; //sets email in the session
           
           header('Location: check_session.php');
           exit();
        }
        else{
            header("Location: ../login.html?error=invalid");
            exit();
        }
    }else{
        header("Location: ../login.html?error=noaccount");
        exit();
    }

    $pdo=null;
}
?>