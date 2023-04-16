<?php
    include("UniFunc/connection.php");

    $uid = $_SESSION['uid'];
    $role = $_SESSION['role'];
    $today = date("Y-m-d");

    if(isset($_POST['btnSubmit']))
    {
        $idea = $_POST['txtIdea'];
        $category = $_POST['txtCategory'];
        $date = $_POST['date'];
        $anonymous = 0;
        $docName = $_POST['DocumentName'];

        if(isset($_POST['Anonymous']))
        {
            $anonymous = $_POST['Anonymous'];
            if($anonymous == "on")
            {
                $anonymous = 1;
            }
            else
            {
                $anonymous = 0;
            }
        }

        if($date == "0000-00-00")
        {
            $date = null;
        }

        if($_FILES["Documents"]["error"] == 4)
        {
            //alertMsg("Please Select Image");
        }
        else
        {
            $fileName = $_FILES["Documents"]["name"];
            $fileSize = $_FILES["Documents"]["size"];
            $tmpName = $_FILES["Documents"]["tmp_name"];

            $validImageExtension = ['jpg', 'jpeg', 'png', 'doc', 'docx', 'pdf'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if ( !in_array($imageExtension, $validImageExtension) )
            {
                //alertMsg("Invalid Image Extension");
            }
            else if($fileSize > 1000000)
            {
                //alertMsg("Image Size Is Too Large");
            }
            else
            {
                $documents = $docName;
                $documents .= '.' . $imageExtension;
                move_uploaded_file($tmpName, 'Storage/' . $documents);
            }
        }

        $sql = "INSERT INTO idea (idea, category, user, anonymous,date,closure,file) VALUES ('$idea', '$category', '$uid', '$anonymous', '$today','$date','$documents')";
        $result = mysqli_query($conn, $sql);
    }

    function displayCat($conn)
    {
        $sql = "SELECT * FROM category";
        $result = mysqli_query($conn, $sql);

        foreach($result as $row)
        {
            echo "<option value='".$row['catID']."'>".$row['catName']."</option>";
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
    <div style="width:55vw; margin-left:auto; margin-right:auto;">
        <?php include('UniFunc/display.php'); ?>
        <h2>Idea Submission</h2>
        <div>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="txtCategory" class="form-label">Category</label>
                    <select class="form-select" id="txtCategory" name="txtCategory" required>
                        <option selected>Open this to select category</option>
                        <?php
                            displayCat($conn);
                        ?>
                    </select>
                </div>

                <div>
                    <label for="txtIdea" class="form-label">Idea</label>
                    <textarea class="form-control" id="txtIdea" name="txtIdea" rows="3" placeholder="Enter your idea here" required></textarea>
                </div>

                <div>
                    <label for="Documents" class="form-label">Documents (Only Accept <strong>JPG , JPEG , DOC , DOCX , PDF </strong>) and Less Than 10MB</label>
                    <input type="file" class="form-control" id="Documents" name="Documents" accept=".jpg, .jpeg, .png, .doc, .docx, .pdf">
                    <input class="form-control mt-2" name="DocumentName" placeholder="Document Name">
                </div>
            
                <div class="mt-2">
                    <label for="date" required>Comments Closure Date : </label>
                    <input type="date" name="date" id="date">
                </div>
                    
                <div>
                    <input type="checkbox" name="termNcon" required> Agree to the <a href="#">Terms and Conditions</a>
                </div>

                <div>
                    <input type="checkbox" name="Anonymous"> Anonymous
                </div>
            
                <button type="submit" class="mt-2 btn btn-primary row" name="btnSubmit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>