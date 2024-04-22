<?php
session_start();
include "conn.php";

// Check if the form is submitted
if(isset($_POST['add_to_cart'])) {
    // Retrieve product details from the form
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_quantity = $_POST['product_quantity'];
    $product_id = $_POST['product_id']; // Added: Retrieve product ID from the form

    // Check if the product quantity is greater than zero
    if($product_quantity > 0) {
        // Fetch the available cases and bottles per case of the product from the database using its ID
        $select_product_query = "SELECT quantity, bottles_per_case FROM tblproduct WHERE id = ?";
        $stmt_select_product = $conn->prepare($select_product_query);
        $stmt_select_product->bind_param("i", $product_id); // Assuming ID is an integer
        $stmt_select_product->execute();
        $result = $stmt_select_product->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $available_cases = floor($row['quantity'] / $row['bottles_per_case']);

            // Check if the desired cases exceed the available cases
            if ($product_quantity > $available_cases) {
                // Display JavaScript alert if the quantity is unavailable
                echo "<script>alert('Sorry, only $available_cases cases available for this product');</script>";
                echo "<script>window.location.href = '../pages/client-shop.php';</script>";
                // Exit the script to prevent further execution
                exit;
            } else {
                // Calculate total cost
                $total_cost = $product_price * $product_quantity;

                // Retrieve the user ID from the session
                if(isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id']; // Retrieve the user ID from the session
                } else {
                    // Handle if the user is not logged in
                    echo "<script>alert('Please log in to add products to your cart');</script>";
                    echo "<script>window.location.href = '../pages/login.php';</script>";
                    exit;
                }

                // Check if the product already exists in the cart
                $check_existing_query = "SELECT id, product_quantity FROM tblcart WHERE user_id = ? AND product_id = ?";
                $stmt_check_existing = $conn->prepare($check_existing_query);
                $stmt_check_existing->bind_param("ii", $user_id, $product_id);
                $stmt_check_existing->execute();
                $result_existing = $stmt_check_existing->get_result();

                if ($result_existing->num_rows == 1) {
                    // If the product exists, update the quantity
                    $existing_row = $result_existing->fetch_assoc();
                    $new_quantity = $existing_row['product_quantity'] + $product_quantity;

                    $update_cart_query = "UPDATE tblcart SET product_quantity = ?, total_cost = ? WHERE id = ?";
                    $stmt_update_cart = $conn->prepare($update_cart_query);
                    $stmt_update_cart->bind_param("idi", $new_quantity, $total_cost, $existing_row['id']);
                    if (!$stmt_update_cart->execute()) {
                        echo "<script>alert('Error: Unable to update product in cart');</script>";
                        exit;
                    }

                    // Update the product quantity in the tblproduct table
                    $update_quantity_query = "UPDATE tblproduct SET quantity = quantity - ? WHERE id = ?";
                    $stmt_update_quantity = $conn->prepare($update_quantity_query);
                    $updated_quantity = $product_quantity * $row['bottles_per_case'];
                    $stmt_update_quantity->bind_param("ii", $updated_quantity, $product_id);
                    if (!$stmt_update_quantity->execute()) {
                        echo "<script>alert('Error: Unable to update product quantity');</script>";
                        exit;
                    }

                    // Redirect back to the shop page
                    echo "<script>window.location.href = '../pages/client-shop.php';</script>";
                    exit;
                } else {
                    // If the product does not exist, insert a new row
                    $insert_cart_query = "INSERT INTO tblcart (user_id, product_id, product_price, product_quantity, total_cost, bottles_per_case) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt_insert_cart = $conn->prepare($insert_cart_query);
                    $stmt_insert_cart->bind_param("ssidid", $user_id, $product_id, $product_price, $product_quantity, $total_cost, $row['bottles_per_case']);
                    
                    if (!$stmt_insert_cart->execute()) {
                        echo "<script>alert('Error: Unable to add product to cart');</script>";
                        exit;
                    }

                    // Update the product quantity in the tblproduct table
                    $update_quantity_query = "UPDATE tblproduct SET quantity = quantity - ? WHERE id = ?";
                    $stmt_update_quantity = $conn->prepare($update_quantity_query);
                    $updated_quantity = $product_quantity * $row['bottles_per_case'];
                    $stmt_update_quantity->bind_param("ii", $updated_quantity, $product_id);
                    if (!$stmt_update_quantity->execute()) {
                        echo "<script>alert('Error: Unable to update product quantity');</script>";
                        exit;
                    }

                    // Redirect back to the shop page
                    echo "<script>window.location.href = '../pages/client-shop.php';</script>";
                    exit;
                }

                // Close prepared statements
                $stmt_check_existing->close();
                $stmt_update_cart->close();
                $stmt_insert_cart->close();
                $stmt_update_quantity->close();
            }

        } else {
            // Debugging: Output the error and the product ID for inspection
            echo "<script>alert('Error: Product not found for product ID: $product_id');</script>";
            echo "<script>window.location.href = '../pages/client-shop.php';</script>";
            exit;
        }

        // Close prepared statement
        $stmt_select_product->close();
    } else {
        // Display JavaScript alert if the quantity is invalid (less than or equal to zero)
        echo "<script>alert('Please enter a valid quantity');</script>";
        echo "<script>window.location.href = '../pages/client-shop.php';</script>";
        exit;
    }
} else {
    // Redirect to home page if accessed directly without form submission
    header("Location: ../pages/client-shop.php");
    exit;
}
?>
