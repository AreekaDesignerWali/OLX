<?php include 'db.php'; session_start();
if (!isset($_SESSION['user_id'])) { echo "<script>window.location.href='login.php';</script>"; exit; }
$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM ads WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$ad = $stmt->fetch();
if (!$ad) { echo "Ad not found."; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = "UPDATE ads SET title=?, description=?, price=?, category=?, condition=?, location=?";
    $params = [
        $_POST['title'], $_POST['description'], $_POST['price'],
        $_POST['category'], $_POST['condition'], $_POST['location']
    ];
    if (!empty($_FILES['image']['tmp_name'])) {
        $img = file_get_contents($_FILES['image']['tmp_name']);
        $query .= ", image=?";
        $params[] = $img;
    }
    $query .= " WHERE id=? AND user_id=?";
    $params[] = $id; $params[] = $_SESSION['user_id'];
    $pdo->prepare($query)->execute($params);
    echo "<script>window.location.href='profile.php';</script>"; exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Ad</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; }
        form {
            background: white; padding: 30px;
            margin: 40px auto; width: 400px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            border-radius: 10px;
        }
        input, select, textarea {
            width: 100%; margin-bottom: 15px;
            padding: 10px; border-radius: 5px; border: 1px solid #ccc;
        }
        button {
            width: 100%; padding: 10px;
            background: #128C7E; color: white;
            border: none; border-radius: 5px;
        }
    </style>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <h2>Edit Ad</h2>
        <input type="text" name="title" value="<?= $ad['title'] ?>" required>
        <textarea name="description" required><?= $ad['description'] ?></textarea>
        <input type="number" name="price" value="<?= $ad['price'] ?>" required>
        <select name="category">
            <option <?= $ad['category'] == 'Electronics' ? 'selected' : '' ?>>Electronics</option>
            <option <?= $ad['category'] == 'Vehicles' ? 'selected' : '' ?>>Vehicles</option>
            <option <?= $ad['category'] == 'Furniture' ? 'selected' : '' ?>>Furniture</option>
        </select>
        <select name="condition">
            <option <?= $ad['condition'] == 'New' ? 'selected' : '' ?>>New</option>
            <option <?= $ad['condition'] == 'Used' ? 'selected' : '' ?>>Used</option>
        </select>
        <input type="text" name="location" value="<?= $ad['location'] ?>" required>
        <input type="file" name="image">
        <button type="submit">Update Ad</button>
    </form>
</body>
</html>
