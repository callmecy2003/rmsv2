<?php
session_start();
include "../php/header.php";

// Check if search term is provided
$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Construct the SQL query based on the search term
$query = "SELECT * FROM tblproduct";
if (!empty($searchTerm)) {
    $query .= " WHERE productName LIKE '%$searchTerm%'";
}

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
  <style>
    .popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgba(0, 0, 0, 0.5);
      padding: 20px;
      border-radius: 10px;
      z-index: 999;
    }
    .quantity-input {
      width: 50px;
    }
  </style>
</head>
<body style="background-image: url('../images/dashboard-bg.jpg'); background-size: cover;">
  <div class="container">
    <?php include "navbar.php"; ?>
    <div class="content">
      <center>
        <form method="POST" action="">
          <div class="search-bar">
            <label for="search">Search:</label>
            <input type="search" id="search" name="search" placeholder="Enter your search term" value="<?php echo $searchTerm; ?>">
            <button type="submit">Search</button>
          </div>
        </form>
        <!-- Popup for Add Product -->
        <div id="addProductPopup" class="popup">
  <div class="banner-block">
    <h1>Add Product</h1>
    <form action="../php/product-insert.php" method="post" enctype="multipart/form-data">
      <label for="product_name">Product Name:</label><br>
      <input type="text" id="product_name" name="product_name" required><br><br>

      <label for="product_price">Product Price (Per bottle):</label><br>
      <input type="text" id="product_price" name="product_price" required><br><br>

      <label for="bottles_per_case">Bottles per Case:</label><br>
      <input type="number" id="bottles_per_case" name="bottles_per_case" required min="1"><br><br>

      <label for="product_quantity">Product Quantity:</label><br>
      <input type="number" id="product_quantity" name="product_quantity" required min="1"><br><br>

      <label for="product_image">Product Image:</label><br>
      <input type="file" id="product_image" name="product_image" required><br><br>

      <input type="submit" value="Add Product" name="add_product">
    </form>
    <div class="btn-container">
      <button class="cancel-btn" onclick="hidePopup()">Cancel</button>
    </div>
  </div>
</div>



        <!-- Button to trigger Add Product Popup -->
        <button id="addProductBtn">Add Product</button>
        <table class="content-table" id="dataTable">
          <thead>
            <tr>
              <th>Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Restock</th>
            </tr>
          </thead>
          <tbody>
            <?php
              while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['productName'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['quantity'] . "</td>";
                echo "<td>";
                echo "<form action='../php/restock-product.php' method='post'>";
                echo "<input type='hidden' name='product_id' value='" . $row['id'] . "'>";
                echo "<input type='number' class='quantity-input' name='restock_quantity' value='0' min='1'>";
                echo "<button type='submit'>Restock</button>";
                echo "</form>";
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
    // Function to show the popup
    function showPopup() {
      document.getElementById("addProductPopup").style.display = "block";
    }

    // Function to hide the popup
    function hidePopup() {
      document.getElementById("addProductPopup").style.display = "none";
    }

    // Event listener for the Add Product button click
    document.getElementById("addProductBtn").addEventListener("click", showPopup);
  </script>
</body>
</html>
