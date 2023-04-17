<?php
session_start();

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ewsd";

if(!$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
	die("failed to connect!");
}

function alertMsg($msg,$type)
{
  echo

  '<div class="alert alert-'.$type.' alert-dismissible show" role="alert">'.
    '<strong>'.$msg.'</strong>'.
    '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" id="btnAlertX"></button>'.
  '</div>'.
  '<script>
    setTimeout(function()
    {
      document.getElementById("btnAlertX").click();
    },3000);
  </script>';
}

$triggerAlert = 0;
?>