<?php
// تضمين ملف الاتصال بقاعدة البيانات
include 'db_connect.php';

// دالة لجلب جميع الخدمات (فنادق، مطاعم، سيارات، أنشطة) من جميع المربعات السكنية

// جلب جميع الخدمات
$hotels = getAllServices($conn, 'hotels');
$restaurants = getAllServices($conn, 'restaurants');
$cars = getAllServices($conn, 'cars');
$activities = getAllServices($conn, 'activities');
$packages = getAllServices($conn, 'packages');

?>
aa
bb
cc

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جميع الخدمات</title>
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
        <h2 class="text-3xl font-bold mb-4">جميع الخدمات المتاحة في محافظة تعز</h2>
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
                         <?php
                            $imageUrl = !empty($hotel['ImageUrl']) ? $hotel['ImageUrl'] : "https://fakeimg.pl/600x400?text=" . urlencode($hotel['service_name']) ;
                         ?>
                        <div class="bg-gray-50 rounded-lg shadow-md p-2">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo $hotel['service_name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                            <h3 class="text-xl font-semibold mb-1"><?php echo $hotel['service_name']; ?></h3>
                           <p class="text-gray-600 mb-1"><?php echo substr($hotel['RoomTypes'],0, 100) . '...'; ?></p>
                           <p class="text-gray-700 mb-2">المربع السكني: <?php echo $hotel['SquareName']; ?></p>
                           <div class="mt-2">
                             <a href="service_details.php?service_type=hotel&service_id=<?php echo $hotel['HotelID']; ?>&square_id=<?php echo $hotel['SquareID']; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-block">عرض التفاصيل</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="restaurants" class="tab-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($restaurants as $restaurant): ?>
                         <?php
                            $imageUrl = !empty($restaurant['ImageUrl']) ? $restaurant['ImageUrl'] : "https://fakeimg.pl/600x400?text=" . urlencode($restaurant['service_name']);
                         ?>
                        <div class="bg-gray-50 rounded-lg shadow-md p-2">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo $restaurant['service_name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                            <h3 class="text-xl font-semibold mb-1"><?php echo $restaurant['service_name']; ?></h3>
                           <p class="text-gray-600 mb-1"><?php echo substr($restaurant['Menu'],0, 100) . '...'; ?></p>
                           <p class="text-gray-700 mb-2">المربع السكني: <?php echo $restaurant['SquareName']; ?></p>
                             <div class="mt-2">
                             <a href="service_details.php?service_type=restaurant&service_id=<?php echo $restaurant['RestaurantID']; ?>&square_id=<?php echo $restaurant['SquareID']; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-block">عرض التفاصيل</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="cars" class="tab-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($cars as $car): ?>
                         <?php
                            $imageUrl = !empty($car['ImageUrl']) ? $car['ImageUrl'] : "https://fakeimg.pl/600x400?text=" . urlencode($car['service_name']);
                         ?>
                        <div class="bg-gray-50 rounded-lg shadow-md p-2">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo $car['service_name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                            <h3 class="text-xl font-semibold mb-1"><?php echo $car['service_name']; ?></h3>
                             <p class="text-gray-600 mb-1"><?php echo "نوع السيارة: " . $car['Type'] . "<br> سعر الإيجار لليوم: " . $car['RentalPerDay'];  ?></p>
                            <p class="text-gray-700 mb-2">المربع السكني: <?php echo $car['SquareName']; ?></p>
                            <div class="mt-2">
                                  <a href="service_details.php?service_type=car&service_id=<?php echo $car['CarID']; ?>&square_id=<?php echo $car['SquareID']; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-block">عرض التفاصيل</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div id="activities" class="tab-content">
               <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php foreach ($activities as $activity): ?>
                         <?php
                            $imageUrl = !empty($activity['ImageUrl']) ? $activity['ImageUrl'] : "https://fakeimg.pl/600x400?text=" . urlencode($activity['service_name']);
                         ?>
                       <div class="bg-gray-50 rounded-lg shadow-md p-2">
                           <img src="<?php echo $imageUrl; ?>" alt="<?php echo $activity['service_name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                            <h3 class="text-xl font-semibold mb-1"><?php echo $activity['service_name']; ?></h3>
                            <p class="text-gray-600 mb-1"><?php echo substr($activity['Description'],0, 100) . '...'; ?></p>
                            <p class="text-gray-700 mb-2">المربع السكني: <?php echo $activity['SquareName']; ?></p>
                             <div class="mt-2">
                                <a href="service_details.php?service_type=activity&service_id=<?php echo $activity['PlaceID']; ?>&square_id=<?php echo $activity['SquareID']; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-block">عرض التفاصيل</a>
                              </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
              <div id="packages" class="tab-content">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <?php if(!empty($packages)):?>
                    <?php foreach ($packages as $package): ?>
                       <?php
                            $imageUrl = !empty($package['ImageUrl']) ? $package['ImageUrl'] : "https://fakeimg.pl/600x400?text=" . urlencode($package['service_name']);
                         ?>
                        <div class="bg-gray-50 rounded-lg shadow-md p-2">
                            <img src="<?php echo $imageUrl; ?>" alt="<?php echo $package['Name']; ?>" class="w-full h-48 object-cover mb-2 rounded-md">
                             <h3 class="text-xl font-semibold mb-1"><?php echo $package['Name']; ?></h3>
                             <p class="text-gray-600 mb-1"><?php echo substr($package['Description'],0, 100) . '...'; ?></p>
                            <p class="text-gray-700 mb-2">المربع السكني: <?php echo $package['SquareName']; ?></p>
                            <div class="mt-2">
                                <a href="service_details.php?service_type=package&service_id=<?php echo $package['PackageID']; ?>&square_id=<?php echo $package['SquareID']; ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 inline-block">عرض التفاصيل</a>
                            </div>
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
