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


// تضمين ملف الاتصال بقاعدة البيانات
include 'db_connect.php';

// الحصول على مربع السكني من خلال url
$square_id = isset($_GET['square_id']) ? intval($_GET['square_id']) : 1;

if ($square_id == 0) {
    die("يجب تحديد مربع سكني");
}

// معالجة عمليات الإضافة والتعديل والحذف
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $serviceType = $_POST['serviceType'];

        if($serviceType == 'hotels'){
          $table = 'Hotels';
          $idField = 'HotelID';
          $priceField = 'RoomPrice';
          $nameField = 'Name';
          $typeField = 'RoomTypes';
            $imageField = 'MainImageURL';
        } elseif($serviceType == 'restaurants'){
            $table = 'Restaurants';
           $idField = 'RestaurantID';
          $priceField = 'BookingPrice';
           $nameField = 'Name';
            $typeField = 'Menu';
               $imageField = 'MainImageURL';

        }  elseif($serviceType == 'cars'){
           $table = 'Cars';
          $idField = 'CarID';
           $priceField = 'RentalPrice';
           $nameField = 'Name';
           $typeField = 'Type';
              $imageField = 'MainImageURL';
        } elseif($serviceType == 'activities'){
            $table = 'EntertainmentPlaces';
           $idField = 'PlaceID';
           $priceField = 'TicketPrice';
            $nameField = 'Name';
           $typeField = 'Description';
             $imageField = 'MainImageURL';
      }

        if ($action == 'add') {
            $name = $_POST['name'];
           $type = $_POST['type'];
            $price = $_POST['price'];
             $imageUrl = $_POST['image_url'];

           $sql = "INSERT INTO {$table} (Name, {$typeField}, {$priceField}, SquareID, {$imageField}) VALUES (?, ?, ?, ?, ?)";
           $stmt = $conn->prepare($sql);
           $stmt->bind_param("ssdis", $name, $type, $price, $square_id, $imageUrl);
            $stmt->execute();
           header("Location: services.php?square_id=" . $square_id);
            exit();

        }
        if ($action == 'edit') {
             $id = $_POST['id'];
            $name = $_POST['name'];
           $type = $_POST['type'];
           $price = $_POST['price'];
           $imageUrl = $_POST['image_url'];

           $sql = "UPDATE {$table} SET Name = ?, {$typeField} = ?, {$priceField} = ?, {$imageField} = ? WHERE {$idField} = ?";
           $stmt = $conn->prepare($sql);
             $stmt->bind_param("ssdsi", $name, $type, $price, $imageUrl, $id);
             $stmt->execute();


            header("Location: services.php?square_id=" . $square_id);
            exit();
        }
         if ($action == 'delete') {
             $id = $_POST['id'];
             $sql = "DELETE FROM {$table} WHERE {$idField} = ?";
             $stmt = $conn->prepare($sql);
              $stmt->bind_param("i", $id);
             $stmt->execute();
              header("Location: services.php?square_id=" . $square_id);
            exit();
        }
    }
}

// دالة لجلب الخدمات (فنادق، مطاعم، سيارات، أنشطة)
function getServices($conn, $square_id, $serviceType)
{
    $table = '';
    switch ($serviceType) {
        case 'hotels':
            $table = 'Hotels';
            break;
        case 'restaurants':
            $table = 'Restaurants';
            break;
        case 'cars':
            $table = 'Cars';
            break;
        case 'activities':
            $table = 'EntertainmentPlaces';
            break;
        case 'packages':
            //   $table = 'Packages';
            return []; // لن يتم العمل عليها حاليا
        default:
            return [];
    }

    if ($serviceType == 'packages') {
        return []; // لا توجد باقات حاليا
    } else {
        $sql = "SELECT * FROM {$table} WHERE SquareID = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo "SQL Error: " . $conn->error;
            echo "<br> SQL: {$sql} <br>";
            return [];
        }

        $stmt->bind_param("i", $square_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $services = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $services[] = $row;
            }
        }
        return $services;
    }
}

//جلب المربع السكني
$sql_square = "SELECT * from ResidentialSquares WHERE SquareID = ?";
$stmt_square = $conn->prepare($sql_square);
$stmt_square->bind_param("i", $square_id);
$stmt_square->execute();
$result_square = $stmt_square->get_result();
$square = $result_square->fetch_assoc();

// جلب الخدمات
$hotels = getServices($conn, $square_id, 'hotels');
$restaurants = getServices($conn, $square_id, 'restaurants');
$cars = getServices($conn, $square_id, 'cars');
$activities = getServices($conn, $square_id, 'activities');
$packages = getServices($conn, $square_id, 'packages');

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الخدمات والحجز</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">
    
<?php include 'side_bar.php'; ?>

    <main class="container mx-auto p-4">
        <h2 class="text-3xl font-bold mb-4">الخدمات المتاحة في مربع سكني <?php echo $square['Name']; ?></h2>
         <a href="residential_squares.php?district_id=<?php echo $square['DistrictID']; ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
             <i class="fas fa-arrow-left mr-2"></i>عودة للمربعات السكنية
        </a>
        <div class="bg-white rounded-lg shadow-lg p-4">
            <div class="mb-4 border-b border-gray-300">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                    <li class="mr-2">
                        <button class="inline-block p-4 border-b-2 border-transparent hover:border-blue-600 focus:border-blue-600 active-tab" data-tab="hotels">الفنادق</button>
                    </li>
                    <li class="mr-2">
                        <button class="inline-block p-4 border-b-2 border-transparent hover:border-blue-600 focus:border-blue-600" data-tab="restaurants">المطاعم</button>
                    </li>
                    <li class="mr-2">
                        <button class="inline-block p-4 border-b-2 border-transparent hover:border-blue-600 focus:border-blue-600" data-tab="cars">تأجير السيارات</button>
                    </li>
                    <li class="mr-2">
                        <button class="inline-block p-4 border-b-2 border-transparent hover:border-blue-600 focus:border-blue-600" data-tab="activities">الأنشطة الترفيهية</button>
                    </li>
                    <li class="mr-2">
                        <button class="inline-block p-4 border-b-2 border-transparent hover:border-blue-600 focus:border-blue-600" data-tab="packages">الباقات السياحية</button>
                    </li>
                </ul>
            </div>
             <div id="hotels" class="tab-content active">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($hotels as $hotel): ?>
                    <div class="bg-gray-50 rounded-lg shadow-md p-2 relative">
                         <img src="<?php echo $hotel['MainImageURL']; ?>" alt="<?php echo $hotel['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                        <h3 class="text-xl font-semibold mb-1"><?php echo $hotel['Name']; ?></h3>
                        <p class="text-gray-600 mb-2"><?php echo substr($hotel['RoomTypes'],0, 100) . '...'; ?></p>
                         <a href="service_details.php?service_type=hotel&service_id=<?php echo $hotel['HotelID']; ?>&square_id=<?php echo $square_id; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</a>
                         <div class="absolute top-2 left-2">
                            <button class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded" onclick="openEditPopup('hotels', <?php echo $hotel['HotelID']; ?>)">
                                 <i class="fas fa-edit"></i>
                            </button>
                            <button class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded" onclick="deleteService('hotels', <?php echo $hotel['HotelID']; ?>)">
                                 <i class="fas fa-trash-alt"></i>
                             </button>
                         </div>
                    </div>
                <?php endforeach; ?>
                 <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded fixed bottom-4 right-4" onclick="openAddPopup('hotels')">
                  <i class="fas fa-plus mr-2"></i>إضافة فندق
               </button>
                </div>
            </div>
            <div id="restaurants" class="tab-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($restaurants as $restaurant): ?>
                    <div class="bg-gray-50 rounded-lg shadow-md p-2 relative">
                         <img src="<?php echo $restaurant['MainImageURL']; ?>" alt="<?php echo $restaurant['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                        <h3 class="text-xl font-semibold mb-1"><?php echo $restaurant['Name']; ?></h3>
                        <p class="text-gray-600 mb-2"><?php echo substr($restaurant['Menu'],0, 100) . '...'; ?></p>
                       <a href="service_details.php?service_type=restaurant&service_id=<?php echo $restaurant['RestaurantID']; ?>&square_id=<?php echo $square_id; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</a>
                         <div class="absolute top-2 left-2">
                            <button class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded" onclick="openEditPopup('restaurants', <?php echo $restaurant['RestaurantID']; ?>)">
                                 <i class="fas fa-edit"></i>
                            </button>
                            <button class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded" onclick="deleteService('restaurants', <?php echo $restaurant['RestaurantID']; ?>)">
                                 <i class="fas fa-trash-alt"></i>
                             </button>
                         </div>
                    </div>
                <?php endforeach; ?>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded fixed bottom-4 right-4" onclick="openAddPopup('restaurants')">
                  <i class="fas fa-plus mr-2"></i>إضافة مطعم
               </button>
                </div>
            </div>
            <div id="cars" class="tab-content">
                 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($cars as $car): ?>
                         <div class="bg-gray-50 rounded-lg shadow-md p-2 relative">
                              <img src="<?php echo $car['MainImageURL']; ?>" alt="<?php echo $car['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                            <h3 class="text-xl font-semibold mb-1"><?php echo $car['Name']; ?></h3>
                             <p class="text-gray-600 mb-2"><?php echo "نوع السيارة: " . $car['Type'] . "<br> سعر الإيجار لليوم: " . $car['RentalPrice'];  ?></p>
                           <a href="service_details.php?service_type=car&service_id=<?php echo $car['CarID']; ?>&square_id=<?php echo $square_id; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</a>
                            <div class="absolute top-2 left-2">
                                <button class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded" onclick="openEditPopup('cars', <?php echo $car['CarID']; ?>)">
                                 <i class="fas fa-edit"></i>
                                </button>
                                <button class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded" onclick="deleteService('cars', <?php echo $car['CarID']; ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                      <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded fixed bottom-4 right-4" onclick="openAddPopup('cars')">
                      <i class="fas fa-plus mr-2"></i>إضافة سيارة
                    </button>
                 </div>
            </div>
            <div id="activities" class="tab-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($activities as $activity): ?>
                    <div class="bg-gray-50 rounded-lg shadow-md p-2 relative">
                            <img src="<?php echo $activity['MainImageURL']; ?>" alt="<?php echo $activity['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                           <h3 class="text-xl font-semibold mb-1"><?php echo $activity['Name']; ?></h3>
                           <p class="text-gray-600 mb-2"><?php echo substr($activity['Description'],0, 100) . '...'; ?></p>
                            <a href="service_details.php?service_type=activity&service_id=<?php echo $activity['PlaceID']; ?>&square_id=<?php echo $square_id; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</a>
                            <div class="absolute top-2 left-2">
                                <button class="bg-yellow-500 hover:bg-yellow-700 text-white px-2 py-1 rounded" onclick="openEditPopup('activities', <?php echo $activity['PlaceID']; ?>)">
                                   <i class="fas fa-edit"></i>
                                </button>
                                <button class="bg-red-500 hover:bg-red-700 text-white px-2 py-1 rounded" onclick="deleteService('activities', <?php echo $activity['PlaceID']; ?>)">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                           </div>
                     </div>
                 <?php endforeach; ?>
                   <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded fixed bottom-4 right-4" onclick="openAddPopup('activities')">
                    <i class="fas fa-plus mr-2"></i>إضافة نشاط
                    </button>
                 </div>
            </div>
            <div id="packages" class="tab-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php if(!empty($packages)):?>
                <?php foreach ($packages as $package): ?>
                     <div class="bg-gray-50 rounded-lg shadow-md p-2">
                         <img src="https://placehold.co/300x200" alt="<?php echo $package['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                         <h3 class="text-xl font-semibold mb-1"><?php echo $package['Name']; ?></h3>
                        <p class="text-gray-600 mb-2"><?php echo substr($package['Description'],0, 100) . '...'; ?></p>
                       <a href="service_details.php?service_type=package&service_id=<?php echo $package['PackageID']; ?>&square_id=<?php echo $square_id; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</a>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-600 mb-2"> لا توجد باقات حاليا</p>
                <?php endif; ?>
                </div>
            </div>
        </div>
</main>
 <!-- Modal for add & edit -->
 <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" id="form-modal">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6 max-h-screen overflow-y-auto transform transition-all duration-300 ease-in-out relative">
        <button class="absolute top-2 right-2 text-gray-600 text-2xl" onclick="closeFormPopup()">
            <i class="fas fa-times"></i>
        </button>
        <h3 class="text-2xl font-bold mb-4" id="form-title"></h3>
        <form id="service-form" method="POST">
            <input type="hidden" name="action" id="form-action">
            <input type="hidden" name="id" id="form-id">
             <input type="hidden" name="serviceType" id="form-serviceType">
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">اسم الخدمة:</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
               <label for="type" class="block text-gray-700 font-bold mb-2">نوع الخدمة:</label>
                  <textarea name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
            </div>
             <div class="mb-4">
                  <label for="price" class="block text-gray-700 font-bold mb-2">السعر:</label>
                  <input type="number" step="0.01" name="price" id="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
             </div>
              <div class="mb-4">
                  <label for="image_url" class="block text-gray-700 font-bold mb-2">رابط الصورة:</label>
                   <input type="text" name="image_url" id="image_url" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
               </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">حفظ</button>
            </div>
        </form>
    </div>
</div>
<script>
    const tabs = document.querySelectorAll('[data-tab]');
    const tabContents = document.querySelectorAll('.tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.getAttribute('data-tab');
            tabs.forEach(t => t.classList.remove('active-tab'));
            tab.classList.add('active-tab');
            tabContents.forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(target).classList.add('active');
        });
    });
    function openAddPopup(serviceType) {
          document.getElementById('form-title').textContent = 'إضافة خدمة جديدة';
          document.getElementById('form-action').value = 'add';
          document.getElementById('form-serviceType').value = serviceType;
           document.getElementById('service-form').reset();
          document.getElementById('form-modal').classList.remove('hidden');
    }

   function openEditPopup(serviceType, id) {
         document.getElementById('form-title').textContent = 'تعديل الخدمة';
         document.getElementById('form-action').value = 'edit';
          document.getElementById('form-id').value = id;
           document.getElementById('form-serviceType').value = serviceType;
       fetchServiceData(serviceType, id).then(data => {
              document.getElementById('name').value = data.name;
              document.getElementById('type').value = data.type;
                document.getElementById('price').value = data.price;
                 document.getElementById('image_url').value = data.image_url || ''; // Set empty string if undefined
               document.getElementById('form-modal').classList.remove('hidden');
        });
    }

      function deleteService(serviceType, id) {
          if (confirm('هل أنت متأكد أنك تريد حذف هذه الخدمة؟')) {
             const form = document.createElement('form');
                form.method = 'POST';
                form.action = '';
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'action';
                actionInput.value = 'delete';
                  const serviceTypeInput = document.createElement('input');
                serviceTypeInput.type = 'hidden';
                serviceTypeInput.name = 'serviceType';
                 serviceTypeInput.value = serviceType;
                   const idInput = document.createElement('input');
                 idInput.type = 'hidden';
                idInput.name = 'id';
                idInput.value = id;
                form.appendChild(actionInput);
                 form.appendChild(serviceTypeInput);
                 form.appendChild(idInput);
                document.body.appendChild(form);
                form.submit();
           }
        }
async function fetchServiceData(serviceType, id) {
    try {
        const response = await fetch(`get_service_data.php?service_type=${serviceType}&id=${id}`);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
           }
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Failed to fetch service data:', error);
        throw error;
    }
}
    function closeFormPopup() {
        document.getElementById('form-modal').classList.add('hidden');
    }
</script>
</body>
</html>
