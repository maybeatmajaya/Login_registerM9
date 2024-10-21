<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    deleteUser($_GET['id']);
}

// Handle update action
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $level = $_POST['level'];
    updateUser($id, $email, $fullname, $level);
}

$users = getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($user['user_fullname']); ?>!</h2>
    <p>Email anda: <?php echo htmlspecialchars($user['user_email']); ?></p>
    <p>Level anda: <?php echo $user['level']; ?></p>
    
    <h3>List User</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Full Name</th>
            <th>Level</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?php echo htmlspecialchars($u['id']); ?></td>
            <td><?php echo htmlspecialchars($u['user_email']); ?></td>
            <td><?php echo htmlspecialchars($u['user_fullname']); ?></td>
            <td><?php echo $u['level']; ?></td>
            <td>
                <a href="?action=edit&id=<?php echo $u['id']; ?>">Edit</a>
                <a href="?action=delete&id=<?php echo $u['id']; ?>" onclick="return confirm('Apakah kamu yakin ?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

    <?php if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])): ?>
        <?php
        $editUser = array_filter($users, function($u) { return $u['id'] == $_GET['id']; });
        $editUser = reset($editUser);
        ?>
        <h3>Edit User</h3>
        <form method="post">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo $editUser['id']; ?>">
            <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($editUser['user_email']); ?>" required></label><br>
            <label>Full Name: <input type="text" name="fullname" value="<?php echo htmlspecialchars($editUser['user_fullname']); ?>" required></label><br>
            <label>Level: <input type="number" name="level" value="<?php echo $editUser['level']; ?>" required></label><br>
            <input type="submit" value="Update">
        </form>
    <?php endif; ?>

    <br>
    <a href="logout.php">Keluar</a>
</body>
</html>