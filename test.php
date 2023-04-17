<?php
/*
    include("UniFunc/connection.php");
    $userID = 3;

    $nameSql = "SELECT * FROM account WHERE uid = '$userID'";
    $resultName = mysqli_query($conn, $nameSql);
    $name = mysqli_fetch_assoc($resultName);
    $user = $name['username'];

    echo $user;
    
    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "ewsd";
    if(!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
    {
        die("failed to connect!");
    }

    $email = "123@123";
    $username = "123";
    $password = "123";
    $role = "0";
    $hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO account (email, username, password,role) VALUES ('$email', '$username', '$hash', '$role')";
    $result = mysqli_query($conn, $sql);
    
    $to = $email;
    $subject = "OTP Verification Code";
    $sender = "From:kenny360noscope@gmail.com";
    $otp = rand(100000,999999);
    if( mail($to, $subject, $otp, $sender) )
    {

    }
    
    include("UniFunc/connection.php");

    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $today = date("Y-m-d");

    function displayIdea($conn)
    {
        // Set the number of results to show per page
        $results_per_page = 5;
      
        // Get the total number of ideas
        $sql_count = "SELECT COUNT(*) AS count FROM idea";
        $result_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_assoc($result_count);
        $total_results = $row_count['count'];
      
        // Get the current page number
        if (isset($_GET['page'])) {
          $current_page = $_GET['page'];
        } else {
          $current_page = 1;
        }
      
        // Calculate the offset of the first result on the current page
        $offset = ($current_page - 1) * $results_per_page;
      
        // Get the results for the current page
        $sql = "SELECT * FROM idea LIMIT $offset, $results_per_page";
        $result = mysqli_query($conn, $sql);
        $i = 0;
      
        foreach ($result as $row) {
            $output = '';
            $i = $i + 1;
            $ideaID = $row['ideaID'];
            $idea = $row['idea'];
            $cat = $row['category'];
            $user = $row['user'];
            $anonymous = $row['anonymous'];
            $date = $row['date'];
            //$closure = $row['closure'];
            $thumbsUp = $row['thumbsUp'];
            $thumbsDown = $row['thumbsDown'];
        
            if($anonymous == 1)
            {
                $user = "Anonymous";
            }
            else
            {
                $nameSql = "SELECT username FROM account WHERE uid = '$user'";
                $resultName = mysqli_query($conn, $nameSql);
                $name = mysqli_fetch_all($resultName);
                $user = $name[0][0];
            }
        
            $catSql = "SELECT catName FROM category WHERE catID = '$cat'";
            $resultCat = mysqli_query($conn, $catSql);
            $catName = mysqli_fetch_all($resultCat);
            $cat = $catName[0][0];
        
            $output .=
            '<td>'.$i.'</td>'.
            '<td>'.$cat.'</td>'.
            '<td>'.$idea.'</td>'.
            '<td>'.$date.'</td>'.
            '<td>'.$user.'</td>'.
            '<td> <i class="bi bi-hand-thumbs-up-fill"></i> '.$thumbsUp.'</td>'.
            '<td> <i class="bi bi-hand-thumbs-down-fill"></i> '.$thumbsDown.'</td>'.
            '<td>'.
                '<button class="btn btn-sm btn-info" name="ViewIdea" value="'.$ideaID.'">View</button>'.
            '</td>';
        
            echo "<tr>".$output."</tr>";
        }
      
        // Display pagination links
        $total_pages = ceil($total_results / $results_per_page);
        echo '<nav aria-label="Page navigation">';
        echo '<ul class="pagination justify-content-center">';
        for ($i = 1; $i <= $total_pages; $i++) {
          if ($i == $current_page) {
            echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
          } else {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
          }
        }
        echo '</ul>';
        echo '</nav>';
      }
      */
?>

<!doctype html>
<html lang="en">
<head>
    <?php include("UniFunc/link.php"); ?>
</head>
<body>
    <?php include('UniFunc/NavBar.php'); ?>
    <div class="container">

        <?php include('UniFunc/display.php'); ?>

        <h1>Home</h1>

        <div class="row-3">
            <form method="post">
            <button class="btn btn-primary" name="btnMostUp">View Most <i class="bi bi-hand-thumbs-up-fill"></i></button>
            <button class="btn btn-primary" name="btnMostDw">View Most <i class="bi bi-hand-thumbs-down-fill"></i></button>
            </form>
        </div>

        <div>
            <form method="post">
                <table class="table table-striped">
                    <thead style="position:sticky; top:0; background-color:white; z-index:10;">
                    <tr>
                        <th style="width:50px;">No.</th>
                        <th style="width:120px;">Category</th>
                        <th style="width:500px;">Idea</th>
                        <th style="width:150px;">Submit Date</th>
                        <th style="width:150px;">Submit By</th>
                        <th style="width:60px;"><i class="bi bi-hand-thumbs-up-fill"></i></th>
                        <th style="width:60px;"><i class="bi bi-hand-thumbs-down-fill"></i></th>
                        <th style="width:150px;">Action</th>
                    </tr>
                    </thead>
                    <tbody class="table-hover" style="z-index:1;">
                    <?php
                        displayIdea($conn);
                    ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</body>
</html>