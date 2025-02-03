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
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $role_id = $_POST['role_id'];

    // التحقق من تطابق كلمات المرور
    if ($password != $confirm_password) {
        $register_error = "كلمة المرور وتأكيد كلمة المرور غير متطابقتين.";
    } else {
        // التحقق من وجود اسم المستخدم مسبقاً
        $check_username_sql = "SELECT user_id FROM users WHERE username = ?";
        $check_username_stmt = $conn->prepare($check_username_sql);
        $check_username_stmt->bind_param("s", $username);
        $check_username_stmt->execute();
        $check_username_result = $check_username_stmt->get_result();
        
        if ($check_username_result->num_rows > 0) {
           $register_error = "اسم المستخدم هذا مُستخدم بالفعل، يرجى اختيار اسم مستخدم آخر.";
        } else {
           // تشفير كلمة المرور
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // إضافة المستخدم الجديد إلى قاعدة البيانات
            $sql = "INSERT INTO users (username, password, email, first_name, last_name, phone_number, role_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssi", $username, $hashed_password, $email, $first_name, $last_name, $phone_number, $role_id);

            if ($stmt->execute()) {
              $register_success = true;
               // إفراغ الحقول بعد نجاح التسجيل
               $_POST = array();
            } else {
                $register_error = "حدث خطأ أثناء التسجيل. يرجى المحاولة مرة أخرى.";
            }
              $stmt->close();
        }
        $check_username_stmt->close();
    }
}

// جلب الأدوار من قاعدة البيانات لعرضها في القائمة المنسدلة
$roles_sql = "SELECT role_id, role_name FROM roles";
$roles_result = $conn->query($roles_sql);
$roles = [];
if ($roles_result && $roles_result->num_rows > 0) {
    while ($row = $roles_result->fetch_assoc()) {
        $roles[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>إنشاء حساب جديد</title>
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
                <h2 class="text-3xl font-bold text-gray-800">إنشاء حساب جديد</h2>
                <p class="mt-2 text-gray-500">املأ البيانات لإنشاء حساب جديد في المنصة.</p>
            </div>
            <?php if ($register_success): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p class="font-bold">تم التسجيل بنجاح!</p>
                    <p>يمكنك الآن تسجيل الدخول باستخدام حسابك.</p>
                </div>
                 <?php else: ?>
            <form class="mt-8 space-y-6" method="post" action="register.php">
                <div class="rounded-md shadow-sm">
                   <div>
                        <label class="sr-only" for="username">اسم المستخدم</label>
                        <input type="text" name="username" id="username" autocomplete="username" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="اسم المستخدم" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" />
                    </div>
                    <div>
                         <label class="sr-only" for="password">كلمة المرور</label>
                        <input type="password" name="password" id="password" autocomplete="new-password" required
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="كلمة المرور" />
                    </div>
                    <div>
                        <label class="sr-only" for="confirm_password">تأكيد كلمة المرور</label>
                        <input type="password" name="confirm_password" id="confirm_password" autocomplete="new-password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="تأكيد كلمة المرور" />
                    </div>
                     <div>
                        <label class="sr-only" for="email">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" autocomplete="email" required
                             class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="البريد الإلكتروني" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                    </div>
                    <div>
                        <label class="sr-only" for="first_name">الاسم الأول</label>
                        <input type="text" name="first_name" id="first_name" autocomplete="given-name"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="الاسم الأول" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" />
                    </div>
                     <div>
                        <label class="sr-only" for="last_name">الاسم الأخير</label>
                        <input type="text" name="last_name" id="last_name" autocomplete="family-name"
                             class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="الاسم الأخير" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" />
                    </div>
                    <div>
                        <label class="sr-only" for="phone_number">رقم الهاتف</label>
                        <input type="tel" name="phone_number" id="phone_number" autocomplete="tel"
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900  focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm"
                            placeholder="رقم الهاتف" value="<?php echo isset($_POST['phone_number']) ? htmlspecialchars($_POST['phone_number']) : ''; ?>" />
                    </div>
                   <div>
                       <label class="block text-gray-700 font-bold mb-2" for="role_id">الدور</label>
                       <select name="role_id" id="role_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                           <?php foreach ($roles as $role): ?>
                               <option value="<?php echo $role['role_id']; ?>"
                                   <?php if (isset($_POST['role_id']) && $_POST['role_id'] == $role['role_id']) echo 'selected'; ?>>
                                    <?php echo $role['role_name']; ?>
                               </option>
                           <?php endforeach; ?>
                         </select>
                   </div>
                </div>
               
                <?php if ($register_error) { ?>
                <p class="text-red-500 text-center"><?php echo $register_error; ?></p>
                <?php } ?>
                <div>
                   <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        إنشاء حساب
                    </button>
                </div>
                <div class="text-center mt-4">
                     <a href="login.php" class="text-blue-600 hover:underline">لديك حساب بالفعل؟ تسجيل الدخول</a>
                </div>
            </form>
             <?php endif; ?>
        </div>
    </div>
</body>

</html>
<?php $conn->close(); ?>
