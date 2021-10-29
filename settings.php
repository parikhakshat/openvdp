<?php
session_start();
if (!isset($_SESSION["session"]))
{
    $error = "Not Authorized";
    header("Location: login.php");
}
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
    $nameRegex = "/^[a-zA-Z0-9!()\x20]*$/";
    $emailRegex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
    $passwordRegex = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*#.!@$%^&]).{8,32}$/";
    if (isset($_POST["name"]) && !empty($_POST["name"]))
    {
        if (preg_match($nameRegex, $_POST["name"]) == true)
        {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $query = "UPDATE users SET name = \"$name\" WHERE email = \"{$_SESSION['email']}\"";
            $results = $conn->query($query);
            $error = "Saved!";
            $_SESSION['name'] = $name;
        }
        else
        {
            $error = "Invalid Name!";
        }
    }
    if (isset($_POST["email"]) && !empty($_POST["email"]))
    {
        if (preg_match($emailRegex, $_POST["email"]) == true)
        {

            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $query = "SELECT COUNT(1) FROM users WHERE email = \"$email\"";
            $emailcheck = mysqli_fetch_array($conn->query($query));
            if ($emailcheck['COUNT(1)'] == 0)
            {
                $ending = 'corp.com';
                if (substr_compare($email, $ending, -strlen($ending)) == 0)
                {
                    $query = "UPDATE users SET role = 1 WHERE email = \"{$_SESSION['email']}\"";
                    $results = $conn->query($query);
                    $_SESSION['role'] = 1;
                }
                else
                {
                    $query = "UPDATE users SET role = 0 WHERE email = \"{$_SESSION['email']}\"";
                    $results = $conn->query($query);
                    $_SESSION['role'] = 0;
                }
                $query = "UPDATE users SET email = \"$email\" WHERE email = \"{$_SESSION['email']}\"";
                $results = $conn->query($query);
                $query = "UPDATE reports SET createdby = \"$email\" WHERE createdby = \"{$_SESSION['email']}\"";
                $results = $conn->query($query);
                $query = "UPDATE comments SET email = \"$email\" WHERE email = \"{$_SESSION['email']}\"";
                $results = $conn->query($query);
                $_SESSION['email'] = $email;
                $error = "Saved!";
            }
            else
            {
                $error = "Invalid Email!";
            }
        }
        else
        {
            $error = "Invalid Emaill!";
        }
    }
    if (isset($_POST["password"]) && !empty($_POST["password"]))
    {
        if (preg_match($passwordRegex, $_POST["password"]) == true)
        {
            if (isset($_POST["confirmpassword"]) && !empty($_POST["confirmpassword"]))
            {
                if (preg_match($passwordRegex, $_POST["confirmpassword"]) == true)
                {
                    $password = hash("sha256", mysqli_real_escape_string($conn, $_POST["password"]));
                    $confirmpassword = hash("sha256", mysqli_real_escape_string($conn, $_POST["confirmpassword"]));
                    similar_text($_SESSION['name'], $_POST['password'], $percent);
                    if ($percent < 40)
                    {
                        if ($password == $confirmpassword)
                        {
                            $query = "UPDATE users SET password = '$password' WHERE email = \"{$_SESSION['email']}\"";
                            $results = $conn->query($query);
                            $error = "Saved!";
                        }
                        else
                        {
                            $error = "Passwords do not Match!";
                        }
                    }
                    else
                    {
                        $error = "Password to similar to name!";
                    }
                }
                else
                {
                    $error = "Invalid Confirm Password Value!";
                }
            }
        }
        else
        {
            $error = "Invalid Password!";
        }
    }
    if (isset($_POST["color"]) && !empty($_POST["color"]))
    {
        $regex = "/^#[0-9A-F]{6}$/i";
        if (preg_match($regex, $_POST['color']) == true)
        {
            $color = mysqli_real_escape_string($conn, $_POST['color']);
            $query = "UPDATE users SET color = \"$color\" WHERE email = \"{$_SESSION['email']}\"";
            $results = $conn->query($query);
            $_SESSION['color'] = $color;
            $error = "Saved!";
        }
        else
        {
            $error = "Invalid Hex Code!";
        }
    }
}
?>
<html>
<link rel="stylesheet" type="text/css" href="CSS/settings.css">
<head>
    <link rel="shortcut icon" type="image/png" href="Images/favicon.png"/>
    </head>
<div class="settings">
    <div class="logo">
    <img src="Images/logo.png" alt="logo" width="100px" height="100px">
</div>
<div class="title">
<h1>Settings</h1>
</div>
<form action="settings.php" method="post">
<div class="name">
<h2>Name: <?=$_SESSION["name"]; ?></h2>
<input autocomplete="off" type="text" name="name" placeholder="Change your Name">
</div>
<div class="email">
<h2>Email: <?=$_SESSION["email"]; ?></h2> <br>
<input autocomplete="off" type="text" name="email" placeholder="Change your Email">
</div>
<div class="password">
<h2>Password: </h2>
<input autocomplete="off" type="password" id="first" name="password" placeholder="Change your Password"> <br>
<input autocomplete="off" type="password" name="confirmpassword" placeholder="Confirm your Password">
</div>
<div class="color">
<h2>Set your Profile Picture Color<h2>
<input autocomplete="off" type="text" name="color" placeholder="Color Hex Code">
</div>
<div class="submit">
<input type="submit">
</div>
</form>
<?php
if (isset($error) && !empty($error))
{
?>
    <span class="error"><?=$error; ?></span>
    <?php
}
?>
<br><a href="index.php">Return back to Home</a>
</div>
</html>
