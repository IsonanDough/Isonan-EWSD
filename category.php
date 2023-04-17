<?php
  include("UniFunc/connection.php");
  
  if(isset($_POST['addCat']))
  {
    $catName = $_POST['catName'];
    $cDate = $_POST['cDate'];

    $sql = "INSERT INTO category (catName, catCloseDate) VALUES ('$catName', '$cDate')";
    mysqli_query($conn, $sql);
  }

  function displayCategory($conn)
  {
    $sql = "SELECT * FROM category";
    $result = mysqli_query($conn, $sql);

    foreach($result as $row)
    {
      echo "<tr>";
      echo "<td>".$row['catName']."</td>";
      echo "<td>".$row['catCloseDate']."</td>";
      echo "<td><button class='btn btn-danger' name='btnDel' value='".$row['catID']."' >Delete</button></td>";
      echo "</tr>";
    }
  }

  if(isset($_POST['btnDel']))
  {
    $catID = $_POST['btnDel'];
    $sql = "DELETE FROM category WHERE catID = '$catID'";
    mysqli_query($conn, $sql);
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <?php include("UniFunc/link.php"); ?>
  </head>
  <body>
    <?php include('UniFunc/NavBar.php'); ?>
    <div class="mx-auto" style="width:50%;">
        <div class="col">
          <h1>Add Category</h1>
          <form method="post">
            <div class="col">
              <label for="catName">Category Name : </label>
              <input id="catName" name="catName">
            </div>
            <div class="col mt-2">
              <label for="cDate">Closure Date : </label>
              <input type="date" id="cDate" name="cDate">
            </div>
            <div class="col">
              <button class="btn btn-primary mt-2" name="addCat">Add Category</button>
            </div>
          </form>
          
        </div>

        <div class="col mt-5" style="border-top:1px solid;">
          <h1>Delete Category</h1>
          <div style="height:500px; overflow-y:auto;">
            <form method="post">
              <table class="table table-hover">
                <thead style="position: sticky; top:0; z-index:100; background-color:white;">
                  <tr>
                    <th>Category Name</th>
                    <th>Closure Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    displayCategory($conn);
                  ?>
                </tbody>
              </table>
            </form>
          </div>
          
        </div>
      
    </div>
  </body>
</html>