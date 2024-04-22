<?php
include "conn.php";

// Function to delete a certain quantity of an item from the cart
function deleteCartQuantity($cart_id, $delete_quantity, $conn) {
    // Retrieve product quantity and ID from cart
    $select_cart_query = "SELECT product_id, product_quantity FROM `tblcart` WHERE id = ?";
    $stmt_select_cart = $conn->prepare($select_cart_query);
    $stmt_select_cart->bind_param("i", $cart_id);
    $stmt_select_cart->execute();
    $cart_result = $stmt_select_cart->get_result();
    $cart_row = $cart_result->fetch_assoc();
    $product_id = $cart_row['product_id'];
    $current_quantity = $cart_row['product_quantity'];
    
    // Get bottles per case
    $bottles_per_case_query = "SELECT bottles_per_case FROM tblproduct WHERE id = ?";
    $stmt_bottles = $conn->prepare($bottles_per_case_query);
    $stmt_bottles->bind_param("i", $product_id);
    $stmt_bottles->execute();
    $bottles_result = $stmt_bottles->get_result();
    $bottles_row = $bottles_result->fetch_assoc();
    $bottles_per_case = $bottles_row['bottles_per_case'];

    // Calculate the quantity to update in tblcart
    $new_quantity = $current_quantity - $delete_quantity;
    if ($new_quantity < 0) {
        $new_quantity = 0; // Ensure quantity doesn't go negative
    }

    // Update the quantity in tblcart
    $update_cart_query = "UPDATE `tblcart` SET `product_quantity` = ? WHERE `id` = ?";
    $stmt_update_cart = $conn->prepare($update_cart_query);
    $stmt_update_cart->bind_param("ii", $new_quantity, $cart_id);
    $stmt_update_cart->execute();

    // Calculate the quantity to add back to tblproduct
    $deleted_quantity = $delete_quantity * $bottles_per_case;

    // Add the quantity back to tblproduct
    $update_product_query = "UPDATE `tblproduct` SET `quantity` = `quantity` + ? WHERE `id` = ?";
    $stmt_update_product = $conn->prepare($update_product_query);
    $stmt_update_product->bind_param("ii", $deleted_quantity, $product_id);
    $stmt_update_product->execute();
}

// Check if the delete_cart form is submitted
if(isset($_POST['delete_cart']) && isset($_POST['cart_id']) && isset($_POST['delete_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $delete_quantity = $_POST['delete_quantity'];
    deleteCartQuantity($cart_id, $delete_quantity, $conn);
    header("Location: ../pages/client-cart.php"); // Redirect back to the cart page after deletion
    exit();
} else {
    header("Location: ../pages/client-cart.php"); // Redirect back to the cart page if delete action is not provided
    exit();
}
?>
