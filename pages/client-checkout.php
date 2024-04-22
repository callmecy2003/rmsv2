<?php
session_start();
include "../php/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Checkout | Soft Drinks & Liquor Trader</title>
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
    <section class="shopping-cart">
        <h1 class="title">Checkout</h1>

        <table class="content-table" id="dataTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Cases</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if user is logged in
                    $user_id = $_SESSION['user_id'];

                    $grand_total = 0;
                    $total_cases = 0;
                    $cart_items = array();

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
                            echo "<tr>";
                            echo "<td>" . $cart_item['product_name'] . "</td>";
                            echo "<td>₱" . $cart_item['product_price'] . "</td>";
                            echo "<td>" . $cart_item['product_quantity'] . "</td>";
                            // Calculate total for the item
                            $item_total = $cart_item['product_quantity'] * $cart_item['product_price'];
                            echo "<td>₱" . $item_total . "</td>";
                            echo "</tr>";
                            
                            // Update totals
                            $grand_total += $item_total;
                            $total_cases += $cart_item['product_quantity'];
                        }
                        ?>
                        <tr>
                            <th colspan="3" style='text-align:right;'>Total</th>
                            <td>₱<?php echo $grand_total?></td>
                        </tr>
                        <?php
                    } else {
                        echo '<tr><td colspan="4" class="empty">Your cart is empty</td></tr>';
                    }
                ?>
            </tbody>
        </table>

        <form action="../php/checkout-process.php" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="total_amount" value="<?php echo $grand_total; ?>">
            <div>
                <label for="payment_method">Choose a payment method:</label>
                <select name="payment_method" id="payment_method">
                    <option value='cash_on_delivery'>Cash on Delivery</option>
                    <option value="gcash">Gcash</option>
                    <option value="paymaya">Paymaya</option>
                </select>
            </div>
            <button type="submit" name="checkout_submit" class="option-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Complete Checkout</button>
        </form>

        <a href="client-cart.php" class="option-btn">Back to Cart</a>
    </section>
    </div>
  </div>
</body>
</html>
