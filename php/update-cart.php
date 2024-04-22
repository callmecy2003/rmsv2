<?php
session_start();
include "../php/header.php";

if(isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $new_quantity = $_POST['new_quantity'];

    // Get the product details from the cart
    $select_cart_query = "SELECT product_id, product_quantity FROM tblcart WHERE id = ?";
    $stmt_select_cart = $conn->prepare($select_cart_query);
    $stmt_select_cart->bind_param("i", $cart_id);
    $stmt_select_cart->execute();
    $cart_result = $stmt_select_cart->get_result();
    $cart_row = $cart_result->fetch_assoc();
    $product_id = $cart_row['product_id'];
    $old_quantity = $cart_row['product_quantity'];

    // Get the available quantity of the product
    $product_query = "SELECT quantity, bottles_per_case FROM tblproduct WHERE id = ?";
    $stmt_product = $conn->prepare($product_query);
    $stmt_product->bind_param("i", $product_id);
    $stmt_product->execute();
    $product_result = $stmt_product->get_result();
    $product_row = $product_result->fetch_assoc();
    $available_quantity = $product_row['quantity'];
    $bottles_per_case = $product_row['bottles_per_case'];

    // Calculate the maximum available cases
    $max_available_cases = floor($available_quantity / $bottles_per_case);

    // Calculate the total cases including the new quantity
    $total_cases = $old_quantity + $new_quantity;


    // Update cart
    $update_cart_query = "UPDATE tblcart SET product_quantity = product_quantity + ? WHERE id = ?";
    $stmt_update_cart = $conn->prepare($update_cart_query);
    $stmt_update_cart->bind_param("ii", $new_quantity, $cart_id);
    $stmt_update_cart->execute();

    // Update tblproduct
    $updated_quantity = $new_quantity * $bottles_per_case;
    $update_product_query = "UPDATE tblproduct SET quantity = quantity - ? WHERE id = ?";
    $stmt_update_product = $conn->prepare($update_product_query);
    $stmt_update_product->bind_param("ii", $updated_quantity, $product_id);
    $stmt_update_product->execute();

    echo "<script>window.location.href='../pages/client-cart.php';</script>";
} else {
    echo "<script>window.location.href='../pages/client-cart.php';</script>";
}
?>
