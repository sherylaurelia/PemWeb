<?php
session_start();

//database connection
$dbhostname = 'localhost';
$dbusername = 'root';
$dbpassword = '';
$dbname = 'login';

$conn = mysqli_connect($dbhostname, $dbusername, $dbpassword, $dbname);

$err = '';
$username = '';
$remember = '';

if(isset($_COOKIE['cookie_username'])){
    $cookie_username = $_COOKIE['$cookie_username'];
    $cookie_password = $_COOKIE['$cookie_password'];
    $sql = "SELECT * FROM user-login WHERE username = '$cookie_username'";
    $execute = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($execute);
    if($data['password'] == $cookie_password){
        $_SESSION['session_username'] = $cookie_username;
        $_SESSION['session_password'] = $cookie_password;
    }
}

if(isset($_SESSION['session_username'])){
    header("location:afterlogin.php");
    exit();
}

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = $_POST['remember'];

    if($username == '' or $password == ""){
        $err .= '<li>Please entry your username and password</li>';
    } else{
        $sql = "SELECT * FROM user-login WHERE username = '$username'";
        $execute = mysqli_query($conn, $sql);
        $data = mysqli_fetch_array($execute);

        if($data['username'] == ''){
            $err .= "<li>Username <b>$username</b> unavailable</li>";
        }elseif($data['password'] != md5($password)){
            $err .= "<li>Password is unvalid.</li>";
        }

        if(empty($err)){
            $_SESSION['session_username'] = $username;
            $_SESSION['session_password'] = md5($password);


            if($remember == 1){
                $cookie_name = 'cookie_username';
                $cookie_value = $username;
                $cookie_time = time()+3600;
                setcookie($cookie_name, $cookie_value, $cookie_time,'/');

                $cookie_name = 'cookie_password';
                $cookie_value = md5($password);
                $cookie_time = time()+3600;
                setcookie($cookie_name, $cookie_value, $cookie_time,'/');
            }
            header('location:afterlogin.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://unpkg.com/tailwindcss@2.0.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
  <div class="font-sans min-h-screen antialiased bg-gray-900 pt-24 pb-5">
    <div class="flex flex-col justify-center sm:w-96 sm:m-auto mx-5 mb-5 space-y-8">
      <h1 class="font-bold text-center text-4xl text-yellow-500">Sheryl<span class="text-blue-500">App</span></h1>
      <?php if($err){ ?>
                            <div id="login-alert" class="alert alert-danger col-sm-12">
                                <ul><?php echo $err ?></ul>
                            </div>
                        <?php } ?>
      <form action="#">
        <div class="flex flex-col bg-white p-10 rounded-lg shadow space-y-6">
          <h1 class="font-bold text-xl text-center">Log in to your account</h1>
        
          <div class="flex flex-col space-y-1">
            <input type="text" name="username" id="username" class="border-2 rounded px-3 py-2 w-full focus:outline-none focus:border-blue-400 focus:shadow" placeholder="Username" />
          </div>

          <div class="flex flex-col space-y-1">
            <input type="password" name="password" id="password" class="border-2 rounded px-3 py-2 w-full focus:outline-none focus:border-blue-400 focus:shadow" placeholder="Password" />
          </div>

          <div class="relative">
            <input type="checkbox" name="remember" id="remember" checked class="inline-block align-middle" <?php if($remember == '1') echo "checked"?>>
            <label class="inline-block align-middle" for="remember">Remember me</label>
          </div>

          <div class="flex flex-col-reverse sm:flex-row sm:justify-between items-center">
            <button name="login" type="submit" class="bg-blue-500 text-white font-bold px-5 py-2 rounded focus:outline-none shadow hover:bg-blue-700 transition-colors">Log In</button>
          </div>
        </div>
      </form>
      <div class="flex justify-center text-gray-500 text-sm">
      </div>
    </div>
  </div>
</body>
</html>