<?php
    include("UniFunc/connection.php");

    $ideaID = $_SESSION['ideaID'];

    $sql = "SELECT * FROM idea WHERE ideaID = '$ideaID'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_all($result);

    $idea = $row[0][1];
    $cat = $row[0][2];
    $user = $row[0][3];
    $anonymous = $row[0][4];
    $date = $row[0][5];
    $closure = $row[0][6];
    $thumbsUp = $row[0][7];
    $thumbsDown = $row[0][8];

    if(isset($_POST['tUp']))
    {
        $thumbsUp += 1;
        $sql = "UPDATE idea SET thumbsUp = '$thumbsUp' WHERE ideaID = '$ideaID'";
        $result = mysqli_query($conn, $sql);
    }

    if(isset($_POST['tDw']))
    {
        $thumbsDown += 1;
        $sql = "UPDATE idea SET thumbsDown = '$thumbsDown' WHERE ideaID = '$ideaID'";
        $result = mysqli_query($conn, $sql);
    }

    if(isset($_POST['btnSubmit']))
    {
        $comment = $_POST['comment'];
        $anonymousComment = 0;

        $dit = $_SESSION['Dits'];
        $uid = $dit[0];
        $today = date("Y-m-d");

        if(isset($_POST['Anonymous']))
        {
            if($_POST['Anonymous'] == "on")
            {
                $anonymousComment = 1;
            }
            else
            {
                $anonymousComment = 0;
            }

            $commentSql = "INSERT INTO comment (uid,ideaID, comment, commentDate, anonymous) VALUES ('$uid','$ideaID','$comment','$today','$anonymousComment')";
            mysqli_query($conn, $commentSql);
        }
        else
        {
            $commentSql = "INSERT INTO comment (uid,ideaID, comment, commentDate, anonymous) VALUES ('$uid','$ideaID','$comment','$today','$anonymousComment')";
            mysqli_query($conn, $commentSql);
        }
    }

    function getComment($conn, $ideaID)
    {
        $commentSql = "SELECT * FROM comment WHERE ideaID = '$ideaID'";
        $commentResult = mysqli_query($conn, $commentSql);

        foreach($commentResult as $row)
        {
            $uid = $row['uid'];
            $comment = $row['comment'];
            $anonymous = $row['anonymous'];

            if($anonymous == 1)
            {
                $name = "Anonymous";
            }
            else
            {
                $nameSql = "SELECT * FROM account WHERE uid = '$uid'";
                $nameResult = mysqli_query($conn, $nameSql);
                $nameRow = mysqli_fetch_assoc($nameResult);
                $name = $nameRow['username'];
            }

            echo '<div class="row mt-2 pt-1" style="border-top: 1px solid;">';
            echo '<h5 class="row">Comment By : '.$name.'</h5>';
            echo '<div class="col-10">';
            echo '<p style="height:100px; width:500px; text-align:justify;">';
            echo $comment;
            echo '</p>';
            echo '</div>';
            echo '</div>';

        }
    }

    if(isset($_GET['ideaID']))
    {
        $ideaID = $_GET['ideaID'];
        $sql = "SELECT file FROM idea WHERE ideaID=$ideaID";
        $result = mysqli_query($conn, $sql);

        $file = mysqli_fetch_assoc($result);
        $filepath = 'Storage/'.$file['file'];

        if(file_exists($filepath))
        {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize('Storage/' . $file['name']));
            readfile('Storage/' . $file['name']);

            exit;
        }
    }

    function fileDisable($conn,$ideaID)
    {
        $sql = "SELECT * FROM idea WHERE ideaID=$ideaID";
        $result = mysqli_query($conn, $sql);
        $file = mysqli_fetch_assoc($result);
        $fileYES = $file['file'];

        if($fileYES == null)
        {
            echo "hidden";
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <?php include("UniFunc/link.php"); ?>
</head>
<body>
    <?php include('UniFunc/NavBar.php'); ?>
    <div class="mx-auto" style="width: 65%;">
        <form method="post" enctype="multipart/form-data">
            <div style="border: 1px solid; border-radius:10px; padding:20px;">
                <div class="row">
                    <h4 class="col-3">Idea </h4>
                    <p class="col">
                        : <?php echo $idea ?>
                    </p>
                </div>
                
                <div class="row">
                    <h4 class="col-3">Category </h4>
                    <p class="col">
                    : <?php echo $cat ?>
                    </p>
                </div>

                <div class="row">
                    <h4 class="col-3">Submited Date </h4>
                    <p class="col">
                    : <?php echo $date ?>
                    </p>
                </div>

                <div class="row">
                    <h4 class="col-3">Submited By </h4>
                    <p class="col">
                    : <?php
                            if($anonymous == 1)
                            {
                                echo "Anonymous";
                            }
                            else
                            {
                                $nameSql = "SELECT username FROM account WHERE uid = '$user'";
                                $resultName = mysqli_query($conn, $nameSql);
                                $name = mysqli_fetch_all($resultName);
                                echo $name[0][0];
                            }
                        ?>
                    </p>
                </div>

                <div class="row">
                    <h4 class="col-3">Closure Date </h4>
                    <p class="col">
                        : <?php echo $closure ?>
                    </p>
                </div>

                <div class="row">
                    <!-- To display file uploaded -->
                    <h4 class="col-3">Documents</h4>
                    <p class="col">
                        : <a href="viewIdea.php?ideaID=<?php echo $ideaID ?>" class="btn btn-primary"<?php fileDisable($conn,$ideaID); ?>>Download</a>
                    </p>
                </div>

                <div class="row">
                    <button class="col-1 ms-2 btn btn-primary" name="tUp"><i class="bi bi-hand-thumbs-up-fill"></i> <?php echo $thumbsUp; ?></button> 
                    <button class="col-1 ms-2 btn btn-danger" name="tDw"><i class="bi bi-hand-thumbs-down-fill"></i> <?php echo $thumbsDown; ?></button>
                </div>
                
            </div>
        </form>
        <form method="post">
            <div class="row mt-1" <?php if($today <= $closure){ echo ""; }else{ echo "hidden"; } ?>>
                <!-- User input comment -->
                <h4 class="row">Comment : </h4>
                <div class="col-10">
                    <textarea type="text" class="form-control" style="height:100px; width:500px;" name="comment" placeholder="Comment"></textarea>
                    <input type="checkbox" name="Anonymous"> Anonymous</a>
                    <button class="mt-1 btn btn-sm btn-primary" name="btnSubmit">Submit</button>
                </div>
            </div>
        </form>

        <div class="row">
            <!-- display comments -->
            <?php getComment($conn, $ideaID); ?>
        </div>
        
        
    </div>
</body>
</html>