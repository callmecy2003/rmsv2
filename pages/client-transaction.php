<?php
session_start();
include "../php/header.php";

// Fetch transactions for the user
$user_id = $_SESSION['user_id'];
$select_transactions_query = "SELECT t.id, 
                                      DATE_FORMAT(t.transaction_date, '%M %e, %Y') AS formatted_date, 
                                      SUM(ti.quantity) AS total_cases, 
                                      SUM(ti.product_price * ti.quantity) AS total_price, 
                                      t.payment_method, 
                                      t.transaction_status, 
                                      GROUP_CONCAT(ti.product_name SEPARATOR ', ') AS items 
                                FROM tbltransaction t 
                                INNER JOIN tbltransaction_items ti ON t.id = ti.transaction_id
                                WHERE t.user_id = ? 
                                GROUP BY t.id";
$stmt_transactions = $conn->prepare($select_transactions_query);
$stmt_transactions->bind_param("s", $user_id);
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
      include "client-navbar.php";
    ?>
    <div class="content">


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
                echo "</tr>";

            }
            ?>
        </tbody>
    </table>
    </div>
  </div>
</body>
</html>
