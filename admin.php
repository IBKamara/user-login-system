<?php
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Get all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="dashboard">
            <div class="header">
                <h1>Admin Dashboard</h1>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
            
            <div class="admin-stats">
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <p class="stat-number"><?php echo count($users); ?></p>
                </div>
                <div class="stat-card">
                    <h3>Admins</h3>
                    <p class="stat-number">
                        <?php 
                        $adminCount = array_filter($users, function($u) { 
                            return $u['role'] === 'admin'; 
                        });
                        echo count($adminCount);
                        ?>
                    </p>
                </div>
                <div class="stat-card">
                    <h3>Regular Users</h3>
                    <p class="stat-number">
                        <?php 
                        $userCount = array_filter($users, function($u) { 
                            return $u['role'] === 'user'; 
                        });
                        echo count($userCount);
                        ?>
                    </p>
                </div>
            </div>
            
            <div class="users-table">
                <h2>Manage Users</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="role-badge role-<?php echo $user['role']; ?>">
                                    <?php echo $user['role']; ?>
                                </span>
                            </td>
                            <td><?php echo date('Y-m-d', strtotime($user['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>