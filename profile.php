<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must login first'); window.location.href='login.php';</script>";
    exit();
}

include 'db.php';
$userId = $_SESSION['user_id'];

// Fetch user info
$stmtUser = $pdo->prepare("SELECT name FROM users WHERE id = ?");
$stmtUser->execute([$userId]);
$user = $stmtUser->fetch();

// Fetch user's ads
$stmtAds = $pdo->prepare("SELECT * FROM ads WHERE user_id = ? ORDER BY created_at DESC");
$stmtAds->execute([$userId]);
$ads = $stmtAds->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
            margin: 0;
        }
        header {
            background-color: #002f34;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h2 {
            margin: 0;
        }
        .btns a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
        }
        .container {
            padding: 30px;
        }
        .ad {
            background: white;
            margin: 15px 0;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
        .ad h3 {
            margin: 0;
            color: #002f34;
        }
        .ad p {
            margin: 5px 0;
        }
        .ad .actions {
            margin-top: 10px;
        }
        .ad .actions button {
            padding: 8px 12px;
            border: none;
            margin-right: 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .edit-btn {
            background-color: #ffc107;
            color: white;
        }
        .delete-btn {
            background-color: #dc3545;
            color: white;
        }
        .post-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <h2>Welcome, <?= htmlspecialchars($user['name']) ?></h2>
    <div class="btns">
        <a href="javascript:void(0)" onclick="goTo('post_ad.php')">Post New Ad</a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <h3>Your Ads</h3>

    <?php if (count($ads) === 0): ?>
        <p>No ads posted yet. <a class="post-btn" href="javascript:void(0)" onclick="goTo('post_ad.php')">Post now</a></p>
    <?php else: ?>
        <?php foreach ($ads as $ad): ?>
            <div class="ad">
                <h3><?= htmlspecialchars($ad['title']) ?></h3>
                <p><?= htmlspecialchars($ad['description']) ?></p>
                <p><strong>Price:</strong> Rs. <?= htmlspecialchars($ad['price']) ?></p>
                <div class="actions">
                    <button class="edit-btn" onclick="goTo('edit_ad.php?id=<?= $ad['id'] ?>')">Edit</button>
                    <button class="delete-btn" onclick="confirmDelete(<?= $ad['id'] ?>)">Delete</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function goTo(page) {
        window.location.href = page;
    }

    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this ad?")) {
            window.location.href = "delete_ad.php?id=" + id;
        }
    }
</script>

</body>
</html>
