<?php
session_start();
include "../php/header.php";
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
    <?php include "../php/header.php"; ?>
    <?php include "navbar.php"; ?>
    <div class="content">
      <center>
        <form method="POST" action="">
          <div class="search-bar">
            <label for="search">Search:</label>
            <input type="search" id="search" name="search" placeholder="Enter your search term">
          </div>
        </form>
        <table class="content-table" id="dataTable">
          <thead>
            <tr>
              <th>User ID</th>
              <th>Username</th>
              <th>Email</th>
              <th>Full Name</th>
              <th>Gender</th>
              <th>Contact Number</th>
              <th>User Type</th>
              <th>Address</th>
              <th>Verification</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Fetch all users
            $select_users_query = "SELECT * FROM tbluser";
            $stmt_users = $conn->prepare($select_users_query);
            $stmt_users->execute();
            $users_result = $stmt_users->get_result();

            // Display users
            while ($user_row = $users_result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $user_row['id'] . "</td>";
              echo "<td>" . $user_row['username'] . "</td>";
              echo "<td>" . $user_row['email'] . "</td>";
              echo "<td>" . $user_row['fullname'] . "</td>";
              echo "<td>" . $user_row['gender'] . "</td>";
              echo "<td>" . $user_row['contact'] . "</td>";
              echo "<td>" . $user_row['userType'] . "</td>";
              echo "<td>" . $user_row['address'] . "</td>";
              echo "<td>" . ($user_row['verification'] ? 'Verified' : 'Not Verified') . "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </center>
    </div>
  </div>

  <script>
    function filterTable() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("search");
      filter = input.value.toUpperCase();
      table = document.getElementById("dataTable");
      tr = table.getElementsByTagName("tr");

      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
          if (td[j]) {
            txtValue = td[j].textContent || td[j].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
              tr[i].style.display = "";
              break;
            } else {
              tr[i].style.display = "none";
            }
          }
        }
      }
    }

    // Attach the filterTable function to the input field's input event
    document.getElementById("search").addEventListener("input", filterTable);
  </script>
</body>
</html>
