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

$register_error = "";
$register_success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];

    // تشفير كلمة المرور
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // التحقق من عدم وجود اسم المستخدم أو البريد الإلكتروني مسبقًا
    $check_sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $username, $email);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
         $register_error = "اسم المستخدم أو البريد الإلكتروني مسجل مسبقًا.";
    } else {
        // إضافة المستخدم الجديد
        $sql = "INSERT INTO users (username, password, email, first_name, last_name, phone_number) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $username, $hashed_password, $email, $first_name, $last_name, $phone_number);

        if ($stmt->execute()) {
            $register_success = true;
            header("Location: login.php?register_success=true"); // الانتقال إلى صفحة تسجيل الدخول مع رسالة نجاح
             exit();
        } else {
            $register_error = "حدث خطأ أثناء تسجيل المستخدم. يرجى المحاولة مرة أخرى.";
        }
        $stmt->close();
    }

    $check_stmt->close();
}

?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>تسجيل حساب جديد</title>
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
                <h2 class="text-3xl font-bold text-gray-800">تسجيل حساب جديد</h2>
                <p class="mt-2 text-gray-500">أدخل بياناتك لإنشاء حساب جديد.</p>
            </div>
            <form class="mt-8 space-y-6" method="post" action="register.php">
                <div class="rounded-md shadow-sm">
                    <div>
                        <label class="sr-only" for="username">اسم المستخدم</label>
                        <input type="text" name="username" id="username" autocomplete="username" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="اسم المستخدم" />
                    </div>
                    <div>
                        <label class="sr-only" for="password">كلمة المرور</label>
                        <input type="password" name="password" id="password" autocomplete="new-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="كلمة المرور" />
                    </div>
                    <div>
                        <label class="sr-only" for="email">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" autocomplete="email" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="البريد الإلكتروني" />
                    </div>
                    <div>
                        <label class="sr-only" for="first_name">الاسم الأول</label>
                        <input type="text" name="first_name" id="first_name"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="الاسم الأول" />
                    </div>
                    <div>
                        <label class="sr-only" for="last_name">اسم العائلة</label>
                        <input type="text" name="last_name" id="last_name"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="اسم العائلة" />
                    </div>
                    <div>
                        <label class="sr-only" for="phone_number">رقم الهاتف</label>
                        <input type="tel" name="phone_number" id="phone_number"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="رقم الهاتف" />
                    </div>
                </div>
                <?php if ($register_error) { ?>
                <p class="text-red-500 text-center"><?php echo $register_error; ?></p>
                <?php } ?>
                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        تسجيل حساب جديد
                    </button>
                </div>
                <div class="text-center mt-4">
                    <a href="login.php" class="text-blue-600 hover:underline">هل لديك حساب بالفعل؟ سجل الدخول</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
<?php $conn->close(); ?>
