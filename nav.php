<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <!-- Brand -->
    <a class="navbar-brand" href="#">BIGSHOT Ent</a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <?php if ( isset($_SESSION["names"])) : ?>

            <li class="nav-item">
                <a class="nav-link" href="add-product.php">Add Movie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="register-customer.php">Add Customer</a>
            </li>
                <li class="nav-item">
                    <a class="nav-link" href="sell.php">Cart</a>
                </li>
            <?php if ($_SESSION["admin"] == 1) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php">Report</a>
                </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register-user.php">Add User</a>
                    </li>
<?php endif; ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        <?= $_SESSION["names"] ?>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="logout.php">Logout</a>
                        <!--                        <a class="dropdown-item" href="#">Profile</a>-->
                        <!--                        <a class="dropdown-item" href="#">Change Password</a>-->
                    </div>
                </li>





            <?php endif; ?>
        </ul>
    </div>
</nav>