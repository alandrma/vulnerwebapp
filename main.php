<?php
$host = "localhost";
$user = "root";
$pass = "";
dbname = "vulnerable_db";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL Injection Vulnerability
if (isset($_GET['id'])) {
    $id = $_GET['id']; // No sanitization
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = $conn->query($query);
    
    while ($row = $result->fetch_assoc()) {
        echo "Username: " . $row['username'] . "<br>";
    }
}

// XSS Vulnerability
if (isset($_POST['comment'])) {
    $comment = $_POST['comment']; // No escaping
    echo "<p>Comment: $comment</p>";
}

// Local File Inclusion Vulnerability
if (isset($_GET['page'])) {
    $page = $_GET['page']; // No validation
    include($page);
}

$conn->close();
?>

<form method="POST">
    <input type="text" name="comment">
    <input type="submit" value="Submit">
</form>

<a href="?id=1">SQLi Test</a>
<a href="?page=../../etc/passwd">LFI Test</a>
