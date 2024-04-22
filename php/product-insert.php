<?php
session_start();
include "conn.php";
;

if(isset($_POST['add_product'])) {
    $productName = strtolower($_POST['product_name']); // Convert to lowercase
    $price = $_POST['product_price'];
    $quantity = $_POST['product_quantity']; // New input for product quantity
    $bottlesPerCase = $_POST['bottles_per_case']; // New input for bottles per case
    
    // File upload
    $target_dir = "../images/products/";
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES["product_image"]["size"] > 50000000000) {
        echo "Error: File is too large.";
        exit();
    }

    // Additional processing for image upload
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        // Insert product into database
        $insert_query = "INSERT INTO tblproduct (productName, price, quantity, bottles_per_case, image) VALUES ('$productName', $price, $quantity, $bottlesPerCase, '$target_file')";
        if ($conn->query($insert_query) === TRUE) {
            ?>
            <script>
                alert("New product added successfully");
                window.location.href = "../pages/products.php";
            </script>
            <?php
        } else {
            echo "Error: " . $insert_query . "<br>" . $conn->error;
        }
    } else {
        echo "Error: File upload failed.";
    }
}
?>
