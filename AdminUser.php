<?php
    include("UniFunc/connection.php");

    function displayUser($conn)
    {
        $sql = "SELECT * FROM account";
        $result = mysqli_query($conn, $sql);
        
        foreach($result as $row)
        {
            $output = '';

            $uid = $row['uid'];
            $email = $row['email'];
            $username = $row['username'];
            $roleVal = $row['role'];

            if($roleVal == 2)
            {
                $roleName = "Admin";
            }
            else if($roleVal == 1)
            {
                $roleName = "Manager";
            }
            else if($roleVal == 0)
            {
                $roleName = "Staff";
            }

            $output .=
            "<td>".$uid."</td>".
            "<td>".$email."</td>".
            "<td>".$username."</td>".
            "<td>".$roleName."</td>".
            "<td>".
            '
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal'.$uid.'">
                <i class="bi bi-gear-fill"></i>
            </button>
            <div class="modal" id="exampleModal'.$uid.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">User Details</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email'.$uid.'" placeholder="Email" value="'.$email.'">
                                    <label for="email">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="username" name="username'.$uid.'" placeholder="username" value="'.$username.'">
                                    <label for="username">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password'.$uid.'">
                                    <label for="password">Password</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" name="btnDel" value="'.$uid.'">DELETE</button>
                                <button class="btn btn-primary" name="btnUpdate" value="'.$uid.'">UPDATE</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            '.   

            "</td>"
            ;

            echo "<tr>".$output."</tr>";
        }
    }

    if(isset($_POST['btnDel']))
    {
        $delUID = $_POST['btnDel'];
        $delSql = "DELETE FROM account WHERE uid = '$delUID'";
        $delResult = mysqli_query($conn, $delSql);

        if($delResult)
        {
            $triggerAlert = 3;
        }
        else
        {
            $triggerAlert = 4;
        }
    }

    if(isset($_POST['btnUpdate']))
    {
        $updateUID = $_POST['btnUpdate'];

        $email = $_POST['email'.$updateUID];
        $username = $_POST['username'.$updateUID];
        $password = $_POST['password'.$updateUID];
        //$role = $_POST['Role'.$updateUID];

        if(empty($password))
        {
            $updateSql = "UPDATE account SET email = '$email', username = '$username' WHERE uid = '$updateUID'";
            $updateResult = mysqli_query($conn, $updateSql);
        }
        else
        {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            
            $updateSql = "UPDATE account SET email = '$email', username = '$username', password = '$hash' WHERE uid = '$updateUID'";
            $updateResult = mysqli_query($conn, $updateSql);
        }

        if($updateResult)
        {
            $triggerAlert = 1;
        }
        else
        {
            $triggerAlert = 2;
        }
    }

    if(isset($_POST['btnAddUser']))
    {
        $email = $_POST['email'];
        $username = $_POST['Username'];
        $password = $_POST['Password'];
        $roleVal = $_POST['Role'];

        $hash = password_hash($password, PASSWORD_BCRYPT);

        $addSql = "INSERT INTO account (email, username, password, role) VALUES ('$email', '$username', '$hash', '$roleVal')";
        $addResult = mysqli_query($conn, $addSql);

        if($addResult)
        {
            $triggerAlert = 5;
        }
        else
        {
            $triggerAlert = 6;
        }
    }
?>

<!doctype html>
<html lang="en">
    <head>
        <?php include("UniFunc/link.php"); ?>
        <style>
            .modal-backdrop
            {
                display: none;
            }
        </style>
    </head>
    <body>
        <?php include('UniFunc/NavBar.php'); ?>
        <div class="mt-1 mx-auto" style="width: 60vw;">
        <div class="mt-1">
  
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
                Add User
            </button>
            <?php
                if(isset($triggerAlert))
                {
                    if($triggerAlert == 1)
                    {
                        alertMsg("User Updated!","success");
                    }
                    else if($triggerAlert == 2)
                    {
                        alertMsg("User Update Failed!","danger");
                    }
                    else if($triggerAlert == 3)
                    {
                        alertMsg("User Deleted!","success");
                    }
                    else if($triggerAlert == 4)
                    {
                        alertMsg("User Deletion Failed!","danger");
                    }
                    else if($triggerAlert == 5)
                    {
                        alertMsg("User Added","success");
                    }
                    else if($triggerAlert == 6)
                    {
                        alertMsg("User Addition Failed","danger");
                    }
                }
            ?>

            <div class="modal" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addUserLabel">New User</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" placeholder="Email" name="email" required>
                                    <label for="email">Email address</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="Username" placeholder="Username" name="Username" required>
                                    <label for="Username">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="Password" placeholder="Password" name="Password" required>
                                    <label for="Password">Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="Role" required>
                                        <option selected disabled>Please Select a Role</option>
                                        <option value="0">Staff</option>
                                        <option value="1">Manager</option>
                                        <option value="2">Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" name="btnAddUser">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div style="height:70vh; overflow-y: auto;">
            <form method="post">
                <table class="table table-striped" style="top:0; position:sticky; background-color:white;">
                    <thead>
                        <tr>
                            <td>UID</td>
                            <td>Email</td>
                            <td>Username</td>
                            <td>Role</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            displayUser($conn);
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
        
        </div>
    </body>
</html>