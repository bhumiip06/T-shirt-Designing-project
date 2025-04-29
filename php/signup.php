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

            if ($stmt->execute()) {
                echo '
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        .toast {
                            visibility: hidden;
                            min-width: 250px;
                            margin-left: -125px;
                            background-color: #4BB543;
                            color: white;
                            text-align: center;
                            border-radius: 8px;
                            padding: 16px;
                            position: fixed;
                            z-index: 1;
                            left: 50%;
                            bottom: 30px;
                            font-size: 17px;
                            opacity: 0;
                            transition: opacity 0.5s, bottom 0.5s;
                        }
            
                        .toast.show {
                            visibility: visible;
                            opacity: 1;
                            bottom: 50px;
                        }
                    </style>
                </head>
                <body>
                    <div id="toast" class="toast">Registration Successful</div>
                    <script>
                        const toast = document.getElementById("toast");
                        toast.classList.add("show");
            
                        setTimeout(() => {
                            toast.classList.remove("show");
                        }, 2000);
            
                        setTimeout(() => {
                            window.location.href = "../login.html";
                        }, 2200);
                    </script>
                </body>
                </html>
                ';
                exit;
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