<?php
session_start();
include "../php/header.php";

// Fetch data from your database - Assuming $conn is your database connection object
$query = "SELECT * FROM tbluser"; // Replace your_table_name with the actual table name
$result = $conn->query($query);

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
              <th>Username</th>
              <th>Email</th>
              <th>Fullname</th>
              <th>Contact</th>
              <th>Address</th>
              <th class="action-header">Accept</th>
              <th class="action-header">Decline</th>
            </tr>
          </thead>
          <tbody>
            <?php
              // Fetch data from your database
              $query = "SELECT * FROM tbluser where verification = 0"; // Replace tbluser with your actual table name
              $result = $conn->query($query);
              
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['fullname'] . "</td>";
                echo "<td>" . $row['contact'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td class='action-header'>";
                echo "<a href='../php/verification-accept.php?id=" . $row['id'] . "' class='icon-link'><i class='fas fa-check'></i></a>";
                echo "</td>";
                echo "<td class='action-header'>";
                echo "<a href='decline.php?id=" . $row['id'] . "' class='icon-link'><i class='fas fa-times'></i></a>";
                echo "</td>";
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
