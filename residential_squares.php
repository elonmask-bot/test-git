<?php
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
        <h2 class="text-3xl font-bold mb-4">
            استكشف المربعات السكنية في مديرية <?php echo $district_name; ?>
        </h2>
         <a href="index.php" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4 mr-2 inline-block">
           <i class="fas fa-arrow-left mr-2"></i>عودة للمديريات
         </a>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $square_id = $row["SquareID"];
                    $square_name = $row["Name"];
                    $distance_from_center = $row["DistanceFromDistrictCenter"];
                    $image_url = $row["ImageURL"];

                       if (empty($image_url)) {
                         $image_url = "https://placehold.co/300x200";
                        }


                    echo '<div class="bg-white rounded-lg shadow-lg overflow-hidden">';
                    echo '<img alt="صورة مصغرة لمربع سكني في مديرية ' . $district_name . '" class="w-full h-48 object-cover" height="200" src="' . $image_url . '" width="300"/>';
                    echo '<div class="p-4">';
                    echo '<h3 class="text-xl font-bold mb-2">' . $square_name . '</h3>';
                    echo '<button class="bg-blue-600 text-white px-4 py-2 rounded-lg explore-button" data-square-id="' . $square_id . '">استكشاف</button>';
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
            class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 max-h-screen overflow-y-auto transform transition-all duration-300 ease-in-out">
            <div class="p-4">
                <h3 class="text-2xl font-bold mb-2" id="popup-title"></h3>
                <img alt="صورة بانر كبيرة للمربع السكني" class="w-full h-64 object-cover mb-4" height="400" id="popup-image"
                    src="https://placehold.co/600x400"
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
                 <div class="flex justify-between">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg" onclick="exploreServices()">
                            استكشف الخدمات المتاحة
                         </button>
                       <button class="bg-gray-600 text-white px-4 py-2 rounded-lg" onclick="closePopup()">
                        إغلاق
                      </button>
                  </div>

            </div>
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

    </script>
</body>
</html>
<?php
$conn->close();
?>
