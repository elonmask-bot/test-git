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


// بيانات الاتصال بقاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_ter2";

// إنشاء اتصال بقاعدة البيانات
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال بقاعدة البيانات: " . $conn->connect_error);
}

// الحصول على DistrictID من الاستعلام
$districtID = isset($_GET['district_id']) ? intval($_GET['district_id']) : 0;

// معالجة عمليات الإضافة والتعديل والحذف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action == 'add') {
            $name = $_POST['name'];
            $description = $_POST['description'];
             $imageURL = $_POST['imageURL'];

            $sql = "INSERT INTO TouristAttractions (Name, Description, DistrictID, ImageURL) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssis", $name, $description, $districtID, $imageURL);
            $stmt->execute();
              header("Location: tourist_attractions.php?district_id=" . $districtID);
            exit();

        }
        if ($action == 'edit') {
            $attractionId = $_POST['attractionId'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $imageURL = $_POST['imageURL'];

            $sql = "UPDATE TouristAttractions SET Name = ?, Description = ?, ImageURL = ? WHERE AttractionID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $description, $imageURL, $attractionId);
            $stmt->execute();
              header("Location: tourist_attractions.php?district_id=" . $districtID);
            exit();
        }
         if ($action == 'delete') {
             $attractionId = $_POST['attractionId'];
             $sql = "DELETE FROM TouristAttractions WHERE AttractionID = ?";
            $stmt = $conn->prepare($sql);
             $stmt->bind_param("i", $attractionId);
             $stmt->execute();
              header("Location: tourist_attractions.php?district_id=" . $districtID);
            exit();
        }
    }
}

// استعلام لجلب بيانات المديرية
$sql_district = "SELECT * FROM Districts WHERE DistrictID = ?";
$stmt_district = $conn->prepare($sql_district);
$stmt_district->bind_param("i", $districtID);
$stmt_district->execute();
$result_district = $stmt_district->get_result();
$district = $result_district->fetch_assoc();


// استعلام لجلب جميع المعالم السياحية التابعة للمديرية
$sql = "SELECT * FROM TouristAttractions WHERE DistrictID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $districtID);
$stmt->execute();
$result = $stmt->get_result();

// تخزين المعالم السياحية في مصفوفة
$touristAttractions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $touristAttractions[] = $row;
    }
}

$stmt->close();
$stmt_district->close();
$conn->close();
?>

<html lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>إدارة المعالم السياحية - <?php echo $district['Name']; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet"/>
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
            <input class="p-2 w-full rounded-lg text-black" placeholder="ابحث عن معلم سياحي..." type="text"/>
            <button class="absolute right-2 top-2 text-gray-600">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>

<main class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-3xl font-bold">المعالم السياحية -  <?php echo $district['Name']; ?></h2>
         <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
            <i class="fas fa-arrow-left mr-2"></i>عودة للمديريات
        </a>
        <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" onclick="openAddPopup()">
            <i class="fas fa-plus mr-2"></i>إضافة معلم سياحي
        </button>

    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php if (count($touristAttractions) > 0) : ?>
        <?php foreach ($touristAttractions as $attraction): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden relative">
               <img alt="صورة المعلم السياحي <?php echo $attraction['Name']; ?>"
                     class="w-full h-48 object-cover" height="200"
                     src="<?php echo $attraction['ImageURL']; ?>" width="300">
                <div class="p-4">
                    <h3 class="text-xl font-bold mb-2"><?php echo $attraction['Name']; ?></h3>
                    <p class="text-gray-700 mb-4"><?php echo $attraction['Description']; ?></p>
                      <div class="flex space-x-2">
                        <button class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded" onclick="openEditPopup(<?php echo $attraction['AttractionID']; ?>)">
                           <i class="fas fa-edit"></i>
                        </button>
                       <button class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded" onclick="deleteAttraction(<?php echo $attraction['AttractionID']; ?>)">
                           <i class="fas fa-trash-alt"></i>
                       </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
         <?php else : ?>
           <div class="bg-white rounded-lg shadow-lg p-4 w-full">
            <p class="text-gray-700">لا يوجد معالم سياحية مضافة لهذه المديرية.</p>
        </div>
    <?php endif; ?>
    </div>
</main>

<!-- Modal for add & edit -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" id="form-modal">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 max-h-screen overflow-y-auto transform transition-all duration-300 ease-in-out relative">
        <button class="absolute top-2 right-2 text-gray-600 text-2xl" onclick="closeFormPopup()">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-2xl font-bold mb-4" id="form-title"></h3>
        <form id="attraction-form" method="POST">
            <input type="hidden" name="action" id="form-action">
            <input type="hidden" name="attractionId" id="form-attractionId">
              <input type="hidden" name="districtId" id="form-districtId" value="<?php echo $districtID; ?>">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">اسم المعلم السياحي:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">الوصف:</label>
                <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
            </div>
             <div class="mb-4">
                <label for="imageURL" class="block text-gray-700 font-bold mb-2">رابط الصورة:</label>
                <input type="url" name="imageURL" id="imageURL"  class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">حفظ</button>
            </div>
        </form>
    </div>
</div>
<script>
    function toggleMenu() {
        const menu = document.getElementById('menu');
        menu.classList.toggle('hidden');
    }

    function openAddPopup() {
        document.getElementById('form-title').textContent = 'إضافة معلم سياحي جديد';
        document.getElementById('form-action').value = 'add';
          document.getElementById('attraction-form').reset();
        document.getElementById('form-modal').classList.remove('hidden');
    }

    function openEditPopup(attractionId) {
        document.getElementById('form-title').textContent = 'تعديل المعلم السياحي';
        document.getElementById('form-action').value = 'edit';
        document.getElementById('form-attractionId').value = attractionId;

        fetchAttractionData(attractionId).then(data => {
            document.getElementById('name').value = data.name;
            document.getElementById('description').value = data.description;
             document.getElementById('imageURL').value = data.imageURL;
            document.getElementById('form-modal').classList.remove('hidden');
        });
    }

     function deleteAttraction(attractionId) {
          if (confirm('هل أنت متأكد أنك تريد حذف هذا المعلم السياحي؟')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'delete';
             const attractionIdInput = document.createElement('input');
            attractionIdInput.type = 'hidden';
            attractionIdInput.name = 'attractionId';
             attractionIdInput.value = attractionId;
            form.appendChild(actionInput);
            form.appendChild(attractionIdInput);
            document.body.appendChild(form);
            form.submit();
              }
        }


    async function fetchAttractionData(attractionId) {
        try {
            const response = await fetch(`get_attraction_data.php?attraction_id=${attractionId}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Failed to fetch attraction data:', error);
            throw error;
        }
    }


    function closeFormPopup() {
        document.getElementById('form-modal').classList.add('hidden');
    }
</script>

</body>
</html>
