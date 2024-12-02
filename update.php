<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'bucketlist');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $item = $conn->query("SELECT * FROM items WHERE id = $id")->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_item = $_POST['item'];
    $stmt = $conn->prepare("UPDATE items SET item = ? WHERE id = ?");
    $stmt->bind_param("si", $new_item, $id);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Item</title>
    <link rel="stylesheet" href="bucketlist_style.css">
</head>
<body>
    <form method="POST">
        <input type="text" name="item" value="<?php echo htmlspecialchars($item['item']); ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>