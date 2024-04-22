<?php
session_start();
include "conn.php";

if(isset($_POST['restock_quantity']) && isset($_POST['product_id'])) {
    $restockQuantity = $_POST['restock_quantity'];
    $productId = $_POST['product_id'];

    // Update product quantity in the database
    $update_query = "UPDATE tblproduct SET quantity = quantity + $restockQuantity WHERE id = $productId";
    
    if ($conn->query($update_query) === TRUE) {
        ?>
        <script>
            alert("Product restocked successfully");
            window.location.href = "../pages/products.php";
        </script>
        <?php
    } else {
        echo "Error: " . $update_query . "<br>" . $conn->error;
    }
}
?>
