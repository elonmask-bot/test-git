<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة السياحة في تعز</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
        .top-bar {
            background-color: #0060f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px 20px; /* زيادة الـ padding لجعل الشريط أطول */
            display: flex;
            align-items: center;
            justify-content: center; /* توسيط العناصر */
            z-index: 999;
            position: sticky;
            top: 0;
        }

        .top-bar img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
            border-radius: 50%;
            position: absolute; /* لجعل الشعار في اليسار */
            left: 20px; /* هامش من اليسار */
        }
        .top-bar h1 {
            font-size: 1.5rem;
            font-weight: bold;
            color : white;
           
        }
        .sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background-color: #fff;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
            transition: right 0.3s ease-in-out;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar.active {
            right: 0;
        }
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        .sidebar-header img {
            width: 80px;
            height: 80px;
            margin-bottom: 10px;
            border-radius: 50%;

        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            text-decoration: none;
            color: #333;
            transition: background-color 0.2s ease;
        }
        .sidebar-menu a i {
            margin-left: 10px;
            font-size: 1.2em;
            color: #666;
        }
        .sidebar-menu a:hover {
            background-color: #f0f0f0;
        }
        .menu-toggle-btn{
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: #3b82f6;
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            z-index: 1001;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }
        main {
             margin-top: 70px; /* مسافة أسفل الشريط العلوي */
         }
    </style>
</head>
<body class="bg-sky-500">
<div class="top-bar">
    <img alt="شعار الموقع"  src="https://storage.googleapis.com/a1aa/image/CD2370oImNJCFhznf9jv2uAqvAw8tqtqei2wwek9MpdjdhCoA.jpg"/>
    <h1>منصة السياحة في تعز</h1>
</div>
<div class="menu-toggle-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</div>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <img alt="شعار الموقع"  src="https://storage.googleapis.com/a1aa/image/CD2370oImNJCFhznf9jv2uAqvAw8tqtqei2wwek9MpdjdhCoA.jpg"/>
        <h1 class="text-2xl font-bold">منصة السياحة في تعز</h1>
        <span class="close-btn" onclick="closeSidebar()">×</span>
    </div>

    <nav class="sidebar-menu">
        <a href="index.php">
            <i class="fas fa-home"></i> الرئيسية
        </a>
        <a href="index.php">
            <i class="fas fa-map-marked-alt"></i> استكشاف المديريات
        </a>


        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="register.php">
                <i class="fas fa-user-circle"></i> تسجيل مستخدم جديد
            </a>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
            </a>
        <?php else: ?>
            <a href="login.php">
                <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
            </a>
            <a href="register.php">
                <i class="fas fa-user-plus"></i> تسجيل حساب
            </a>
        <?php endif; ?>
    </nav>
</div>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }
    function closeSidebar(){
        document.getElementById('sidebar').classList.remove('active');
    }
</script>
</body>
</html>
