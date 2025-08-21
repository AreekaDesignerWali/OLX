<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=dbqzrokrixpgxp", "unuw9ry46la8t", "4cgdhp7dokz1", [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
