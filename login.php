<?php
  include("UniFunc/connection.php");
  
  if(isset($_POST['btnLogin']))
  {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($email) && !empty($password))
    {
      $sql = "SELECT password FROM account WHERE email = '$email'";
      $result = mysqli_query($conn, $sql);

      if(mysqli_num_rows($result) > 0)
      {
        $hash = mysqli_fetch_array($result);
        $hash = $hash[0];

        if(password_verify($password, $hash))
        {
          $sql = "SELECT * FROM account WHERE email = '$email'";
          $result = mysqli_query($conn, $sql);
          $arr = mysqli_fetch_assoc($result);

          $Dits = array($arr['uid'],$arr['role']);
          $_SESSION['Dits'] = $Dits;

          header("Location: home.php");
          exit();
        }
        else
        {
          $triggerAlert = 1;
        }
      }
      else
      {
        $triggerAlert = 3;
      }
    }
    else
    {
      $triggerAlert = 2;
    }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <?php include("UniFunc/link.php"); ?>
  </head>
  <body>
    <?php include('UniFunc/NavBarMin.php'); ?>

    <div class="container mt-5">
      
      <div class="row justify-content-center">
      
        <div class="col-md-6 col-lg-4">
        
          <div class="card bg-light">
            <div class="card-body">
              <h5 class="card-title mb-3">Login</h5>
              <form method="post">
                <div class="form-floating mb-3">
                  <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                  <label for="email">Email address</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                  <label for="password">Password</label>
                </div>
                <button type="submit" class="btn btn-primary float-end" name="btnLogin">Login</button>
              </form>
            </div>
          </div>
          <br>
          <?php
            if(isset($triggerAlert))
            {
              if($triggerAlert == 1)
              {
                alertMsg("Username or Password is incorrect", "danger");
              }
              else if($triggerAlert == 2)
              {
                alertMsg("Please enter Email and Password", "danger");
              }
              else if($triggerAlert == 3)
              {
                alertMsg("Email is not registered", "danger");
              }
            }
          ?>
        </div>
      </div>
    </div> 

  </body>
</html>