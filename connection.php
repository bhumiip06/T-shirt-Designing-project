<?php
if(isset($_POST['name'])){
    $server="localhost";
    $username="root";
    $password="" ;
    $database="printing design";

    $con= mysqli_connect($server ,$username,$password,$database);

    if(!$con){
        die("connection to this databse failed due to". mysqli_connect_error());
    }
    //echo " Success connecting to the db";

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $sql= "INSERT INTO user(`name`, `email`, `password`) VALUES ( '$name', '$email', '$password');";
    //echo $sql;

    if($con->query($sql) == true){
        echo "Sucessfully recorded the response. Thank you!";
    }
    else{
        echo"Error: $sql <br> $con->error";
    }
    $con->close();
}
?>