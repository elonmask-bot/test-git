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

if (isset($_GET['attraction_id'])) {
    $attractionId = $_GET['attraction_id'];

    // استعلام لجلب بيانات المعلم السياحي
    $sql = "SELECT * FROM TouristAttractions WHERE AttractionID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $attractionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $attraction = $result->fetch_assoc();
        
        // تجهيز البيانات للإرسال
        $data = [
            'id' => $attraction['AttractionID'],
            'name' => $attraction['Name'],
            'description' => $attraction['Description'],
             'imageURL' => $attraction['ImageURL'],
        ];

        // إرسال البيانات بتنسيق JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'لم يتم العثور على المعلم السياحي.']);
    }
} else {
    echo json_encode(['error' => 'Attraction ID is missing.']);
}

$conn->close();
?>
