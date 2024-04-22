<?php
session_start();
include "../php/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Record Management | Soft Drinks & Liquor Trader</title>
  <link rel="stylesheet" href="../css/client-shop.css" />
  <link rel="stylesheet" href="../css/navbar.css" />
  <link rel="stylesheet" href="../css/client-dashboard.css" />

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
      <section class="products">
        <h1 class="title">Latest Products</h1>

        <div class="products-grid">
          <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `tblproduct`") or die('Query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                  <div class="item-details">
                      <img class="image" src="<?php echo $fetch_products['image']; ?>" alt="">
                      <h4><?php echo $fetch_products['productName']; ?></h4>
                      <?php
                      // Format price per case
                      $price_per_case = $fetch_products['price'] * $fetch_products['bottles_per_case'];
                      $formatted_price_per_case = number_format((float)$price_per_case, 2, '.', '');
                      // Calculate available cases
                      $available_cases = floor($fetch_products['quantity'] / $fetch_products['bottles_per_case']);
                      ?>
                      <p class="price">Price per Case: ₱<?php echo $formatted_price_per_case; ?></p>
                      <p class="cases">Available Cases: <?php echo $available_cases; ?></p> <!-- Display available cases -->
                      <p class="bottles-per-case">Bottles per Case: <?php echo $fetch_products['bottles_per_case']; ?></p> <!-- Display bottles per case -->
                      <form action="../php/add-to-cart.php" method="post" class="box">
                          <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>"> <!-- Add hidden input for product ID -->
                          <input type="hidden" name="product_name" value="<?php echo $fetch_products['productName']; ?>">
                          <input type="hidden" name="product_price" value="<?php echo $formatted_price_per_case; ?>"> <!-- Price per case -->
                          <input type="hidden" name="product_image" value="../<?php echo $fetch_products['image']; ?>">
                          <!-- Add quantity input field -->
                          <input type="number" min="1" name="product_quantity" value="1" class="qty">
                          <input type="submit" value="Add To Cart" name="add_to_cart" class="btn">
                      </form>
                  </div>
            <?php
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
          </div>
        </div>
      </section>
    </div>
  </div>
</body>
</html>
