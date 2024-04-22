<?php
session_start();
include "conn.php"; // Include the database connection

// Check if the form is submitted and if the payment method is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout_submit']) && isset($_POST['payment_method'])) {
    $user_id = $_SESSION['user_id']; // Get user ID from session
    $total_price = 0; // Initialize total price

    // Get the payment method from the form
    $payment_method = $_POST['payment_method'];

    // Get user's cart items
    $select_cart = mysqli_query($conn, "SELECT * FROM `tblcart` WHERE user_id = '$user_id'");

    // Check if cart is not empty
    if (mysqli_num_rows($select_cart) > 0) {
        // Start the transaction
        mysqli_begin_transaction($conn);

        // Create a new transaction
        $insert_transaction_query = "INSERT INTO `tbltransaction` (`user_id`, `transaction_date`, `total_amount`, `payment_method`, `transaction_status`) VALUES ('$user_id', NOW(), 0, '', 'Pending')";
        $result = mysqli_query($conn, $insert_transaction_query);

        // Check if transaction creation was successful
        if ($result) {
            // Get the transaction ID
            $transaction_id = mysqli_insert_id($conn);

            // Update product quantities and calculate total price
            while ($cart_row = mysqli_fetch_assoc($select_cart)) {
                $product_id = $cart_row['product_id'];
                $product_quantity = $cart_row['product_quantity'];

                // Get product details
                $product_query = mysqli_query($conn, "SELECT * FROM `tblproduct` WHERE `id` = '$product_id'");
                $product_row = mysqli_fetch_assoc($product_query);
                $product_price = $product_row['price'];

                // Calculate total price
                $total_price += $product_quantity * $product_price;

                // Add transaction item details
                $insert_transaction_item_query = "INSERT INTO `tbltransaction_items` (`transaction_id`, `product_id`, `product_name`, `product_price`, `quantity`, `total_price`) VALUES ('$transaction_id', '$product_id', '{$cart_row['product_name']}', '$product_price', '$product_quantity', '" . ($product_quantity * $product_price) . "')";
                mysqli_query($conn, $insert_transaction_item_query);
            }

            // Update total amount and payment method in transaction
            $update_transaction_query = "UPDATE `tbltransaction` SET `total_amount` = '$total_price', `payment_method` = '$payment_method', `transaction_status` = 'Pending' WHERE `id` = '$transaction_id'";
            $result = mysqli_query($conn, $update_transaction_query);

            // Check if transaction update was successful
            if ($result) {
                // Clear the user's cart
                $delete_cart_query = "DELETE FROM `tblcart` WHERE `user_id` = '$user_id'";
                mysqli_query($conn, $delete_cart_query);

                // Commit the transaction
                mysqli_commit($conn);

                // Redirect to client dashboard
                header("Location: ../pages/client-dashboard.php");
                exit();
            } else {
                // If updating transaction failed, rollback the transaction
                mysqli_rollback($conn);
                echo "<script>alert('Error: Unable to update transaction details');</script>";
                header("Location: ../pages/client-checkout.php");
                exit();
            }
        } else {
            // If creating transaction failed, rollback the transaction
            mysqli_rollback($conn);
            echo "<script>alert('Error: Unable to create transaction');</script>";
            header("Location: ../pages/client-checkout.php");
            exit();
        }
    } else {
        // If cart is empty, redirect back to the cart page
        header("Location: ../pages/client-cart.php");
        exit();
    }
} else {
    // If form is not submitted or payment method is not set, redirect back to the checkout page
    header("Location: ../pages/client-checkout.php");
    exit();
}
?>
