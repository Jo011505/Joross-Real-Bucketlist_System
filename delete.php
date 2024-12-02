<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'bucketlist');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: dashboard.php");
}
?>