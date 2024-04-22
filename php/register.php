<?php
include "conn.php";

function generateRandomId($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    $maxIndex = strlen($characters) - 1;

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $maxIndex)];
    }

    return $randomString;
}

if(isset($_POST['register']) && $_POST['password'] === $_POST['confirm-password']) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password for security
    $fullname = $_POST['fname'] . ' ' . $_POST['mname'] . ' ' . $_POST['lname']; // Concatenate first name, middle initial, and last name
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $address = $_POST['blk'] . ', ' . $_POST['street'] . ', ' . $_POST['brgy']. ', Antipolo City, Rizal, 1870' ; // Concatenate block/lot, street, and barangay

    // Generate unique random ID
    $unique_id = generateRandomId();

    // Check if the email is already used in the database
    $check_query = "SELECT * FROM tbluser WHERE email = '$email'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        ?>
        <script>
            alert("Email is already used! Please use a different email.");
            window.location.href = "../pages/register.html";
        </script>
        <?php
    } else {
        // Proceed with registration if email is not already used
        $query = "INSERT INTO tbluser (id, username, password, email, fullname, gender, contact, userType, address, verification)
                    VALUES ('$unique_id', '$username', '$password', '$email', '$fullname', '$gender', '$contact', 'client', '$address', 0)";

        $result = $conn->query($query);

        if ($result) {
            ?>
            <script>
                alert("Registration successful! Please wait for account verification.");
                window.location.href = "../index.html";
            </script>
            <?php
        } else {
            ?>
            <script>
                alert("Error in registration. Please try again later!");
                window.location.href = "../pages/register.html";
            </script>
            <?php
        }
    }
} else {
    ?>
    <script>
        alert("Passwords do not match!");
        window.location.href = "../pages/register.html";
    </script>
    <?php
}
?>
