<?php
$servername = "ENTER_YOUR_DB_SERVER_NAME";
$username = "ENTER_YOUR_DB_USERNAME";
$password = "ENTER_YOUR_DB_PASSWORD";
$database = "ENTER_YOUR_DB_NAME";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error)
{
    $error = "Connecting to database error!";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $emailRegex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
    $passwordRegex = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*#.!@$%^&]).{8,32}$/";
    if (preg_match($emailRegex, $_POST["email"]) == true && preg_match($passwordRegex, $_POST["password"]) == true)
    {
        $error = '';
        $password = hash("sha256", mysqli_real_escape_string($conn, $_POST["password"]));
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $query = "SELECT password FROM users WHERE email ='$email'";
        $results = mysqli_fetch_array($conn->query($query));
        $query2 = "SELECT COUNT(1) FROM users WHERE email = '$email'";
        $emailcheck = mysqli_fetch_array($conn->query($query2));
        if ($emailcheck['COUNT(1)'] == 1)
        {
            if ($password == $results['password'])
            {
                session_start();
                $_SESSION["session"] = uniqid();
                $query3 = "SELECT * FROM users where email='$email'";
                $results = mysqli_fetch_array($conn->query($query3));
                $_SESSION["email"] = $email;
                $_SESSION["role"] = $results['role'];
                $_SESSION["name"] = $results['name'];
                $_SESSION['color'] = $results['color'];
                $error = "Login Successful!";
                header('Location: index.php');
            }
            else
            {
                $error = "Incorrect Password!";
            }
        }
        else
        {
            $error = "Invalid Email!";
        }
    }
    else
    {
        $error = "Invalid characters in email or password!";
    }
}
?>



<html>
<link rel="stylesheet" type="text/css" href="CSS/login.css">
<head>
    <link rel="shortcut icon" type="image/png" href="Images/favicon.png"/>
    </head>
<body>
<div class="login">
    <div class="logo">
    <img src="Images/logo.png" alt="logo" width="100px" height="100px">
</div>
<div class="title">
    <h1> Login</h1>
</div>
    <form action="login.php" method="post">
<div class="email">
<input type="email" name="email" placeholder="Email">
</div>
<div class="password">
<input type="password" name="password" placeholder="Password">
</div>
<div class="submit">
<input id="submit" type="submit" value="Sign In">
</div>
Don't have an Account?<a href="register.php"> Register here!</a>
</form>
<?php
if (isset($error) && !empty($error))
{
?>
    <span class="error"><?=$error; ?></span>
    <?php
}
?>
</div>
</body>
<script>
</script>
</html>
