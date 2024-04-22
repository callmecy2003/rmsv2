<?php
session_start();
include "../php/header.php";

$user_id = $_SESSION['user_id'];

$message = array(); // Initialize an array to store messages

if(isset($_POST['send'])){
   // Get form data and sanitize inputs
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = mysqli_real_escape_string($conn, $_POST['number']);
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   // Insert the message into the database
   $insert_query = "INSERT INTO `tblmessage` (user_id, name, email, number, message) VALUES ('$user_id', '$name', '$email', '$number', '$msg')";
   if(mysqli_query($conn, $insert_query)) {
      $message[] = 'Message sent successfully!';
      // Redirect to prevent form resubmission on page refresh
      header("Location: ".$_SERVER['PHP_SELF']);
      exit();
   } else {
      $message[] = 'Error: ' . mysqli_error($conn);
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="../css/client-shop.css" />
    <link rel="stylesheet" href="../css/navbar.css" />
    <link rel="stylesheet" href="../css/client-dashboard.css" />
    <link rel="stylesheet" href="../css/table.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
    <style>
        /* Style the form container */
        .form-container {
          max-width: 500px;
          margin: 0 auto;
          padding: 20px;
          background-color: #f9f9f9;
          border-radius: 5px;
          box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Style form groups */
        .form-group {
          margin-bottom: 20px;
        }

        /* Style labels */
        label {
          display: block;
          margin-bottom: 5px;
          font-weight: bold;
        }

        /* Style input fields */
        input[type="text"],
        input[type="email"],
        textarea {
          width: 100%;
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 5px;
        }

        /* Style submit button */
        input[type="submit"] {
          width: 100%;
          padding: 10px;
          background-color: #007bff;
          color: #fff;
          border: none;
          border-radius: 5px;
          cursor: pointer;
        }

        /* Change submit button color on hover */
        input[type="submit"]:hover {
          background-color: #0056b3;
        }
    </style>
</head>
<body style="background-image: url('../images/dashboard-bg.jpg'); background-size: cover;">

<div class="container">
    <?php include "client-navbar.php"; ?>
    <div class="content">
        <table class="content-table" id="dataTable">
            <thead>
                <tr>
                    <td><h3>Contact Us</h3></td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php
                            // Display success or error messages
                            if(!empty($message)) {
                                foreach($message as $msg) {
                                    echo '<p>' . $msg . '</p>';
                                }
                            }
                        ?>
                        <form action="" method="post" id="contactForm">
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" id="name" name="name" required placeholder="Enter your name">
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" id="email" name="email" required placeholder="Enter your email">
                            </div>
                            <div class="form-group">
                                <label for="number">Phone Number:</label>
                                <input type="text" id="number" name="number" required placeholder="Enter your phone number">
                            </div>
                            <div class="form-group">
                                <label for="message">Message:</label>
                                <textarea id="message" name="message" required placeholder="Enter your message"></textarea>
                            </div>
                            <input type="submit" value="Send Message" name="send">
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- JavaScript code for displaying alert -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var contactForm = document.getElementById("contactForm");
        contactForm.addEventListener("submit", function(event) {
            alert("Message sent successfully!");
        });
    });
</script>

</body>
</html>
