<?php
$conn = new mysqli('localhost', 'root', '', 'bucketlist');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, age, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $username, $email, $age, $password);
    $stmt->execute();
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="bucketlist_style.css">
</head>
<body>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="number" name="age" placeholder="Age" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>