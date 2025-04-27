<?php
require "connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sender_name = trim($_POST['sender_name']);
        $sender_email = trim($_POST['sender_email']);
        $message_content = trim($_POST['message_content']);

        if (!empty($sender_name) && !empty($sender_email) && !empty($message_content)) {
            if (filter_var($sender_email, FILTER_VALIDATE_EMAIL)) {
                $sql = "INSERT INTO `contact_messages`(`sender_name`, `sender_email`, `message_content`) VALUES (?,?,?);";

                $stmt = $con->prepare($sql);
                if ($stmt === false) {
                    die('MySQL prepare error: ' . $con->error);
                }
                // Bind the form values to the SQL query
                $stmt->bind_param("sss", $sender_name, $sender_email, $message_content);
        
                if ($stmt->execute()) {
                    echo "Thank you for contacting us. We will get back to you soon!";
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