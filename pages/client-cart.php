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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body style="background-image: url('../images/dashboard-bg.jpg'); background-size: cover;">
  <div class="container">
    <?php
      include "client-navbar.php";
    ?>
    <div class="content">
      <section class="shopping-cart">
        <h1 class="title">Shopping Cart</h1>

        <table class="content-table" id="dataTable">
          <thead>
            <tr>
              <th>Name</th>
              <th>Price</th>
              <th>Cases</th>
              <th colspan="2">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $user_id = $_SESSION['user_id'];

              $grand_total = 0;
              $total_cases = 0;
              $cart_items = array();

              $select_products = mysqli_query($conn, "SELECT * FROM `tblproduct`") or die('Query failed');
              while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                $available_cases = floor($fetch_products['quantity'] / $fetch_products['bottles_per_case']);
              }

              $select_cart = mysqli_query($conn, "SELECT * FROM `tblcart` WHERE user_id = '$user_id'") or die('query failed');
              if(mysqli_num_rows($select_cart) > 0){
                  // Combine items with the same product ID into one entry
                  while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                      $product_id = $fetch_cart['product_id'];
                      if (!isset($cart_items[$product_id])) {
                          $cart_items[$product_id] = $fetch_cart;
                      } else {
                          // Add the quantities of the same product
                          $cart_items[$product_id]['product_quantity'] += $fetch_cart['product_quantity'];
                      }
                  }

                  // Display combined cart items
                  foreach ($cart_items as $cart_item) {
                      $product_id = $cart_item['product_id'];
                      // Calculate price based on the total cases
                      $total_price = $cart_item['product_quantity'] * $cart_item['product_price'];
                      $grand_total += $total_price;
                      $total_cases += $cart_item['product_quantity'];

                      // Skip the item if cases are zero
                      if ($cart_item['product_quantity'] == 0) {
                          continue;
                      }

                      // Fetch product name from tblproduct
                      $product_query = "SELECT productName FROM tblproduct WHERE id = $product_id";
                      $product_result = mysqli_query($conn, $product_query);
                      $product_data = mysqli_fetch_assoc($product_result);

                      // Fetch maximum available quantity
                      $max_quantity_query = "SELECT quantity FROM tblproduct WHERE id = $product_id";
                      $max_quantity_result = mysqli_query($conn, $max_quantity_query);
                      $max_quantity_data = mysqli_fetch_assoc($max_quantity_result);
                      $max_quantity = $max_quantity_data['quantity'];

                      echo "<tr>";
                      echo "<td>" . $product_data['productName'] . "</td>";
                      echo "<td>₱" . $total_price . "</td>";
                      echo "<td>";
                      echo "<form action='../php/update-cart.php' method='post'>";
                      echo "<input type='hidden' name='cart_id' value='" . $cart_item['id'] . "'>";
                      echo "<label>" . $cart_item['product_quantity'] . "</label>"; // Display current quantity as a label
                      echo "</td>";
                      echo "<td>";
                      // Input field for updating the quantity with maximum available
                      echo "<input type='number' name='new_quantity' value='0' min='1' max='$available_cases'>";
                      // Add the "Update" button
                      echo "<button type='submit' name='update_cart' class='option-btn'>Update</button>";
                      echo "</form>";
                      echo "</td>";
                      echo "<td>";
                      // Add the "Delete" button
                      echo "<form action='../php/delete-cart.php' method='post'>";
                      echo "<input type='hidden' name='cart_id' value='" . $cart_item['id'] . "'>";
                      echo "<input type='number' name='delete_quantity' value='0' min='1' max='" . $cart_item['product_quantity'] . "'>";
                      echo "<button type='submit' name='delete_cart' class='option-btn' onclick='return confirm(\"Delete this quantity from cart?\");'>Delete</button>";
                      echo "</form>";
                      echo "</td>";
                      echo "</tr>";
                  }

                  ?>
                  <tr>
                      <th style='text-align:right;'>Total</th>
                      <td colspan='3'>₱<?php echo $grand_total?> | Cases: <?php echo $total_cases;?></td>
                  </tr>
                  <?php
              } else {
                  echo '<tr><td colspan="4" class="empty">Your cart is empty</td></tr>';
              }
            ?>
          </tbody>
        </table>

        <?php
        if($total_cases >= 3){
        ?>
          <form action='client-checkout.php' method='post'>
            <button type='submit' name='checkout' class='checkout-btn'>Checkout</button>
          </form>
        <?php
        }
        ?>

      </section>
    </div>
  </div>
</body>
</html>
