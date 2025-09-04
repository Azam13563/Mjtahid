<?php
// register.php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // التحقق من تطابق كلمات المرور
    if ($password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'كلمات المرور غير متطابقة!']);
        exit;
    }
    
    // التحقق من طول كلمة المرور
    if (strlen($password) < 6) {
        echo json_encode(['status' => 'error', 'message' => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف!']);
        exit;
    }
    
    // التحقق من عدم وجود البريد الإلكتروني مسبقاً
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'البريد الإلكتروني مسجل مسبقاً!']);
        exit;
    }
    
    // تشفير كلمة المرور وإدخال المستخدم
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
    
    if ($stmt->execute([$full_name, $email, $hashed_password])) {
        // إرسال رمز التحقق (هنا سيتم محاكاته)
        $verification_code = rand(100000, 999999);
        $_SESSION['verification_code'] = $verification_code;
        $_SESSION['temp_user'] = ['email' => $email, 'full_name' => $full_name];
        
        echo json_encode(['status' => 'success', 'message' => 'تم إنشاء الحساب بنجاح!', 'code' => $verification_code]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'حدث خطأ أثناء إنشاء الحساب!']);
    }
}
?>