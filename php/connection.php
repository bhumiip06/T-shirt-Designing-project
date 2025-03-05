<?php
if(isset($_POST['name'])){
    $server="localhost";
    $username="root";
    $password="" ;

    $con= mysqli_connect($server ,$username,$password);

    if(!$con){
        die("connection to this databse failed due to". mysqli_connect_error());
    }
    //echo " Success connecting to the db";

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $sql= "INSERT INTO `form`.`register`(`S.no`, `name`, `email`, `password`, `date`) VALUES (NULL, '$name', '$email', '$password', current_timestamp());";
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