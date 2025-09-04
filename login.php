<?php
// login.php
header('Content-Type: application/json; charset=utf-8');

// تمكين عرض الأخطاء
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo json_encode(['status' => 'error', 'message' => 'طريقة الطلب غير صحيحة']);
    exit;
}

if (!file_exists('config.php')) {
    echo json_encode(['status' => 'error', 'message' => 'ملف الإعدادات غير موجود']);
    exit;
}

require_once 'config.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'يرجى ملء جميع الحقول']);
    exit;
}

try {
    // التحقق من وجود المستخدم
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email'] = $user['email'];
        
        // إرجاع رسالة نجاح مع رابط الانتقال
        echo json_encode([
            'status' => 'success', 
            'message' => 'تم تسجيل الدخول بنجاح!',
            'redirect' => 'home.php' // إضافة خاصية الانتقال
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة!']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'خطأ في قاعدة البيانات: ' . $e->getMessage()]);
}
?>