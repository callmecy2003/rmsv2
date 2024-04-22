<?php
session_start();
include "../php/header.php";

// Check if transaction_id is set in POST
if (isset($_POST['transaction_id'])) {
    $transaction_id = $_POST['transaction_id'];

    // Update the tbltransaction to set archive to 1 for the given transaction ID
    $update_query = "UPDATE tbltransaction SET archive = 1 WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("i", $transaction_id);

    if ($stmt->execute()) {
        // If the update is successful, set a success message
        $archive_success = true;
    } else {
        // If the update fails, set an error message
        $archive_error = true;
    }
}

// Fetch all transactions including user emails
$select_transactions_query = "SELECT t.id, 
                                    DATE_FORMAT(t.transaction_date, '%M %e, %Y') AS formatted_date, 
                                    SUM(ti.quantity) AS total_cases, 
                                    SUM(ti.product_price * ti.quantity) AS total_price, 
                                    t.payment_method, 
                                    t.transaction_status, 
                                    GROUP_CONCAT(ti.product_name SEPARATOR ', ') AS items,
                                    u.email
                                FROM tbltransaction t 
                                INNER JOIN tbltransaction_items ti ON t.id = ti.transaction_id
                                INNER JOIN tbluser u ON t.user_id = u.id
                                WHERE t.archive = 0
                                GROUP BY t.id
                                ORDER BY t.id DESC"; // Order by ID in descending order
$stmt_transactions = $conn->prepare($select_transactions_query);
$stmt_transactions->execute();
$transactions_result = $stmt_transactions->get_result();

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
    
    <form method="POST" action="">
          <div class="search-bar">
            <label for="search">Search:</label>
            <input type="search" id="search" name="search" placeholder="Enter your search term">
          </div>
        </form>

    <table class="content-table" id="dataTable">
        <thead>
            <tr>
                <th>Tracking Number</th>
                <th>Date</th>
                <th>Total Cases</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Items</th>
                <th>Email</th> <!-- New column for email -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display transactions
            while ($transaction_row = $transactions_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $transaction_row['id'] . "</td>";
                echo "<td>" . $transaction_row['formatted_date'] . "</td>";
                echo "<td>" . $transaction_row['total_cases'] . "</td>";
                echo "<td>₱" . $transaction_row['total_price'] . "</td>";
                if($transaction_row['payment_method'] === "cash_on_delivery"){
                    echo "<td>COD</td>";
                }
                else if($transaction_row['payment_method'] === "gcash"){
                    echo "<td>GCash</td>";
                }
                else{
                    echo "<td>Paymaya</td>";
                }
                echo "<td>" . $transaction_row['transaction_status'] . "</td>";
                echo "<td>" . $transaction_row['items'] . "</td>";
                echo "<td>" . $transaction_row['email'] . "</td>"; // Display email
                echo "<td>
                        <form method='POST' action=''>
                            <input type='hidden' name='transaction_id' value='" . $transaction_row['id'] . "'>
                            <button type='submit' name='archive_button'>Archive</button>
                        </form>
                      </td>"; // Archive button
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
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
