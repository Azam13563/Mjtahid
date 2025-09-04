<?php
// config.php
$host = "localhost";
$dbname = "mojtahid_db";
$username = "root"; // عادةً يكون root في بيئة التطوير
$password = ""; // كلمة المرور فارغة في بيئة التطوير (XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>