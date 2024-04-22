<?php
// Check if the user is not logged in
if (!isset($_SESSION["email"])) {
    echo '<script>alert("Not logged in. Redirecting to login page.");';
    echo 'window.location.replace("../index.html");</script>';
    exit();
}
?>

<script>
    window.addEventListener('popstate', function(event) {
        window.history.pushState(null, document.title, location.href);
    });
</script>
