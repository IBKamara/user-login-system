<?php
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="dashboard">
            <div class="header">
                <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h1>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
            
            <div class="user-info">
                <h2>Your Profile</h2>
                <div class="info-card">
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                    <p><strong>Member since:</strong> <?php echo date('F j, Y', strtotime($user['created_at'])); ?></p>
                </div>
            </div>
            
            <div class="content">
                <h2>User Content</h2>
                <p>This is your personal dashboard. Only logged-in users can see this page.</p>
                <div class="card-grid">
                    <div class="card">
                        <h3>Profile Settings</h3>
                        <p>Update your profile information and password.</p>
                    </div>
                    <div class="card">
                        <h3>Recent Activity</h3>
                        <p>View your recent activity and notifications.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>