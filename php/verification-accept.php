<?php
session_start();
include "../php/header.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/login.html");
    exit();
}

// Check if the user has admin privileges
if ($_SESSION['userType'] !== 'admin') {
    header("Location: ../pages/access-denied.html");
    exit();
}

// Check if the id parameter is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];

    // Update the verification status to 1 for the specified user
    $query = "UPDATE tbluser SET verification = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Redirect back to the client dashboard page
        header("Location: ../pages/admin-verification.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect back to the client dashboard page if id parameter is not provided
    header("Location: ../pages/admin-verification.php");
    exit();
}
?>
