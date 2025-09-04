<?php
// verify.php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_code = $_POST['verification_code'];
    
    if ($entered_code == $_SESSION['verification_code']) {
        // تم التحقق بنجاح
        echo json_encode(['status' => 'success', 'message' => 'تم التحقق بنجاح!']);
        
        // هنا يمكنك إكمال عملية التسجيل إذا لزم الأمر
    } else {
        echo json_encode(['status' => 'error', 'message' => 'رمز التحقق غير صحيح!']);
    }
}
?>