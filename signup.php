<?php
    require "connection.php";

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $name=trim($_POST["name"]);
        $email=trim($_POST["email"]);
        $password=trim($_POST["password"]);
        $confirm_password=trim($_POST["confirm-password"]);
        //validations
        if(empty($name) || empty($email) || empty($password) || empty($confirm_password)){
            die("All fields are required.");
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            die("Invalid email format.");
        }
        if($password!==$confirm_password){
            die("Passwords do not match.");
        }
        //hashed passwords
        $hashed_password=password_hash($password, PASSWORD_DEFAULT);
        $phone=$phone ?? "";
        $address=$address ?? "";

        $sql="INSERT INTO `users` ( `user_name`, `user_email`, `user_password`, `user_phone`, `user_address`) VALUES (?,?,?,?,?);";

        $stmt=$con->prepare($sql);
        if($stmt){
            $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $address);

            if($stmt->execute()){
                echo "Registration successful!";
            }
            else{
                echo"Error!" .$stmt->error;
            }

            $stmt->close();
        }
        else{
            echo "Database Error.";
        }
        $con->close();
        
    }
?>