<?php

session_start();

// فحص وجود الجلسة
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // توجيه المستخدم غير المسجل إلى صفحة تسجيل الدخول
    exit();
}

// فحص دور المستخدم
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // توجيه المستخدم غير الأدمن إلى الصفحة الرئيسية
    exit();
}


// الاتصال بقاعدة البيانات
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

// استقبال district_id من الرابط
$district_id = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;


// معالجة عمليات الإضافة والتعديل والحذف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'add') {
            $name = $_POST['name'];
            $distanceFromDistrictCenter = $_POST['distanceFromDistrictCenter'];
             $imageUrl = $_POST['imageUrl']; // استلام رابط الصورة

            $sql = "INSERT INTO ResidentialSquares (Name, DistanceFromDistrictCenter, DistrictID, ImageURL) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdis", $name, $distanceFromDistrictCenter, $district_id, $imageUrl);
            $stmt->execute();
              header("Location: residential_squares.php?district_id=" . $district_id);
            exit();

        }
        if ($action == 'edit') {
            $squareId = $_POST['squareId'];
            $name = $_POST['name'];
            $distanceFromDistrictCenter = $_POST['distanceFromDistrictCenter'];
              $imageUrl = $_POST['imageUrl']; // استلام رابط الصورة
            $sql = "UPDATE ResidentialSquares SET Name = ?, DistanceFromDistrictCenter = ?, ImageURL = ? WHERE SquareID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdsi", $name, $distanceFromDistrictCenter, $imageUrl, $squareId);
            $stmt->execute();
              header("Location: residential_squares.php?district_id=" . $district_id);
            exit();
        }
         if ($action == 'delete') {
            $squareId = $_POST['squareId'];
            $sql = "DELETE FROM ResidentialSquares WHERE SquareID = ?";
            $stmt = $conn->prepare($sql);
             $stmt->bind_param("i", $squareId);
             $stmt->execute();
               header("Location: residential_squares.php?district_id=" . $district_id);
             exit();
        }
    }
}


// استعلام لاسترجاع بيانات المربعات السكنية الخاصة بالمديرية المحددة
$sql = "SELECT SquareID, Name, DistanceFromDistrictCenter, ImageURL FROM ResidentialSquares WHERE DistrictID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $district_id);
$stmt->execute();
$result = $stmt->get_result();


// استعلام لاسترجاع اسم المديرية
$district_sql = "SELECT Name FROM Districts WHERE DistrictID = ?";
$district_stmt = $conn->prepare($district_sql);
$district_stmt->bind_param("i", $district_id);
$district_stmt->execute();
$district_result = $district_stmt->get_result();

if ($district_result->num_rows > 0) {
    $district_row = $district_result->fetch_assoc();
    $district_name = $district_row['Name'];
} else {
    $district_name = "غير محددة";
}

?>

<!DOCTYPE html>

<html lang="ar">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>منصة السياحة في تعز</title>
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

<div class="bg-white p-4 shadow-lg relative z-0">
    <div class="container mx-auto">
        <div class="relative">
            <input class="p-2 w-full rounded-lg text-black" placeholder="ابحث عن مربع سكني..." type="text" />
            <button class="absolute right-2 top-2 text-gray-600">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>
<main class="container mx-auto p-4">
     <div class="flex justify-between items-center mb-4">
         <h2 class="text-3xl font-bold">
          استكشف المربعات السكنية في مديرية <?php echo $district_name; ?>
         </h2>
          <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
           <i class="fas fa-arrow-left mr-2"></i>عودة للمديريات
         </a>
         <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="openAddPopup()">
            <i class="fas fa-plus mr-2"></i>إضافة مربع سكني
         </button>
     </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $square_id = $row["SquareID"];
                $square_name = $row["Name"];
                $distance_from_center = $row["DistanceFromDistrictCenter"];
                  $image_url = $row["ImageURL"];

                if (empty($image_url)) {
                $image_url = "https://placehold.co/300x200"; // استخدام صورة افتراضية إذا لم يكن هناك رابط
                }
                echo '<div class="bg-white rounded-lg shadow-lg overflow-hidden relative">';
                echo '<img alt="صورة مصغرة لمربع سكني في مديرية ' . $district_name . '" class="w-full h-48 object-cover" height="200" src="' . $image_url . '" width="300"/>';
                echo '<div class="p-4">';
                echo '<h3 class="text-xl font-bold mb-2">' . $square_name . '</h3>';
                 echo '<div class="flex space-x-2">';
                echo '<button class="bg-blue-600 text-white px-4 py-2 rounded-lg explore-button" data-square-id="' . $square_id . '">استكشاف</button>';
                   echo ' <button class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded" onclick="openEditPopup(' . $square_id . ')">';
                echo '<i class="fas fa-edit"></i>';
                echo '</button>';
                echo '<button class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded" onclick="deleteSquare(' . $square_id . ')">';
                echo '<i class="fas fa-trash-alt"></i>';
                echo '</button>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "لا توجد مربعات سكنية متاحة في هذه المديرية.";
        }
        ?>
    </div>
</main>
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" id="popup-modal">
    <div
        class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 max-h-screen overflow-y-auto transform transition-all duration-300 ease-in-out relative">
       <button class="absolute top-2 right-2 text-gray-600 text-2xl" onclick="closePopup()">
         <i class="fas fa-times"></i>
       </button>
        <div class="p-4">
            <h3 class="text-2xl font-bold mb-2" id="popup-title"></h3>
            <img alt="صورة بانر كبيرة للمربع السكني" class="w-full h-64 object-cover mb-4" height="400" id="popup-image"
                src="https://storage.googleapis.com/a1aa/image/gai3uq3sXFonCpXYou7hBJu2bsIjaYDTexmOwnM7SPdvdoAKA.jpg"
                width="600" />
            <p class="text-gray-700 mb-4" id="popup-description"></p>
            <h4 class="text-xl font-bold mb-2">
                الفنادق الموجودة
            </h4>
            <div class="grid grid-cols-2 gap-2 mb-4" id="popup-hotels">
            </div>
            <h4 class="text-xl font-bold mb-2">
                المطاعم الموجودة
            </h4>
            <div class="grid grid-cols-2 gap-2 mb-4" id="popup-restaurants">
            </div>
            <h4 class="text-xl font-bold mb-2">
                الأماكن الترفيهية
            </h4>
            <div class="grid grid-cols-2 gap-2 mb-4" id="popup-entertainment">
            </div>
            <h4 class="text-xl font-bold mb-2">
                خدمات إضافية
            </h4>
            <div class="grid grid-cols-2 gap-2 mb-4" id="popup-services">
            </div>
            <p class="text-gray-700 mb-4" id="popup-distance"></p>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-2" onclick="exploreServices()">
                استكشف الخدمات المتاحة
            </button>

        </div>
    </div>
</div>

 <!-- Modal for add & edit -->

<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" id="form-modal">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 max-h-screen overflow-y-auto transform transition-all duration-300 ease-in-out relative">
        <button class="absolute top-2 right-2 text-gray-600 text-2xl" onclick="closeFormPopup()">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-2xl font-bold mb-4" id="form-title"></h3>
        <form id="square-form" method="POST">
            <input type="hidden" name="action" id="form-action">
            <input type="hidden" name="squareId" id="form-squareId">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">اسم المربع السكني:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="distanceFromDistrictCenter" class="block text-gray-700 font-bold mb-2">المسافة من مركز المديرية (كم):</label>
                <input type="number" name="distanceFromDistrictCenter" id="distanceFromDistrictCenter" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
             <div class="mb-4">
                <label for="imageUrl" class="block text-gray-700 font-bold mb-2">رابط الصورة:</label>
                <input type="text" name="imageUrl" id="imageUrl" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
             <div class="flex justify-between items-center">
                  <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">حفظ</button>
                      <button type="button" id="manage-services-btn" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded hidden" >إدارة الخدمات</button>
               </div>
        </form>
    </div>
</div>
    <script>
        function toggleMenu() {
            const menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        }

document.addEventListener('DOMContentLoaded', () => {
        const exploreButtons = document.querySelectorAll('.explore-button');
        exploreButtons.forEach(button => {
            button.addEventListener('click', () => {
                const squareId = button.getAttribute('data-square-id');
                openPopup(squareId);
            });
        });
    });
    
    function openPopup(squareId) {
        const title = document.getElementById('popup-title');
        const image = document.getElementById('popup-image');
        const description = document.getElementById('popup-description');
        const hotels = document.getElementById('popup-hotels');
        const restaurants = document.getElementById('popup-restaurants');
        const entertainment = document.getElementById('popup-entertainment');
        const services = document.getElementById('popup-services');
        const distance = document.getElementById('popup-distance');

        // استخدم AJAX للحصول على بيانات المربع السكني
        fetch('get_square_data.php?square_id=' + squareId)
            .then(response => response.json())
            .then(data => {
                title.textContent = data.square_name;
                image.src = data.square_image;
                image.alt = 'صورة بانر كبيرة لمربع ' + data.square_name;
                description.textContent = 'نبذة تعريفية عن مربع ' + data.square_name;
                hotels.innerHTML = data.hotels_html;
                restaurants.innerHTML = data.restaurants_html;
                entertainment.innerHTML = data.entertainment_html;
                services.innerHTML = data.services_html;
                distance.textContent = 'المسافة من مركز المديرية: ' + data.distance + ' كم';
                 document.getElementById('popup-modal').setAttribute('data-square-id', squareId);
                document.getElementById('popup-modal').classList.remove('hidden');
            });
    }

    function closePopup() {
        document.getElementById('popup-modal').classList.add('hidden');
    }

function exploreServices() {
 const squareId = document.querySelector('#popup-modal').getAttribute('data-square-id');
window.location.href = `services.php?square_id=${squareId}`;
}

function openAddPopup() {
document.getElementById('form-title').textContent = 'إضافة مربع سكني جديد';
document.getElementById('form-action').value = 'add';
document.getElementById('square-form').reset();
document.getElementById('form-modal').classList.remove('hidden');
document.getElementById('manage-services-btn').classList.add('hidden');
}

function openEditPopup(squareId) {
        document.getElementById('form-title').textContent = 'تعديل المربع السكني';
        document.getElementById('form-action').value = 'edit';
        document.getElementById('form-squareId').value = squareId;
             document.getElementById('manage-services-btn').classList.remove('hidden');
             document.getElementById('manage-services-btn').setAttribute('data-square-id', squareId);
             document.getElementById('manage-services-btn').onclick = function() {
                 window.location.href = `services.php?square_id=${squareId}`;
            }
          fetchSquareData(squareId).then(data => {
              document.getElementById('name').value = data.name;
                document.getElementById('distanceFromDistrictCenter').value = data.distanceFromDistrictCenter;
                document.getElementById('imageUrl').value = data.imageUrl; // تعيين قيمة رابط الصورة في حقل الإدخال
                document.getElementById('form-modal').classList.remove('hidden');
        });
}
  function deleteSquare(squareId) {
       if (confirm('هل أنت متأكد أنك تريد حذف هذا المربع السكني؟')) {
          const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
             actionInput.value = 'delete';
             const squareIdInput = document.createElement('input');
            squareIdInput.type = 'hidden';
            squareIdInput.name = 'squareId';
            squareIdInput.value = squareId;
              form.appendChild(actionInput);
              form.appendChild(squareIdInput);
              document.body.appendChild(form);
               form.submit();
            }
    }

async function fetchSquareData(squareId) {
    try {
        const response = await fetch(`get_square_data_edit.php?square_id=${squareId}`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Failed to fetch square data:', error);
        throw error;
    }
}

   function closeFormPopup() {
        document.getElementById('form-modal').classList.add('hidden');
    }
</script>

</body>
</html>
<?php
$conn->close();
?>
