<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="home.php"><h3>iDeate</h3></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item" style="text-align: center;">
                    <a class="nav-link" href="AdminUser.php" <?php if($_SESSION['role'] != 2){echo "hidden";}?>>User Management</a>
                </li>
                <li class="nav-item" style="text-align: center;">
                    <a class="nav-link" href="home.php">View Idea</a>
                </li>
                <li class="nav-item" style="text-align: center;">
                    <a class="nav-link" href="submitIdea.php">Submit Idea</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category.php" <?php if($_SESSION['role'] <= 1 ){echo "hidden";}?>>Category</a>
                </li>
                <li class="nav-item">
                    <form method="post">
                        <button name="btnLogOut" class="btn btn-sm btn-danger" style="margin-top:5px;">Logout</button>
                        <?php
                            if(isset($_POST['btnLogOut']))
                            {
                                session_destroy();
                                header("Location: login.php");
                                exit();
                            }
                        ?>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>