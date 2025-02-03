<?php
// تضمين ملف الاتصال بقاعدة البيانات
include 'db_connect.php';

// الحصول على البيانات من الاستعلام
$serviceType = $_GET['service_type'];
$id = $_GET['id'];

$table = '';
$idField = '';
$priceField = '';
$nameField = '';
$typeField = '';
$imageField = '';


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

// استعلام لجلب بيانات الخدمة
$sql = "SELECT {$nameField} as name, {$typeField} as type, {$priceField} as price, {$imageField} as image_url FROM {$table} WHERE {$idField} = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $service = $result->fetch_assoc();
     header('Content-Type: application/json');
    echo json_encode($service);
} else {
    // إرسال رسالة خطأ في حالة عدم وجود الخدمة
     header('Content-Type: application/json');
     echo json_encode(array('error' => 'لم يتم العثور على الخدمة.'));
}

$stmt->close();
$conn->close();
?>
