<?php
session_start();
include "../php/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Record Management | Soft Drinks & Liquor Trader</title>
  <link rel="stylesheet" href="../css/navbar.css" />
  <link rel="stylesheet" href="../css/home-content.css" />
  

  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
</head>
<body style="background-image: url('../images/dashboard-bg.jpg'); background-size: cover;">
  <div class="container">
    <?php
      include "navbar.php";
    ?>
    <div class="content">
        <div class="banner-block">
        
            <div class="row-full-width-inner" data-element="inner">
                <h3>"ELEVATE EVERY MOMENT WITH THE PERFECT SIP!"</h3>
                <div class="block-description" data-content-type="text"
                      data-appearance="default" data-element="main">
                    <p>"Refresh your day with our fizzy delights! Discover the ultimate thirst-quenching experience with our range of delicious soft drinks"</p>
                </div>
            
            </div>
        </div>
    </div>
  </div>



</body>
</html>