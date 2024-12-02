<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'bucketlist');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item = $_POST['item'];
    $stmt = $conn->prepare("INSERT INTO items (user_id, item) VALUES (?, ?)");
    $stmt->bind_param("is", $user_id, $item);
    $stmt->execute();
}

$items = $conn->query("SELECT * FROM items WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
            margin-right: 10px;
        }

        button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #5cb85c;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4cae4c;
        }

        ul {
            list-style-type: none;
            padding: 0;
            max-width: 600px;
            margin: 0 auto;
        }

        li {
            background: white;
            margin: 10px 0;
            padding: 15px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        a {
            color: #d9534f;
            text-decoration: none;
            margin-left: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .logout {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #d9534f;
            text-decoration: none;
        }

        .logout:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php';?>
    <h1>Your Bucket List</h1>
    <form method="POST">
        <input type="text" name="item" placeholder="Add a new item" required>
        <button type="submit">Add</button>
    </form>
    <ul>
        <?php while ($row = $items->fetch_assoc()): ?>
            <li>
                <?php echo htmlspecialchars($row['item']); ?>
                <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                <a href="update.php?id=<?php echo $row['id']; ?>">Update</a>
            </li>
        <?php endwhile; ?>
    </ul>
    <a href="logout.php">Logout</a>
</body>
</html>