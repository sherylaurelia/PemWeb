<?php
session_start();

//database connection
$dbhostname = 'mysql:host=localhost';
$dbusername = 'root';
$dbpassword = '';
$dbname = 'login';

$conn = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname);