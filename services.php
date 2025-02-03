<?php
// تضمين ملف الاتصال بقاعدة البيانات
include 'db_connect.php';

// الحصول على مربع السكني من خلال url
$square_id = isset($_GET['square_id']) ? intval($_GET['square_id']) : 1;

if ($square_id == 0) {
    die("يجب تحديد مربع سكني");
}

// دالة لجلب الخدمات (فنادق، مطاعم، سيارات، أنشطة)
function getServices($conn, $square_id, $serviceType)
{
    $table = '';
    $priceField = '';
    $imageField = 'MainImageURL'; // Default image field
    $idField = '';


    switch ($serviceType) {
        case 'hotels':
            $table = 'Hotels';
            $priceField = 'RoomPrice';
            $idField = 'HotelID';
            break;
        case 'restaurants':
            $table = 'Restaurants';
            $priceField = 'Prices';
             $idField = 'RestaurantID';
            break;
        case 'cars':
            $table = 'Cars';
            $priceField = 'RentalPrice';
             $idField = 'CarID';
             break;
        case 'activities':
            $table = 'EntertainmentPlaces';
            $priceField = 'TicketPrice';
             $idField = 'PlaceID';
            break;
        case 'packages':
            return [];
        default:
            return [];
    }

    if ($serviceType == 'packages') {
        return [];
    } else {
        $sql = "SELECT *, {$priceField} as price, {$imageField} as ImageUrl FROM {$table} WHERE SquareID = ?";

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
                    <div class="bg-gray-50 rounded-lg shadow-md p-2">
                         <img src="<?php echo $hotel['ImageUrl']; ?>" alt="<?php echo $hotel['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                        <h3 class="text-xl font-semibold mb-1"><?php echo $hotel['Name']; ?></h3>
                        <p class="text-gray-600 mb-2"><?php echo substr($hotel['RoomTypes'],0, 100) . '...'; ?></p>
                         <a href="service_details.php?service_type=hotel&service_id=<?php echo $hotel['HotelID']; ?>&square_id=<?php echo $square_id; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</a>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
            <div id="restaurants" class="tab-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($restaurants as $restaurant): ?>
                    <div class="bg-gray-50 rounded-lg shadow-md p-2">
                         <img src="<?php echo $restaurant['ImageUrl']; ?>" alt="<?php echo $restaurant['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                        <h3 class="text-xl font-semibold mb-1"><?php echo $restaurant['Name']; ?></h3>
                        <p class="text-gray-600 mb-2"><?php echo substr($restaurant['Menu'],0, 100) . '...'; ?></p>
                       <a href="service_details.php?service_type=restaurant&service_id=<?php echo $restaurant['RestaurantID']; ?>&square_id=<?php echo $square_id; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</a>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
            <div id="cars" class="tab-content">
                 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($cars as $car): ?>
                         <div class="bg-gray-50 rounded-lg shadow-md p-2">
                             <img src="<?php echo $car['ImageUrl']; ?>" alt="<?php echo $car['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                            <h3 class="text-xl font-semibold mb-1"><?php echo $car['Name']; ?></h3>
                             <p class="text-gray-600 mb-2"><?php echo "نوع السيارة: " . $car['Type'] . "<br> سعر الإيجار لليوم: " . $car['RentalPrice'];  ?></p>
                           <a href="service_details.php?service_type=car&service_id=<?php echo $car['CarID']; ?>&square_id=<?php echo $square_id; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</a>
                        </div>
                    <?php endforeach; ?>
                 </div>
            </div>
            <div id="activities" class="tab-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($activities as $activity): ?>
                    <div class="bg-gray-50 rounded-lg shadow-md p-2">
                            <img src="<?php echo $activity['ImageUrl']; ?>" alt="<?php echo $activity['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                           <h3 class="text-xl font-semibold mb-1"><?php echo $activity['Name']; ?></h3>
                           <p class="text-gray-600 mb-2"><?php echo substr($activity['Description'],0, 100) . '...'; ?></p>
                            <a href="service_details.php?service_type=activity&service_id=<?php echo $activity['PlaceID']; ?>&square_id=<?php echo $square_id; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">عرض التفاصيل</a>
                     </div>
                 <?php endforeach; ?>
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
</script>
</body>
</html>
