<nav>
      <ul>
      <li>
          <a href="#" class="logo">
            <img src="../images/logo.png" alt="Company Logo">
            <span class="nav-item">Buddy and Lilia <br>Record Management System</span>
          </a>
        </li>
        <li><a href="dashboard.php">
          <i class="fas fa-home"></i>
          <span class="nav-item">Home</span>
        </a></li>
        <?php 
          if($_SESSION['userType'] == "admin"){
        ?>
        <li><a href="admin-verification.php">
          <i class="fas fa-bell"></i>
          <span class="nav-item">Verifications</span>
        </a></li>
        <?php 
          }
        ?>
        <li><a href="products.php">
          <i class="fas fa-glass-cheers"></i>
          <span class="nav-item">Products</span>
        </a></li>
        <li><a href="admin-transaction.php">
          <i class="fas fa-scroll"></i>
          <span class="nav-item">Transactions</span>
        </a></li>
        <?php 
          if($_SESSION['userType'] == "employee"){
        ?>
        <li><a href="#">
          <i class="fas fa-id-card"></i>
          <span class="nav-item">Clients</span>
        </a></li>
        <?php 
          }
        ?>
        <?php 
          if($_SESSION['userType'] == "admin"){
        ?>
        <li><a href="users-table.php">
          <i class="fas fa-address-book"></i>
          <span class="nav-item">User</span>
        </a></li>
        <?php 
          }
        ?>
        <li><a href="admin-contact.php">
          <i class="fas fa-comment"></i>
          <span class="nav-item">Messages</span>
        </a></li>
        <?php 
          if($_SESSION['userType'] == "admin"){
        ?>
        <li class="has-submenu">
          <a href="#">
          <i class="fas fa-archive"></i>
          <span class="nav-item">Archives</span>
          </a>
          <ul class="submenu">
            <!-- Add your sub-menu items here -->
            <li class="sub-submenu"><a href="archive-admin-transaction.php">Transactions</a></li>
            <li class="sub-submenu"> <a href="#">Messages</a></li>
          </ul>
        </li>
        <?php 
          }
        ?>
        <?php 
          if($_SESSION['userType'] == "admin"){
        ?>
        <li><a href="clients.php">
          <i class="fas fa-comment-dots"></i>
          <span class="nav-item">Logs</span>
        </a></li>
        <?php 
          }
        ?>
        <?php 
          if($_SESSION['userType'] == "employee"){
        ?>
        <li><a href="">
            <i class="fas fa-cog"></i>
            <span class="nav-item">Account</span>
        </a></li>
        <?php 
          }
        ?>
        <li><a href="../php/logout.php" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a></li>
      </ul>
    </nav>