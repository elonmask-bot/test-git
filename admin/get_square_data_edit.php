<?php
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

// الحصول على SquareID من الاستعلام
$squareID = $_GET['square_id'];

// استعلام لجلب بيانات المربع السكني مع ImageURL
$sql = "SELECT * FROM ResidentialSquares WHERE SquareID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $squareID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $square = $result->fetch_assoc();
    // تجهيز البيانات لتكون على شكل JSON
    $data = array(
        'squareId' => $square['SquareID'],
        'name' => $square['Name'],
        'distanceFromDistrictCenter' => $square['DistanceFromDistrictCenter'],
        'districtId' => $square['DistrictID'],
         'imageUrl' => $square['ImageURL'] // إضافة رابط الصورة
    );
    // إرسال البيانات بتنسيق JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // إرسال رسالة خطأ في حالة عدم وجود المربع السكني
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'لم يتم العثور على المربع السكني.'));
}

$stmt->close();
$conn->close();
?>
