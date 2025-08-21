<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login to post an ad.'); window.location.href='login.php';</script>";
    exit();
}

include 'db.php';
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);

    if (empty($title) || empty($description) || empty($price)) {
        $error = "All fields are required.";
    } elseif (!is_numeric($price)) {
        $error = "Price must be a valid number.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO ads (user_id, title, description, price) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_SESSION['user_id'], $title, $description, $price]);
            $success = "Ad posted successfully!";
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Post New Ad</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
            padding: 0;
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
            max-width: 600px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .container h3 {
            margin-bottom: 20px;
            color: #002f34;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #128C7E;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
        }
        .error {
            background-color: #ffdddd;
            color: #d8000c;
        }
        .success {
            background-color: #ddffdd;
            color: #4F8A10;
        }
    </style>
</head>
<body>

<header>
    <h2>Post New Ad</h2>
    <div class="btns">
        <a href="javascript:void(0)" onclick="goTo('profile.php')">My Profile</a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <h3>Ad Details</h3>

    <?php if ($error): ?>
        <div class="message error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="message success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <input type="text" name="title" placeholder="Ad Title" required>
        </div>
        <div class="form-group">
            <textarea name="description" rows="4" placeholder="Ad Description" required></textarea>
        </div>
        <div class="form-group">
            <input type="text" name="price" placeholder="Price in PKR" required>
        </div>
        <button type="submit">Post Ad</button>
    </form>
</div>

<script>
    function goTo(page) {
        window.location.href = page;
    }
</script>

</body>
</html>
