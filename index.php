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
session_start();
if (!isset($_SESSION["session"]))
{
    $error = "Not Authorized";
    header("Location: login.php");
}
$query = "SELECT color FROM users WHERE email = \"{$_SESSION['email']}\"";
$results = mysqli_fetch_array($conn->query($query));
$_SESSION['color'] = $results["color"];
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $titleRegex = '/^[a-zA-Z0-9!()\x20]*$/';
    if (isset($_POST["title"]) && !empty($_POST["title"]))
    {
        if (preg_match($titleRegex, $_POST["title"]) == true)
        {
            $id = uniqid();
            $fp = @fopen('category.txt', 'r');
            if ($fp)
            {
                $cwe = explode("\n", fread($fp, filesize('category.txt')));
            }
            if (in_array($_POST['category'], $cwe) == true)
            {
                $category = mysqli_real_escape_string($conn, $_POST['category']);
                $title = mysqli_real_escape_string($conn, $_POST['title']);
                $date = date("F jS Y h:i:s A");
                $query = "INSERT INTO reports (id, title, content, cvss, status, createdby, category, date) VALUES('$id',\"$title\",\"placeholder\",0.0,\"open\",\"{$_SESSION['email']}\",\"$category\", \"$date\")";
                $results = $conn->query($query);
                $error = "Saved!";
                header("Location: reports.php?id=$id");
            }
            else
            {
                $error = "Invalid Category!";
            }
        }
        else
        {
            $error = "Invalid Title!";
        }
    }
}
?>
<html>
<head>
    <link rel="shortcut icon" type="image/png" href="Images/favicon.png"/>
    <script type="text/javascript" src="js/index.js"></script>
    </head>
<link rel='stylesheet' type='text/css' href='CSS/indexCss.php' />
<body>
<div class="index">
  <div class="header">
<div class="headerImg">
  <img src="Images/header.png" alt="header" width="328px" height="124.8px">
  </div>
<div class="profile">
<div class="user">
  <b><?=$_SESSION["name"]; ?></b>
</div>
<div class="dropdown">
  <button><div class="profileImg"></div></button>
  <div class="dropdown-content">
    <a target="_blank" href="settings.php">Settings</a>
    <a href="logout.php">Logout</a>
  </div>
</div>
</div>
</div>
<hr>
<div class="reportsList">
<h1>Reports</h1>
<?php
if ($_SESSION['role'] == 1)
{
    $query = "SELECT * FROM reports";
    $results = $conn->query($query);
    if (!empty($results) && isset($results) && mysqli_num_rows($results) > 0)
    {
        while ($row = mysqli_fetch_assoc($results))
        {
            $titles[] = $row["title"];
            $statuses[] = $row["status"];
            $reports[] = $row["id"];
        }
        $count = count($reports);
        $first = "<div class=\"report\"><div class=\"title\"><a href=\"reports.php?id=";
        $middle = "\"> Title: ";
        $end = "</a></div>";
        for ($x = 0;$x < $count;$x++)
        {
            echo ($first . $reports[$x] . $middle . $titles[$x] . "</a></div><div class=\"status\"><b>Status: </b><img alt='status' width='25px' height='25px' src=\"Images/" . $statuses[$x] . ".png\"></div></div>");
            echo "\n";
        }

    }
}
else
{
    $query = "SELECT * FROM reports WHERE createdby = \"{$_SESSION['email']}\"";
    $results = $conn->query($query);
    if (!empty($results) && isset($results) && mysqli_num_rows($results) > 0)
    {
        while ($row = mysqli_fetch_assoc($results))
        {
            $titles[] = $row["title"];
            $statuses[] = $row["status"];
            $reports[] = $row["id"];
        }
        $count = count($reports);
        $first = "<div class=\"report\"><div class=\"title\"><a href=\"reports.php?id=";
        $middle = "\"> Title: ";
        for ($x = 0;$x < $count;$x++)
        {
            echo ($first . $reports[$x] . $middle . $titles[$x] . "</a></div><div class=\"status\"><b>Status: </b><img alt='status' width='25px' height='25px' src=\"Images/" . $statuses[$x] . ".png\"></div></div>");
            echo "\n";
        }
    }
}
?>
</div>
<hr>
<div class="creation">
<h1>Create a report</h1>
<form action="index.php" method="post">
Title: 
<input autocomplete="off" type="text" name="title" style="width:300px;">
Category:
<div class="autocomplete" style="width:300px;">
    <input autocomplete="off" id="category" type="text" name="category" oninput="autoComplete()">
  </div>
<input type="submit">
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
<hr>
</div>
</body>
</html>
