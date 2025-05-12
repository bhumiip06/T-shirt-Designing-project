<?php
require "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sender_name = trim($_POST['sender_name']);
        $sender_email = trim($_POST['sender_email']);
        $message_content = trim($_POST['message_content']);
        $message_type=trim($_POST['message_type']);
        $status=$_POST['status'];

        if (!empty($sender_name) && !empty($sender_email) && !empty($message_content)) {
            if (filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
                $sql = "INSERT INTO `contact_messages`(`sender_name`, `sender_email`, `message_content`, `status`, `message_type`) VALUES (?,?,?,?,?);";

                $stmt = $con->prepare($sql);
                if ($stmt === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                // Bind the form values to the SQL query
                $stmt->bind_param("sssss", $sender_name, $sender_email, $message_content,$status,$message_type);
        
                if ($stmt->execute()) {
                    echo '<!DOCTYPE html>
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
                    <div id="toast" class="toast">Thank You for your Response.<br>We will be Contacting you soon.</div>
                    <script>
                        const toast = document.getElementById("toast");
                        toast.classList.add("show");
            
                        setTimeout(() => {
                            toast.classList.remove("show");
                        }, 2000);
            
                        setTimeout(() => {
                            window.location.href = "../index.html";
                        }, 2200);
                    </script>
                </body>
                </html>
                ';
                exit;
                } else {
                    echo"Error!" .$stmt->error;
                }
                $stmt->close();
            } else {
                echo "Invalid email format. Please enter a valid email address.";
            }
        } else {
            echo "All fields are required. Please fill in the form completely.";
        }
    }
?>