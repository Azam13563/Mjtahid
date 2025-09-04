<?php
// home.php
session_start();

// التحقق إذا كان المستخدم قد سجل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// احصل على معلومات المستخدم من الجلسة
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مجتهد - نظام تنظيم الدراسة المتكامل</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6A5ACD;
            --secondary: #4B0082;
            --dark: #121212;
            --darker: #0A0A0A;
            --light: #1E1E1E;
            --text: #E0E0E0;
            --accent: #20B2AA;
            --success: #32CD32;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, var(--darker) 0%, var(--dark) 100%);
            color: var(--text);
            min-height: 100vh;
            padding: 20px;
            line-height: 1.6;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logo h1 {
            font-size: 2.5rem;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
            text-shadow: 0 0 10px rgba(106, 90, 205, 0.5);
        }
        
        .logo-icon {
            font-size: 2.8rem;
            color: var(--primary);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
        }
        
        nav a {
            color: var(--text);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 8px 15px;
            border-radius: 20px;
        }
        
        nav a:hover, nav a.active {
            background: rgba(106, 90, 205, 0.2);
            color: var(--primary);
        }
        
        .user-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(106, 90, 205, 0.1);
            padding: 10px 15px;
            border-radius: 20px;
            border: 1px solid rgba(106, 90, 205, 0.3);
        }
        
        .user-name {
            font-weight: bold;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.1rem;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(106, 90, 205, 0.4);
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background: rgba(106, 90, 205, 0.1);
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 25px;
            margin-bottom: 40px;
        }
        
        .sidebar {
            background: rgba(30, 30, 30, 0.6);
            border-radius: 15px;
            padding: 25px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--accent);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .sidebar-menu {
            list-style: none;
        }
        
        .sidebar-menu li {
            margin-bottom: 15px;
        }
        
        .sidebar-menu a {
            color: var(--text);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: rgba(106, 90, 205, 0.2);
            color: var(--primary);
        }
        
        .main-content {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, rgba(106, 90, 205, 0.3) 0%, rgba(75, 0, 130, 0.3) 100%);
            border-radius: 15px;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            transform: rotate(30deg);
        }
        
        .welcome-content h2 {
            font-size: 2.2rem;
            margin-bottom: 15px;
            color: white;
        }
        
        .welcome-content p {
            opacity: 0.9;
            max-width: 600px;
            font-size: 1.1rem;
        }
        
        .user-greeting {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .user-greeting-icon {
            font-size: 2.5rem;
            color: var(--accent);
        }
        
        .welcome-actions {
            display: flex;
            gap: 15px;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background: rgba(30, 30, 30, 0.6);
            border-radius: 15px;
            padding: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            flex-direction: column;
            gap: 15px;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--primary);
            box-shadow: 0 5px 15px rgba(106, 90, 205, 0.3);
        }
        
        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stat-header i {
            font-size: 1.8rem;
            color: var(--primary);
        }
        
        .stat-value {
            font-size: 2.2rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-title {
            font-size: 1rem;
            opacity: 0.7;
        }
        
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .feature-card {
            background: rgba(30, 30, 30, 0.6);
            border-radius: 15px;
            padding: 25px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            border-color: rgba(106, 90, 205, 0.5);
        }
        
        .feature-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .feature-header i {
            font-size: 2rem;
            color: var(--accent);
        }
        
        .feature-header h3 {
            font-size: 1.5rem;
        }
        
        .feature-content {
            margin-top: 15px;
        }
        
        .progress-bar {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
            overflow: hidden;
            margin: 15px 0;
        }
        
        .progress {
            height: 100%;
            background: linear-gradient(to right, var(--primary), var(--accent));
            border-radius: 4px;
        }
        
        .tasks {
            list-style: none;
            margin-top: 15px;
        }
        
        .tasks li {
            padding: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .tasks li:last-child {
            border-bottom: none;
        }
        
        .tasks i {
            color: var(--primary);
        }
        
        footer {
            text-align: center;
            padding: 30px 0;
            margin-top: 50px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9rem;
            opacity: 0.7;
        }
        
        @media (max-width: 900px) {
            .dashboard {
                grid-template-columns: 1fr;
            }
            
            nav ul {
                gap: 15px;
            }
        }
        
        @media (max-width: 600px) {
            header {
                flex-direction: column;
                gap: 20px;
            }
            
            .user-actions {
                width: 100%;
                justify-content: center;
            }
            
            .welcome-banner {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }
            
            .welcome-content h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo">
                <i class="fas fa-graduation-cap logo-icon"></i>
                <h1>مجتهد</h1>
            </div>
            
            <nav>
                <ul>
                    <li><a href="#" class="active">الرئيسية</a></li>
                    <li><a href="c2.html">موادي</a></li>
                    <li><a href="c3.html">جدولي</a></li>
                    <li><a href="#">التذكيرات</a></li>
                    <li><a href="#">الإحصائيات</a></li>
                </ul>
            </nav>
            
            <div class="user-actions">
                <div class="user-info">
                    <span class="user-name"><?php echo $user_name; ?></span>
                </div>
                <a href="logout.php" class="btn btn-outline">تسجيل الخروج</a>
            </div>
        </header>
        
        <div class="dashboard">
            <div class="sidebar">
                <h2><i class="fas fa-th-large"></i> القائمة</h2>
                <ul class="sidebar-menu">
                    <li><a href="#" class="active"><i class="fas fa-home"></i> الرئيسية</a></li>
                    <li><a href="c2.html"><i class="fas fa-book"></i> تسجيل المواد</a></li>
                    <li><a href="c3.html"><i class="fas fa-calendar-alt"></i> جدولة المذاكرة</a></li>
                    <li><a href="#"><i class="fas fa-bell"></i> التذكيرات</a></li>
                    <li><a href="AI.html"><i class="fas fa-microchip"></i> AI</a></li>
                    <li><a href="#"><i class="fas fa-chart-line"></i> الإحصائيات</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> الإعدادات</a></li>
                </ul>
            </div>
            
            <div class="main-content">
                <div class="welcome-banner">
                    <div class="welcome-content">
                        <div class="user-greeting">
                            <i class="fas fa-hand-wave user-greeting-icon"></i>
                            <h2>مرحباً بعودتك، <span style="background: linear-gradient(to right, var(--primary), var(--accent)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"><?php echo $user_name; ?></span>!</h2>
                        </div>
                        <p>نحن سعداء لرؤيتك مرة أخرى. استمر من حيث توقفت واستفد من جميع أدواتنا لتحقيق أقصى استفادة من وقت الدراسة.</p>
                    </div>
                    <div class="welcome-actions">
                        <button class="btn btn-primary">استعراض المواد</button>
                        <button class="btn btn-outline">جدولة المذاكرة</button>
                    </div>
                </div>
                
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-header">
                            <i class="fas fa-book"></i>
                        </div>
                        <div class="stat-value">5</div>
                        <div class="stat-title">المواد المسجلة</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="stat-value">12</div>
                        <div class="stat-title">المهام المكتملة</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-value">18</div>
                        <div class="stat-title">ساعة دراسة هذا الأسبوع</div>
                    </div>
                </div>
                
                <div class="features">
                    <div class="feature-card">
                        <div class="feature-header">
                            <i class="fas fa-book-open"></i>
                            <h3>تسجيل المواد</h3>
                        </div>
                        <div class="feature-content">
                            <p>قم بتسجيل موادك الدراسية وإضافة التفاصيل والمرفقات الخاصة بكل مادة.</p>
                            <div class="progress-bar">
                                <div class="progress" style="width: 75%"></div>
                            </div>
                            <p>3 من 4 مواد مكتملة التسجيل</p>
                        </div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-header">
                            <i class="fas fa-calendar"></i>
                            <h3>جدولة المذاكرة</h3>
                        </div>
                        <div class="feature-content">
                            <p>أنشئ جدولاً للمذاكرة وزععه على المواد حسب الأولوية والصعوبة.</p>
                            <ul class="tasks">
                                <li><i class="fas fa-check-circle"></i> إنشاء الجدول الأسبوعي</li>
                                <li><i class="fas fa-circle"></i> توزيع المواد على الأيام</li>
                                <li><i class="fas fa-circle"></i> تحديد أوقات الراحة</li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="feature-card">
                        <div class="feature-header">
                            <i class="fas fa-bell"></i>
                            <h3>التذكيرات والتنبيهات</h3>
                        </div>
                        <div class="feature-content">
                            <p>اضبط التذكيرات لمواعيد الاختبارات وتسليم الواجبات والمهام المهمة.</p>
                            <ul class="tasks">
                                <li><i class="fas fa-bell"></i> اختبار الرياضيات - بعد 3 أيام</li>
                                <li><i class="fas fa-bell"></i> تسليم البحث - بعد 5 أيام</li>
                                <li><i class="fas fa-bell"></i> محاضرة العلوم - غداً 10 ص</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <footer>
            <p>© 2025 مجتهد. جميع الحقوق محفوظة.</p>
            <p>نظام تنظيم الدراسة المتكامل - صمم بخبرة لتحقيق أقصى استفادة من وقت الدراسة</p>
        </footer>
    </div>

    <script>
        // تأثيرات تفاعلية بسيطة
        document.addEventListener('DOMContentLoaded', function() {
            const featureCards = document.querySelectorAll('.feature-card');
            
            featureCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.3)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = 'none';
                });
            });
            
            // محاكاة زيادة عدد ساعات الدراسة
            setInterval(() => {
                const statValue = document.querySelector('.stat-value:nth-child(2)');
                let currentValue = parseInt(statValue.textContent);
                statValue.textContent = currentValue + 1;
            }, 5000);
        });
    </script>
</body>
</html>