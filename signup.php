<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $pass]);

    echo "<script>alert('Signup successful'); window.location.href='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; }
        form {
            margin: 100px auto;
            width: 300px;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            background-color: #002f34;
            color: white;
            border: none;
        }
    </style>
</head>
<body>
<form method="POST">
    <h2>Signup</h2>
    <input type="text" name="name" required placeholder="Full Name">
    <input type="email" name="email" required placeholder="Email">
    <input type="password" name="password" required placeholder="Password">
    <button type="submit">Register</button>
</form>
</body>
</html>
