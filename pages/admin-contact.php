<?php

session_start();
include "../php/header.php";

$admin_id = $_SESSION['user_id'];



if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `tblmessage` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin-contact.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Record Management | Soft Drinks & Liquor Trader</title>
  <link rel="stylesheet" href="../css/navbar.css" />
  <link rel="stylesheet" href="../css/client-dashboard.css" />
  <link rel="stylesheet" href="../css/search-bar.css" />
  <link rel="stylesheet" href="../css/table.css" />
  
    <!-- Font Awesome Cdn Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
<body style="background-image: url('../images/dashboard-bg.jpg'); background-size: cover;">
  <div class="container">
  <?php
      include "navbar.php";
?>
    <div class="content">
    

<section class="messages">
    <h1 class="title">Messages</h1>

    <div class="box-container">
        <table class="content-table" id='dataTable'>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Message</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $select_message = mysqli_query($conn, "SELECT * FROM `tblmessage`") or die('query failed');
                if(mysqli_num_rows($select_message) > 0){
                    while($fetch_message = mysqli_fetch_assoc($select_message)){
                        echo "<tr>";
                        echo "<td>{$fetch_message['user_id']}</td>";
                        echo "<td>{$fetch_message['name']}</td>";
                        echo "<td>{$fetch_message['email']}</td>";
                        echo "<td>{$fetch_message['number']}</td>";
                        echo "<td>{$fetch_message['message']}</td>";
                        echo "<td><a href='admin-contact.php?delete={$fetch_message['id']}' onclick=\"return confirm('Delete this message?');\" class='delete-btn'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo '<tr><td colspan="6" class="empty">No messages!</td></tr>';
                }
            ?>
            </tbody>
        </table>
    </div>

</section>

</body>
</html>

