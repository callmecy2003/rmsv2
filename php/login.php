<?php
include "conn.php";

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email exists in the database
    $check_query = "SELECT * FROM tbluser WHERE email = '$email'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        // Fetch the user data
        $user_data = $check_result->fetch_assoc();

        // Verify if email is verified
        if ($user_data['verification'] == 1) {
            // Verify the password
if (password_verify($password, $user_data['password'])) {
    // Password is correct, proceed with login
    // You can set session variables or redirect the user to a dashboard page
    session_start();
    $_SESSION['user_id'] = $user_data['id']; // Store user ID in the session
    $_SESSION['username'] = $user_data['username'];
    $_SESSION['email'] = $user_data['email'];
    $_SESSION['userType'] = $user_data['userType'];
    echo "<script>sessionStorage.setItem('username', '" . $_SESSION['username'] . "');</script>";

    // Redirect to dashboard or any other page
    if ($_SESSION['userType'] == "admin") {
        ?>
        <script>
            alert("Login Successfully, Welcome Admin: " + sessionStorage.getItem('username'));
            window.location.href = "../pages/dashboard.php";
        </script>
        <?php
    } else if ($_SESSION['userType'] == "employee") {
        ?>
        <script>
            alert("Login Successfully, Welcome Employee: " + sessionStorage.getItem('username'));
            window.location.href = "../pages/dashboard.php";
        </script>
        <?php
    } else if ($_SESSION['userType'] == "client") {
        ?>
        <script>
            alert("Login Successfully, Welcome User: " + sessionStorage.getItem('username'));
            window.location.href = "../pages/client-dashboard.php";
        </script>
        <?php
    }

    exit();
}

            } else {
                // Password is incorrect
                ?>
                <script>
                    alert("Incorrect password! Please try again.");
                    window.location.href = "../pages/login.html";
                </script>
                <?php
            }
        } else {
            // Email is not verified
            ?>
            <script>
                alert("Email is not verified! Please verify your email before logging in.");
                window.location.href = "../pages/login.html";
            </script>
            <?php
        }
    } else {
        // Email not found in the database
        ?>
        <script>
            alert("Email not found! Please register.");
            window.location.href = "../pages/register.html";
        </script>
        <?php
    }

?>
