<?php
    function displayName($conn,$uid)
    {
        $sql = "SELECT username FROM account WHERE uid = '$uid'";
        $result = mysqli_query($conn, $sql);
        $name = mysqli_fetch_all($result);
        echo $name[0][0];
    }

    function displayRole($role)
    {
        if($role == 0)
        {
            echo "Staff";
        }
        else if($role == 1)
        {
            echo "Manager";
        }
        else if($role == 2)
        {
            echo "Admin";
        }
    }
?>

<div class="row">
    <div class="col-2">Date : <?php echo $today;?></div>
    <div class="col-2">Name : <?php displayName($conn,$uid); ?> </div>
    <div class="col-2">Role : <?php displayRole($role); ?> </div>
</div>