<?php include 'db.php'; session_start();
if (!isset($_SESSION['user_id'])) { echo "<script>window.location.href='login.php';</script>"; exit; }
$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM ads WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
echo "<script>window.location.href='profile.php';</script>";
exit;
?>
