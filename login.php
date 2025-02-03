<?php
// الاتصال بقاعدة البيانات (تأكد من تعديل بيانات الاتصال)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_ter2";

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // التحقق من وجود المستخدم واسترجاع دوره
    $sql = "SELECT users.user_id, users.username, users.password, roles.role_name 
            FROM users 
            INNER JOIN roles ON users.role_id = roles.role_id
            WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // تم التحقق من كلمة المرور، ابدأ الجلسة
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role_name']; // تخزين دور المستخدم في الجلسة

             // توجيه المستخدم بناءً على دوره
             if($row['role_name'] == 'admin'){
                header("Location: admin/index.php"); // توجيه الأدمن إلى لوحة التحكم
             }else{
                header("Location: index.php"); // توجيه المستخدم العادي إلى الصفحة الرئيسية
             }
            exit();
        } else {
            $login_error = "اسم المستخدم أو كلمة المرور غير صحيحة.";
        }
    } else {
        $login_error = "اسم المستخدم أو كلمة المرور غير صحيحة.";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>تسجيل الدخول</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-6">
                <img alt="شعار الموقع" class="w-20 h-20 mx-auto rounded-full mb-4"
                    src="https://storage.googleapis.com/a1aa/image/CD2370oImNJCFhznf9jv2uAqvAw8tqtqei2wwek9MpdjdhCoA.jpg" />
                <h2 class="text-3xl font-bold text-gray-800">تسجيل الدخول</h2>
                <p class="mt-2 text-gray-500">أدخل بياناتك لتسجيل الدخول إلى المنصة.</p>
            </div>
            <form class="mt-8 space-y-6" method="post" action="login.php">
                <div class="rounded-md shadow-sm">
                    <div>
                        <label class="sr-only" for="username">اسم المستخدم</label>
                        <input type="text" name="username" id="username" autocomplete="username" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="اسم المستخدم" />
                    </div>
                    <div>
                        <label class="sr-only" for="password">كلمة المرور</label>
                        <input type="password" name="password" id="password" autocomplete="current-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="كلمة المرور" />
                    </div>
                </div>
                <?php if ($login_error) { ?>
                <p class="text-red-500 text-center"><?php echo $login_error; ?></p>
                <?php } ?>
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        تسجيل الدخول
                    </button>
                </div>
                <div class="text-center mt-4">
                    <a href="register.php" class="text-blue-600 hover:underline">ليس لديك حساب؟ سجل الآن</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php $conn->close(); ?>
