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
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $error = '';
    $state = 0;
    if (!isset($_POST["name"]) || empty($_POST["name"]))
    {
        $error = "Please Enter Name!";
    }
    else
    {
        $nameRegex = "/^[a-zA-Z0-9!()\x20]*$/";
        if (preg_match($nameRegex, $_POST["name"]) == true)
        {
            $state++;
        }
        else
        {
            $state--;
            $error = "Invalid Characters in Name!";
        }
    }
    if (!isset($_POST["email"]) || empty($_POST["email"]))
    {
        $error = "Please Enter Email!";
    }
    else
    {
        $emailRegex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
        if (preg_match($emailRegex, $_POST["email"]) == true)
        {
            $state++;
        }
        else
        {
            $state--;
            $error = "Invalid Characters in Email!";
        }
    }
    if (!isset($_POST["password"]) || empty($_POST["password"]))
    {
        $error = "Error: Please Enter Password";
    }
    else
    {
        $passwordRegex = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*#.!@$%^&]).{8,32}$/";
        if (preg_match($passwordRegex, $_POST["password"]) == true)
        {
            $state++;
        }
        else
        {
            $state--;
            $error = "Invalid Length or Characters in Password!";
        }
    }
    if (!isset($_POST["confirmpassword"]) || empty($_POST["confirmpassword"]))
    {
        $error = "Please Enter Password Again!";
    }
    else
    {
        $passwordRegex = "/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[*#.!@$%^&]).{8,32}$/";
        if (preg_match($passwordRegex, $_POST["password"]) == true)
        {
            $state++;
        }
        else
        {
            $state--;
            $error = "Invalid Length or Characters in Password!";
        }
    }

    if ($state == 4)
    {
        $password = hash("sha256", mysqli_real_escape_string($conn, $_POST["password"]));
        $confirmpassword = hash("sha256", mysqli_real_escape_string($conn, $_POST["confirmpassword"]));
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $emailexistsquery = "SELECT name FROM users WHERE email='$email'";
        $emailexists = $conn->query($emailexistsquery);
        $role = 0;
        $ending = 'corp.com';
        $id = uniqid();
        $name = mysqli_real_escape_string($conn, $_POST["name"]);
        similar_text($name, $_POST['password'], $percent);
        if ($percent < 40)
        {
            if ($password == $confirmpassword)
            {
                if (mysqli_num_rows($emailexists) > 0)
                {
                    $error = "Email taken!";
                }
                else
                {
                    if (substr_compare($email, $ending, -strlen($ending)) == 0)
                    {
                        $role = 1;
                    }
                    $query = "INSERT INTO users (name, email, password, id, role) VALUES('$name', '$email','$password','$id',$role)";
                    $results = $conn->query($query);
                    session_start();
                    $_SESSION["session"] = uniqid();
                    $_SESSION["email"] = $email;
                    $_SESSION["name"] = $name;
                    $_SESSION["role"] = $role;
                    $_SESSION['color'] = '#FFFFFF';
                    $error = "Saved!";
                    header("Location: index.php");
                    exit();
                }
            }
            else
            {
                $error = "Passwords do not match.";
            }
        }
        else
        {
            $error = "Password is too similar to the name!";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="CSS/register.css">
<head>
    <link rel="shortcut icon" type="image/png" href="Images/favicon.png"/>
    </head>
<body>
<div class="register">
<div class="container">
<div class="logo">
    <img src="Images/logo.png" alt="logo" width="100px" height="100px">
</div>
<div class="title">
    <h1> Register an Account</h1>
</div>
</div>
<form action="register.php" method="post">
<div class="email">
<input autocomplete="off" type="email" name="email" placeholder="Email">
</div>
<div class="name">
<input autocomplete="off" type="text" name="name" placeholder="Name"><br>
<i>Only contains letters and numbers!</i>
</div>
<div class="password">
<input autocomplete="off" type="password" name="password" placeholder="Password"><br>
<i>Password has to be between 8 to 32 characters and must have at least one uppercase letter, one number, and one special character.</i>
</div>
<div class="password">
<input autocomplete="off" type="password" name="confirmpassword" placeholder="Confirm Password">
</div>
<div class="submit">
<input type="submit">
</div>
Already registered?<a href="login.php"> Sign in!</a>
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
