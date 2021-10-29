<?php
session_start();
if (!isset($_SESSION["session"]))
{
    $error = "Not Authorized";
    header("Location: login.php");
}
$regex = "/^[a-zA-Z0-9]{13}$/";
$servername = "ENTER_YOUR_DB_SERVER_NAME";
$username = "ENTER_YOUR_DB_USERNAME";
$password = "ENTER_YOUR_DB_PASSWORD";
$database = "ENTER_YOUR_DB_NAME";
$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error)
{
    $error = "Connecting to database error!";
}
$_SESSION["id"] = mysqli_real_escape_string($conn, $_GET["id"]);
if (isset($_SESSION["id"]) && !empty($_SESSION["id"]))
{
    if (preg_match($regex, $_SESSION["id"]) == true)
    {
        $query = "SELECT COUNT(1) FROM reports WHERE id = \"{$_SESSION["id"]}\"";
        $reportCheck = mysqli_fetch_array($conn->query($query));
        if ($reportCheck['COUNT(1)'] == 1)
        {
            if ($_SERVER['REQUEST_METHOD'] === 'GET')
            {
                $query = "SELECT enableContent FROM reports WHERE id = \"{$_SESSION["id"]}\"";
                $enableContent = mysqli_fetch_array($conn->query($query));
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST')
            {
                include 'php-plugin/Parsedown.php';
                $query = "SELECT enableContent FROM reports WHERE id = \"{$_SESSION["id"]}\"";
                $enableContent = mysqli_fetch_array($conn->query($query));
                if (isset($_POST["cvss"]) && !empty($_POST["cvss"]))
                {
                    $cvssRegex = '/^(?:[0-9]|1[0])\.?\d$/';
                    if (preg_match($cvssRegex, $_POST["cvss"]) == true && $_POST["cvss"] <= 10.0 && $_POST["cvss"] != 0.0)
                    {
                        $cvss = mysqli_real_escape_string($conn, $_POST['cvss']);
                        $query = "UPDATE reports SET cvss = \"$cvss\" WHERE id = \"{$_SESSION["id"]}\"";
                        $results = $results = $conn->query($query);
                    }
                    else
                    {
                        $error = "Invalid CVSS!";
                    }
                }
                if (isset($_POST["content"]) && !empty($_POST["content"]) && $enableContent['enableContent'] == 1)
                {

                    $Parsedown = new Parsedown();
                    $Parsedown->setMarkupEscaped(true);
                    $Parsedown->setSafeMode(true);
                    $content = mysqli_real_escape_string($conn, $Parsedown->text($_POST['content']));
                    $query = "UPDATE reports SET content = \"$content\" WHERE id = \"{$_SESSION["id"]}\"";
                    $results = $conn->query($query);
                    $query = "UPDATE reports SET enableContent = false WHERE id = \"{$_SESSION["id"]}\"";
                    $results = $conn->query($query);
                }
                if (isset($_POST["category"]) && !empty($_POST["category"]) && $_SESSION["role"] == 1)
                {
                    $fp = @fopen('category.txt', 'r');
                    if ($fp)
                    {
                        $cwe = explode("\n", fread($fp, filesize('category.txt')));
                    }
                    if (in_array($_POST['category'], $cwe) == true)
                    {
                        $category = mysqli_real_escape_string($conn, $_POST['category']);
                        $query = "UPDATE reports SET category = \"$category\" WHERE id = \"{$_SESSION["id"]}\"";
                        $results = $conn->query($query);
                    }
                    else
                    {
                        $error = "Invalid Category!";
                    }
                }
                if (isset($_POST["closed"]) && !empty($_POST["closed"]) && $_POST["closed"] == true)
                {
                    $query = "UPDATE reports SET status = \"closed\" WHERE id = \"{$_SESSION["id"]}\"";
                    $results = $results = $conn->query($query);
                }
                if (isset($_POST["fixed"]) && !empty($_POST["fixed"]) && $_POST["fixed"] == true && $_SESSION["role"] == 1)
                {
                    $query = "UPDATE reports SET status = \"fixed\" WHERE id = \"{$_SESSION["id"]}\"";
                    $results = $results = $conn->query($query);
                }
                if (isset($_POST["open"]) && !empty($_POST["open"]) && $_POST["open"] == true && $_SESSION["role"] == 1)
                {
                    $query = "UPDATE reports SET status = \"open\" WHERE id = \"{$_SESSION["id"]}\"";
                    $results = $results = $conn->query($query);
                }
                if (isset($_POST["triaged"]) && !empty($_POST["triaged"]) && $_POST["triaged"] == true && $_SESSION["role"] == 1)
                {
                    $query = "UPDATE reports SET status = \"triaged\" WHERE id = \"{$_SESSION["id"]}\"";
                    $results = $results = $conn->query($query);
                }

                if (isset($_POST["title"]) && !empty($_POST["title"]) && $_POST["title"] == true && $_SESSION["role"] == 1)
                {
                    $title = mysqli_real_escape_string($conn, $_POST['title']);
                    $titleRegex = '/^[a-zA-Z0-9!()\x20]*$/';
                    if (preg_match($titleRegex, $title) == true)
                    {

                        $query = "UPDATE reports SET title = '$title' WHERE id =\"{$_SESSION["id"]}\"";
                        $results = $results = $conn->query($query);
                    }
                }

                if (isset($_POST["comment"]) && !empty($_POST["comment"]) && $enableContent['enableContent'] == 0)
                {
                    $date = date("F jS Y h:i:s A");
                    $Parsedown = new Parsedown();
                    $Parsedown->setMarkupEscaped(true);
                    $Parsedown->setSafeMode(true);
                    $comment = mysqli_real_escape_string($conn, $Parsedown->text($_POST['comment']));
                    $query = "INSERT INTO comments (id, content, email, date) VALUES(\"{$_SESSION["id"]}\",\"$comment\",\"{$_SESSION["email"]}\",'$date')";
                    $results = $conn->query($query);
                }
            }
            $query = "SELECT * FROM reports where id = \"{$_SESSION["id"]}\"";
            $results = mysqli_fetch_array($conn->query($query));
            $title = $results['title'];
            $score = $results['cvss'];
            $createdby = $results['createdby'];
            $content = $results["content"];
            $status = $results["status"];
            $category = $results["category"];
            $publishDate = $results["date"];
            $query = "SELECT DISTINCT name FROM `comments` INNER JOIN users on users.email = comments.email WHERE comments.id=\"{$_SESSION["id"]}\"";
            $results = $conn->query($query);
            if (!empty($results) && isset($results) && mysqli_num_rows($results) > 0)
            {
                while ($row = mysqli_fetch_assoc($results))
                {
                    $collaborators[] = $row["name"];
                }
            }
        }
        else
        {
            $error = "Report does not exist.";
        }
    }
    else
    {
        $error = "Invalid Length or Characters!";
    }
}
else
{
    header("Location: index.php");
}
$link = ("\"reports.php?id=" . $_SESSION["id"] . "\"");
?>
<html>
<head>
    <link rel="shortcut icon" type="image/png" href="Images/favicon.png"/>
    <link rel='stylesheet' type='text/css' href='CSS/reports.css' />
    <script type="text/javascript" src="js/reports.js"></script>
    </head>
<div class="back">
    <a href="index.php">Return back to Home</a>
</div>
<div class="summary">
<h1>Summary</h1>
<hr>
<div class="title">
<h2>Title: <?php echo $title;
if ($_SESSION['role'] == 1)
{
    echo ("<button onclick=\"changeTitle()\">change</button>");
}
?></h2>
</div>
<div class="date">
<h3>Published on: <?=$publishDate ?></h3>
</div>
<div class="category">
<h3>Category: <?php echo $category;
if ($_SESSION['role'] == 1)
{
    echo ("<button onclick=\"changeCategory()\">change</button>");
}
?></h3>
</div>
<div class="cvss">
<h3>CVSS: <?php echo $score;
echo ("<button onclick=\"changeCvss()\">change</button>");
?></h3>
</div>
<div class="status">
<h3>Status: <?php echo $status;
if ($_SESSION['role'] == 1)
{
    echo ("<button onclick=\"changeStatus()\">change</button>");
}
?></h3>
</div>
<div class="collaborators">
<h3>Collaborators: <?php
$query = "SELECT name FROM users WHERE email = \"$createdby\"";
$publisher = mysqli_fetch_array($conn->query($query));
echo $publisher['name'] . ', ';
$count = count($collaborators);
for ($x = 0;$x < $count;$x++)
{
    echo $collaborators[$x] . ', ';

}
?></h3>
</div>
<hr>
</div>
<?php
$query = "SELECT enableContent FROM reports WHERE id = \"{$_SESSION["id"]}\"";
$enableContent = mysqli_fetch_array($conn->query($query));
if ($enableContent['enableContent'] == 1)
{
    $contentHtml = "<div class=\"editContent\"><form action=$link method=\"post\"><h2>Content:</h2>
    <textarea id=\"report\" name=\"content\"></textarea><i>Supports Markdown</i>
    <br>
    <input type=\"submit\">
</form></div>";
    echo $contentHtml;
}
?>
<hr>
<div class="report">
<h1>Report:</h1><br>
<?=$content
?>
</div>
<div class="comments">
<h1>Comments:</h1><br>
<hr>
<?php
$query = "SELECT * FROM comments where id = \"{$_SESSION["id"]}\"";
$results = $conn->query($query);
if (!empty($results) && isset($results) && mysqli_num_rows($results) > 0)
{
    while ($row = mysqli_fetch_assoc($results))
    {
        $comments[] = $row;
    }
    $count = count($comments);
    for ($x = 0;$x < $count;$x++)
    {
        echo "<div class=\"comment\">";
        echo "<i>Date: " . $comments[$x]['date'] . "</i>";
        echo "<br>";
        $email = $comments[$x]['email'];
        $query = "SELECT name FROM users where email = '$email'";
        $results = $conn->query($query);
        $name = mysqli_fetch_array($results);
        echo "<b>Published by: </b>" . $name['name'];
        echo "<br>";
        echo $comments[$x]['content'];
        echo "<br></div><hr>";
    }
}
?>
</div>
<?php
if ($enableContent['enableContent'] == 0)
{
    $commentHtml = "<div class=\"addComment\"><form action=" . $link . "method=\"post\"><h1>Add a Comment!</h1><textarea id=\"report\" name=\"comment\"></textarea><i>Supports Markdown</i>
    <br>
    <button type=\"submit\">Submit</button>
</form>";
    echo $commentHtml;
}
?>
<?php
if (isset($error) && !empty($error))
{
?>
    <span class="error"><?=$error; ?></span>
    <?php
}
?>
</html>
