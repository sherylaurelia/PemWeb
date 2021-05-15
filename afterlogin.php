<?php 
session_start();
if(!isset($_SESSION['session_username'])){
    header("location:login.php");
    exit();
}

echo "<pre>";
print_r($_SESSION);
print_r($_COOKIE);
echo "</pre>";

?>

<!doctype html>
<html>
<head></head>
<body><a href="logout.php">Logout</a></body>
</html>