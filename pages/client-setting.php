<?php
session_start();
include "../php/header.php";

$user_id = $_SESSION['user_id'];

// Fetch user data from the database based on user ID
$select_query = "SELECT * FROM tbluser WHERE id = '$user_id'";
$result = mysqli_query($conn, $select_query);
$user_data = mysqli_fetch_assoc($result);

$message = array(); // Initialize an array to store messages

if(isset($_POST['update'])){
   // Get form data and sanitize inputs
   $username = mysqli_real_escape_string($conn, $_POST['username']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
   $contact = mysqli_real_escape_string($conn, $_POST['contact']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);
   $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the new password

   // Update user information in the database, including password
   $update_query = "UPDATE tbluser SET username = '$username', email = '$email', fullname = '$fullname', contact = '$contact', address = '$address', password = '$password' WHERE id = '$user_id'";
   if(mysqli_query($conn, $update_query)) {
      $message[] = 'Information updated successfully!';
      // Refresh user data after update
      $user_data['username'] = $username;
      $user_data['email'] = $email;
      $user_data['fullname'] = $fullname;
      $user_data['contact'] = $contact;
      $user_data['address'] = $address;
      // Set session variable to indicate successful update
      $_SESSION['update_success'] = true;
      // Redirect to prevent form resubmission on page refresh
      header("Location: ".$_SERVER['PHP_SELF']);
      exit();
   } else {
      $message[] = 'Error: ' . mysqli_error($conn);
   }
}

// Check if the session variable is set indicating successful update
if(isset($_SESSION['update_success']) && $_SESSION['update_success']) {
   // JavaScript to show alert
   echo '<script>alert("Information updated successfully!");</script>';
   // Unset the session variable
   unset($_SESSION['update_success']);
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
        input[type="password"],
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
    margin-top: 10px; /* Adjust the top margin */
    margin-bottom: 20px; /* Adjust the bottom margin */
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
<body>
<body style="background-image: url('../images/dashboard-bg.jpg'); background-size: cover;">

<div class="container">
    <?php include "client-navbar.php"; ?>
    <div class="content">
        <table class="content-table" id="dataTable">
        <thead>
                <tr>
            
                </tr>
            </thead>
        <?php
            // Display success or error messages
            if(!empty($message)) {
                foreach($message as $msg) {
                    echo '<p>' . $msg . '</p>';
                }
            }
        ?>
        <form action="" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $user_data['username']; ?>">
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $user_data['email']; ?>" >
            </div>
            <div>
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo $user_data['fullname']; ?>">
            </div>
            <div>
                <label for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" value="<?php echo $user_data['contact']; ?>">
            </div>
            <div>
                <label for="address">Address:</label>
                <textarea id="address" name="address" required><?php echo $user_data['address']; ?></textarea>
            </div>
            <div>
                <label for="password">New Password:</label>
                <input type="password" id="password" name="password">
            </div>
            <div>
                <input type="submit" value="Update Information" name="update">
            </div>
        </form>
    </div>
</div>

</body>
</html>
