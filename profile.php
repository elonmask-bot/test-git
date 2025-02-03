<?php
session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

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

$user_id = $_SESSION['user_id'];

// استعلام لجلب بيانات المستخدم
$sql = "SELECT username, email, first_name, last_name, phone_number FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
} else {
    echo "لم يتم العثور على بيانات المستخدم.";
    exit();
}

$update_error = "";
$update_success = false;
$password_error = "";
$password_success = false;
$show_password_modal = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
     if (isset($_POST['update_profile'])) {
        $new_username = $_POST['username'];
        $new_email = $_POST['email'];
        $new_first_name = $_POST['first_name'];
        $new_last_name = $_POST['last_name'];
        $new_phone_number = $_POST['phone_number'];

         // التحقق من عدم وجود اسم المستخدم أو البريد الإلكتروني مسبقًا لمستخدم آخر
        $check_sql = "SELECT user_id FROM users WHERE (username = ? OR email = ?) AND user_id != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("ssi", $new_username, $new_email, $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

         if ($check_result->num_rows > 0) {
            $update_error = "اسم المستخدم أو البريد الإلكتروني مسجل مسبقًا لمستخدم آخر.";
         } else{
        // تحديث بيانات المستخدم
        $update_sql = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, phone_number = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssssi", $new_username, $new_email, $new_first_name, $new_last_name, $new_phone_number, $user_id);

            if ($update_stmt->execute()) {
                 $_SESSION['username'] = $new_username;
                 $update_success = true;
            } else {
                $update_error = "حدث خطأ أثناء تحديث البيانات.";
            }
          $update_stmt->close();
        }
        $check_stmt->close();
    }
     if(isset($_POST['update_password'])){
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $show_password_modal = true;
         $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
             if (password_verify($current_password, $row['password'])) {
                if($new_password === $confirm_password){
                     $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $update_password_sql = "UPDATE users SET password = ? WHERE user_id = ?";
                     $update_password_stmt = $conn->prepare($update_password_sql);
                    $update_password_stmt->bind_param("si", $hashed_password, $user_id);
                     if($update_password_stmt->execute()){
                        $password_success = true;
                        $show_password_modal = false;
                     } else {
                        $password_error = "حدث خطأ أثناء تحديث كلمة المرور";
                    }
                    $update_password_stmt->close();
                } else{
                   $password_error = "كلمة المرور الجديدة غير متطابقة.";
                }
            } else {
               $password_error = "كلمة المرور الحالية غير صحيحة.";
            }
        } else{
            $password_error = "لم يتم العثور على المستخدم.";
        }
        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>الملف الشخصي</title>
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
    
<?php include 'side_bar.php'; ?>

    <main class="container mx-auto p-4">
        <h2 class="text-3xl font-bold mb-4">الملف الشخصي</h2>
         <?php if ($update_success) { ?>
           <p class="text-green-500 text-center mb-4">تم تحديث البيانات بنجاح.</p>
         <?php } ?>
        <?php if ($password_success) { ?>
           <p class="text-green-500 text-center mb-4">تم تحديث كلمة المرور بنجاح.</p>
        <?php } ?>
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="mb-4">
                <p class="text-gray-700"><strong>اسم المستخدم:</strong> <?php echo $user['username']; ?></p>
                <p class="text-gray-700"><strong>البريد الإلكتروني:</strong> <?php echo $user['email']; ?></p>
                <p class="text-gray-700"><strong>الاسم الأول:</strong> <?php echo $user['first_name']; ?></p>
                <p class="text-gray-700"><strong>اسم العائلة:</strong> <?php echo $user['last_name']; ?></p>
                <p class="text-gray-700"><strong>رقم الهاتف:</strong> <?php echo $user['phone_number']; ?></p>
            </div>
            <div class="flex items-center space-x-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg" onclick="openEditModal()">تعديل البيانات</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg" onclick="openPasswordModal()">تعديل كلمة المرور</button>
             </div>
        </div>
    </main>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" id="edit-modal">
        <div
            class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 max-h-screen overflow-y-auto transform transition-all duration-300 ease-in-out">
            <div class="p-4">
                <h3 class="text-2xl font-bold mb-2">تعديل البيانات الشخصية</h3>
                <form method="post" action="profile.php">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="username">اسم المستخدم</label>
                        <input type="text" name="username" id="username"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="<?php echo $user['username']; ?>" required />
                    </div>
                     <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="<?php echo $user['email']; ?>" required/>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="first_name">الاسم الأول</label>
                        <input type="text" name="first_name" id="first_name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="<?php echo $user['first_name']; ?>" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="last_name">اسم العائلة</label>
                        <input type="text" name="last_name" id="last_name"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="<?php echo $user['last_name']; ?>" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone_number">رقم الهاتف</label>
                        <input type="tel" name="phone_number" id="phone_number"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="<?php echo $user['phone_number']; ?>" />
                    </div>
                     <?php if ($update_error) { ?>
                      <p class="text-red-500 text-center mb-4"><?php echo $update_error; ?></p>
                     <?php } ?>
                    <div class="flex justify-end">
                    <button type="submit" name="update_profile"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg mr-2">حفظ التعديلات</button>
                        <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-lg"
                            onclick="closeEditModal()">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center <?php echo $show_password_modal ? '' : 'hidden'; ?>" id="password-modal">
         <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 max-h-screen overflow-y-auto transform transition-all duration-300 ease-in-out">
            <div class="p-4">
                 <h3 class="text-2xl font-bold mb-2">تعديل كلمة المرور</h3>
                 <form method="post" action="profile.php"  id="password-form">
                     <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="current_password">كلمة المرور الحالية</label>
                        <input type="password" name="current_password" id="current_password"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required />
                    </div>
                     <div class="mb-4">
                         <label class="block text-gray-700 text-sm font-bold mb-2" for="new_password">كلمة المرور الجديدة</label>
                         <input type="password" name="new_password" id="new_password"
                             class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                             required />
                      </div>
                      <div class="mb-4">
                           <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required />
                      </div>
                      <?php if ($password_error) { ?>
                         <p class="text-red-500 text-center mb-4" id="password-error"><?php echo $password_error; ?></p>
                       <?php } ?>
                    <div class="flex justify-end">
                        <button type="submit" name="update_password"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg mr-2">حفظ كلمة المرور</button>
                           <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-lg"
                              onclick="closePasswordModal()">إلغاء</button>
                   </div>
                </form>
            </div>
        </div>
    </div>
     <script>
        function toggleMenu() {
            const menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        }
         function openEditModal() {
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }
         function openPasswordModal() {
            document.getElementById('password-modal').classList.remove('hidden');
        }
        function closePasswordModal() {
            document.getElementById('password-modal').classList.add('hidden');
        }
       </script>
</body>

</html>
