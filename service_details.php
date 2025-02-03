<?php
session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// تضمين ملف الاتصال بقاعدة البيانات
include 'db_connect.php';

// الحصول على نوع الخدمة ورقمها من خلال URL
$serviceType = isset($_GET['service_type']) ? $_GET['service_type'] : '';
$serviceID = isset($_GET['service_id']) ? intval($_GET['service_id']) : 0;
$square_id = isset($_GET['square_id']) ? intval($_GET['square_id']) : 1;

if ($serviceType == '' || $serviceID == 0 || $square_id == 0) {
    die("معلومات الخدمة غير صحيحة");
}

// دالة لجلب معلومات الخدمة بناءً على نوعها
function getServiceDetails($conn, $square_id, $serviceType, $serviceID) {
    $table = '';
    $idField = '';
    $priceField = '';
    $imageField = 'MainImageURL'; // الصورة الرئيسية هي الافتراضية
    switch ($serviceType) {
        case 'hotel':
            $table = 'Hotels';
            $idField = 'HotelID';
            $priceField = 'RoomPrice';
            break;
        case 'restaurant':
            $table = 'Restaurants';
            $idField = 'RestaurantID';
            $priceField = 'BookingPrice';
            break;
        case 'car':
            $table = 'Cars';
            $idField = 'CarID';
            $priceField = 'RentalPrice';
              $imageField = 'MainImageURL'; // استخدام mainImageUrl كصورة رئيسية
            break;
        case 'activity':
            $table = 'EntertainmentPlaces';
            $idField = 'PlaceID';
            $priceField = 'TicketPrice';
            break;
        case 'package':
            $table = 'Packages';
            $idField = 'PackageID';
            return []; // لن يتم العمل عليها حاليا
        default:
            return [];
    }

    if ($serviceType == 'package') {
        return []; // لا يوجد باقات حاليا
    } else {
        $sql = "SELECT *, {$priceField} as price FROM {$table} WHERE {$idField} = ? AND SquareID = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "SQL Error: " . $conn->error . "<br> SQL: {$sql} <br>";
            return null;
        }
        $stmt->bind_param("ii", $serviceID, $square_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $service = $result->fetch_assoc();
                $service['MainImageURL'] = isset($service['MainImageURL']) ? $service['MainImageURL'] : '';
                 $service['AdditionalImageURL1'] = isset($service['AdditionalImageURL1']) ? $service['AdditionalImageURL1'] : '';
                $service['AdditionalImageURL2'] = isset($service['AdditionalImageURL2']) ? $service['AdditionalImageURL2'] : '';
                return $service;

        } else {
            return null;
        }
    }
}


// دالة لتخزين الحجز
function storeBooking($conn, $userID, $serviceType, $data)
{
    // إنشاء حجز رئيسي
    $sql_booking = "INSERT INTO Bookings (UserID, BookingDate, PaymentStatus, TotalCost) VALUES (?, NOW(), 'قيد الدفع', ?)";
    $stmt_booking = $conn->prepare($sql_booking);
    $stmt_booking->bind_param("id", $userID, $data['total_price']);
    $stmt_booking->execute();
    $bookingID = $conn->insert_id;


    if ($bookingID > 0) {
        switch ($serviceType) {
            case 'hotel':
                 $sql = "INSERT INTO HotelBookingDetails (BookingID, HotelID, RoomType, NumberOfRooms, NumberOfNights, CheckInDate, CheckOutDate, Price) VALUES (?, ?, ?, ?, ?, ?, DATE_ADD(?, INTERVAL ? DAY), ?)";
 $stmt = $conn->prepare($sql);
 $stmt->bind_param("iisiiisid", $bookingID, $data['service_id'], $data['room_type'], $data['rooms'], $data['nights'], $data['arrival'], $data['arrival'], $data['nights'], $data['total_price']);
                break;
            case 'restaurant':
                $sql = "INSERT INTO RestaurantBookingDetails (BookingID, RestaurantID, ReservationDate, NumberOfGuests, Price) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $reservation_date = $data['date'];
                $stmt->bind_param("iisid", $bookingID, $data['service_id'], $reservation_date, $data['persons'], $data['total_price']);
                break;
            case 'car':
               $sql = "INSERT INTO CarBookingDetails (BookingID, CarID, CarType, PickupDate, ReturnDate, Price) VALUES (?, ?, ?, ?, ?, ?)";
               $stmt = $conn->prepare($sql);
               $stmt->bind_param("iissid", $bookingID, $data['service_id'], $data['car_type'], $data['pickup_date'], $data['return_date'], $data['total_price']);

                break;
            case 'activity':
                 $sql = "INSERT INTO ActivityBookingDetails (BookingID, ActivityID, ActivityDate, NumberOfTickets, Price) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $activity_datetime = $data['activity_date'];
                $stmt->bind_param("iisid", $bookingID, $data['service_id'], $activity_datetime, $data['participants'], $data['total_price']);
                break;
            case 'package':
                // لا يوجد باقات حاليا
                return null;
            default:
                return null;
        }
        if ($stmt && $stmt->execute()) {
            return $bookingID;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function calculatePrice($serviceType, $service, $data)
{
    $totalPrice = 0;
    switch ($serviceType) {
        case 'hotel':
            if ($data['room_type'] == "غرفة") {
                $totalPrice =  $service['RoomPrice'] * $data['rooms'] * $data['nights'];
            } else {
                $totalPrice =  $service['SuitePrice'] * $data['rooms'] * $data['nights'];
            }
            break;
        case 'restaurant':
            $totalPrice = $service['price'];
            break;
        case 'car':
            $pickupDate = new DateTime($data['pickup_date']);
            $returnDate = new DateTime($data['return_date']);
            $days = $pickupDate->diff($returnDate)->days;
            $totalPrice = $service['price'] * $days;
            break;
        case 'activity':
            $totalPrice =  $service['price'] * $data['participants'];
            break;
        case 'package':
            $totalPrice = 0;
            break;
    }
    return $totalPrice;
}


// معالجة الحجز إذا تم الإرسال
$booking_success = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'book') {
    $userID = $_SESSION['user_id'];

    $bookingData = [];
    $service = getServiceDetails($conn, $square_id, $serviceType, $serviceID);

    switch ($serviceType) {
        case 'hotel':
           $bookingData = [
                'service_id' => $serviceID,
                'room_type' => $_POST['room_type'],
                'rooms' => $_POST['rooms'],
                'nights' => $_POST['nights'],
                'arrival' => $_POST['arrival'],
             ];
        break;
        case 'restaurant':
            $bookingData = [
                'service_id' => $serviceID,
                'persons' => $_POST['persons'],
                'date' =>  $_POST['date'] ,
            ];
        break;
       case 'car':
            $bookingData = [
                'service_id' => $serviceID,
                'car_type' => $_POST['car_type'],
                'pickup_date' => $_POST['pickup_date'],
                'return_date' => $_POST['return_date'],
            ];
           break;
        case 'activity':
            $bookingData = [
                'service_id' => $serviceID,
                'participants' => $_POST['participants'],
                'activity_date' => $_POST['activity_date'],
             ];
            break;
         case 'package':
              $bookingData = [
                    'service_id' => $serviceID,
                    'package_date' => $_POST['package_date'],
                ];
             break;
      }
    // حساب السعر
    $total_price = calculatePrice($serviceType, $service, $bookingData);
    $bookingData['total_price'] = $total_price;

    $booking_id = storeBooking($conn, $userID, $serviceType, $bookingData);

    if ($booking_id) {
         $booking_success = true;
    } else {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
         <span class="block sm:inline">حدث خطأ، حاول مرة أخرى</span>
       </div>';
    }
}

// جلب تفاصيل الخدمة
$service = getServiceDetails($conn, $square_id, $serviceType, $serviceID);

if (!$service) {
    die("الخدمة غير متوفرة");
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الخدمة</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
      <?php if ($booking_success): ?>
            <meta http-equiv="refresh" content="3;url=services.php?square_id=<?php echo $square_id; ?>">
    <?php endif; ?>
</head>
<body class="bg-gray-100">

<?php include 'side_bar.php'; ?>

<main class="container mx-auto p-4">
    <?php if ($booking_success): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">تم الحجز بنجاح، سيتم تحويلك إلى صفحة الخدمات خلال 3 ثواني...</span>
        </div>
    <?php endif; ?>
    <div class="bg-white rounded-lg shadow-lg p-4">
        <h2 class="text-2xl font-bold mb-4"><?php echo $service['Name']; ?></h2>
          <?php if (!empty($service['MainImageURL'])): ?>
            <img src="<?php echo $service['MainImageURL']; ?>" alt="<?php echo $service['Name']; ?>" class="w-full h-64 object-cover mb-4 rounded-md">
        <?php endif; ?>

        <?php if ($serviceType == 'hotel'): ?>
            <p class="text-gray-700 mb-4"><?php echo $service['Packages']; ?></p>
            <div class="mb-4">
                <h4 class="text-xl font-bold mb-2">صور إضافية</h4>
                <div class="grid grid-cols-2 gap-2">
                   <?php if (!empty($service['AdditionalImageURL1'])): ?>
                            <img src="<?php echo $service['AdditionalImageURL1']; ?>" alt="<?php echo $service['Name']; ?>" class="w-full h-24 object-cover rounded-md">
                        <?php endif; ?>
                         <?php if (!empty($service['AdditionalImageURL2'])): ?>
                           <img src="<?php echo $service['AdditionalImageURL2']; ?>" alt="<?php echo $service['Name']; ?>" class="w-full h-24 object-cover rounded-md">
                        <?php endif; ?>
                </div>
            </div>
            <div class="mb-4">
                <h4 class="text-xl font-bold mb-2">مرافق الفندق</h4>
                <ul class="list-disc list-inside text-gray-700">
                    <li>واي فاي</li>
                    <li>مسبح</li>
                    <li>مطعم</li>
                    <li>خدمة غرف</li>
                </ul>
            </div>
            <p class="text-gray-700 mb-4">سعر الغرفة: <?php echo $service['RoomPrice']; ?> ريال</p>
            <p class="text-gray-700 mb-4">سعر الجناح: <?php echo $service['SuitePrice']; ?> ريال</p>
            <h4 class="text-xl font-bold mb-2">خيارات الحجز</h4>
            <form method="post" onsubmit="return validateHotelForm(this, <?php echo $service['RoomPrice']; ?>, <?php echo $service['SuitePrice']; ?>)">
                <input type="hidden" name="action" value="book">
                 <input type="hidden" name="service_type" value="hotel">
                 <input type="hidden" name="service_id" value="<?php echo $serviceID; ?>">
                <div class="mb-4 flex flex-col gap-2">
                    <label for="rooms" class="block text-gray-700 text-sm font-bold">عدد الغرف:</label>
                    <input type="number" id="rooms" name="rooms" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" placeholder="ادخل عدد الغرف" required>
                    <label for="nights" class="block text-gray-700 text-sm font-bold">عدد الليالي:</label>
                    <input type="number" id="nights" name="nights" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" placeholder="ادخل عدد الليالي" required>
                    <label for="arrival" class="block text-gray-700 text-sm font-bold">تاريخ الوصول:</label>
                    <input type="date" id="arrival" name="arrival" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" required>
                     <label for="booking_type" class="block text-gray-700 text-sm font-bold">نوع الحجز:</label>
                     <select id="booking_type" name="room_type" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" required>
                        <option value="غرفة">غرفة</option>
                        <option value="جناح">جناح</option>
                    </select>
                </div>
                 <div id="hotel-price-display" class="text-lg font-bold text-green-700 mb-4"></div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">حجز</button>
                     <a href="services.php?square_id=<?php echo $square_id ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg">إغلاق</a>
                </div>
            </form>
        <?php elseif ($serviceType == 'restaurant'): ?>
            <p class="text-gray-700 mb-4"><?php echo $service['Menu']; ?></p>
            <p class="text-gray-700 mb-4"> سعر الحجز: <?php echo $service['BookingPrice']; ?> ريال</p>
            <p class="text-gray-700 mb-4"> مناسب للعائلات: <?php echo $service['FamilyFriendly'] ? 'نعم' : 'لا'; ?></p>
            <h4 class="text-xl font-bold mb-2">خيارات الحجز</h4>
            <form method="post" onsubmit="return validateRestaurantForm(this, <?php echo $service['BookingPrice']; ?>)">
                <input type="hidden" name="action" value="book">
                 <input type="hidden" name="service_type" value="restaurant">
                  <input type="hidden" name="service_id" value="<?php echo $serviceID; ?>">
                <div class="mb-4 flex flex-col gap-2">
                    <label for="persons" class="block text-gray-700 text-sm font-bold">عدد الأشخاص:</label>
                    <input type="number" id="persons" name="persons" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" placeholder="ادخل عدد الأشخاص" required>
                    <label for="date" class="block text-gray-700 text-sm font-bold">تاريخ الحجز:</label>
                    <input type="date" id="date" name="date" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" required>
                </div>
                 <div id="restaurant-price-display" class="text-lg font-bold text-green-700 mb-4"></div>
                 <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">حجز</button>
                      <a href="services.php?square_id=<?php echo $square_id ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg">إغلاق</a>
                </div>
            </form>
        <?php elseif ($serviceType == 'car'): ?>
            <p class="text-gray-700 mb-4"><?php echo $service['Description']; ?></p>
            <p class="text-gray-700 mb-4">سعر الإيجار لليوم: <?php echo $service['RentalPrice']; ?> ريال</p>
            <h4 class="text-xl font-bold mb-2">خيارات الحجز</h4>
            <form method="post" onsubmit="return validateCarForm(this, <?php echo $service['RentalPrice']; ?>)">
                <input type="hidden" name="action" value="book">
                <input type="hidden" name="service_type" value="car">
                <input type="hidden" name="service_id" value="<?php echo $serviceID; ?>">
                <div class="mb-4 flex flex-col gap-2">
                    <label for="pickup_date" class="block text-gray-700 text-sm font-bold">تاريخ استلام السيارة:</label>
                    <input type="date" id="pickup_date" name="pickup_date" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" required>
                    <label for="return_date" class="block text-gray-700 text-sm font-bold">تاريخ إعادة السيارة:</label>
                    <input type="date" id="return_date" name="return_date" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" required>
                      <label for="car_type" class="block text-gray-700 text-sm font-bold">نوع السيارة:</label>
                      <p  class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black"><?php echo $service['Type']; ?></p>
                       <input type="hidden" name="car_type" value="<?php echo $service['Type']; ?>">
                </div>
                 <div id="car-price-display" class="text-lg font-bold text-green-700 mb-4"></div>
                 <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">حجز</button>
                    <a href="services.php?square_id=<?php echo $square_id ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg">إغلاق</a>
                </div>
            </form>
        <?php elseif ($serviceType == 'activity'): ?>
            <p class="text-gray-700 mb-4"><?php echo $service['Description']; ?></p>
            <p class="text-gray-700 mb-4">سعر التذكرة: <?php echo $service['TicketPrice']; ?> ريال</p>
            <h4 class="text-xl font-bold mb-2">خيارات الحجز</h4>
            <form method="post" onsubmit="return validateActivityForm(this, <?php echo $service['TicketPrice']; ?>)">
                <input type="hidden" name="action" value="book">
                 <input type="hidden" name="service_type" value="activity">
                 <input type="hidden" name="service_id" value="<?php echo $serviceID; ?>">
                <div class="mb-4 flex flex-col gap-2">
                    <label for="participants" class="block text-gray-700 text-sm font-bold">عدد المشاركين:</label>
                    <input type="number" id="participants" name="participants" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" placeholder="ادخل عدد المشاركين" required>
                    <label for="activity_date" class="block text-gray-700 text-sm font-bold">تاريخ النشاط:</label>
                    <input type="date" id="activity_date" name="activity_date" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" required>
                </div>
                 <div id="activity-price-display" class="text-lg font-bold text-green-700 mb-4"></div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">حجز</button>
                     <a href="services.php?square_id=<?php echo $square_id ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg">إغلاق</a>
                </div>
            </form>
        <?php elseif ($serviceType == 'package'): ?>
             <p class="text-gray-700 mb-4"><?php echo $service['Description']; ?></p>
            <h4 class="text-xl font-bold mb-2">خيارات الحجز</h4>
            <form method="post" onsubmit="return validatePackageForm(this)">
                <input type="hidden" name="action" value="book">
                <input type="hidden" name="service_type" value="package">
                <input type="hidden" name="service_id" value="<?php echo $serviceID; ?>">
                <div class="mb-4 flex flex-col gap-2">
                    <label for="package_date" class="block text-gray-700 text-sm font-bold">تاريخ الباقة:</label>
                    <input type="date" id="package_date" name="package_date" class="p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-200 text-black" required>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">حجز</button>
                     <a href="services.php?square_id=<?php echo $square_id ?>" class="bg-gray-600 text-white px-4 py-2 rounded-lg">إغلاق</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</main>
<script>
    function calculateHotelPrice(form, roomPrice, suitePrice) {
        const rooms = parseInt(form.rooms.value);
        const nights = parseInt(form.nights.value);
         const roomType = form.room_type.value;
         let price = 0;
        if (roomType === 'غرفة') {
            price = roomPrice * rooms * nights;
        } else {
            price = suitePrice * rooms * nights;
        }
        document.getElementById('hotel-price-display').textContent = `السعر الإجمالي: ${price} ريال`;
          return true;
    }

     function calculateRestaurantPrice(form, bookingPrice) {
                document.getElementById('restaurant-price-display').textContent = `السعر الإجمالي: ${bookingPrice} ريال`;
                 return true;
      }

    function calculateCarPrice(form, rentalPerDay) {
        const pickupDate = new Date(form.pickup_date.value);
        const returnDate = new Date(form.return_date.value);
        const days = Math.ceil((returnDate - pickupDate) / (1000 * 60 * 60 * 24));
        if (isNaN(days) || days <= 0) {
             document.getElementById('car-price-display').textContent = `الرجاء تحديد تواريخ صحيحة`;
             return false;
        }
        const price = rentalPerDay * days;
          document.getElementById('car-price-display').textContent = `السعر الإجمالي: ${price} ريال`;
        return true;
    }

    function calculateActivityPrice(form, ticketPrice) {
        const participants = parseInt(form.participants.value);
        const price = ticketPrice * participants;
         document.getElementById('activity-price-display').textContent = `السعر الإجمالي: ${price} ريال`;
          return true;
    }

    function validateHotelForm(form, roomPrice, suitePrice) {
        if (!form.rooms.value || !form.nights.value || !form.arrival.value) {
            alert('الرجاء ملء جميع الحقول المطلوبة.');
            return false;
        }
      calculateHotelPrice(form, roomPrice, suitePrice);
       return true;
    }
    function validateRestaurantForm(form, bookingPrice) {
            if (!form.persons.value || !form.date.value) {
                alert('الرجاء ملء جميع الحقول المطلوبة.');
                return false;
            }
              calculateRestaurantPrice(form, bookingPrice);
            return true;
     }

    function validateCarForm(form, rentalPerDay) {
        if (!form.pickup_date.value || !form.return_date.value) {
            alert('الرجاء ملء جميع الحقول المطلوبة.');
            return false;
        }
       if (!calculateCarPrice(form, rentalPerDay)) {
            return false;
        }
        return true;
    }

    function validateActivityForm(form, ticketPrice) {
        if (!form.participants.value || !form.activity_date.value) {
            alert('الرجاء ملء جميع الحقول المطلوبة.');
            return false;
        }
           calculateActivityPrice(form, ticketPrice);
         return true;
    }

    function validatePackageForm(form) {
        if (!form.package_date.value) {
            alert('الرجاء ملء جميع الحقول المطلوبة.');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
