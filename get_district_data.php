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

if (isset($_GET['district_id'])) {
    $districtId = $_GET['district_id'];

    // استعلام لجلب بيانات المديرية
    $sql = "SELECT * FROM Districts WHERE DistrictID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $districtId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $district = $result->fetch_assoc();

        // استعلام لجلب المعالم السياحية التابعة للمديرية
        $sql_attractions = "SELECT * FROM TouristAttractions WHERE DistrictID = ?";
        $stmt_attractions = $conn->prepare($sql_attractions);
        $stmt_attractions->bind_param("i", $districtId);
        $stmt_attractions->execute();
        $result_attractions = $stmt_attractions->get_result();

        $attractions = [];
        while ($row_attraction = $result_attractions->fetch_assoc()) {
            $attractions[] = $row_attraction;
        }

        // تجهيز البيانات للإرسال
        $data = [
            'id' => $district['DistrictID'],
            'name' => $district['Name'],
            'historicalBackground' => $district['HistoricalBackground'],
            'distanceFromCenter' => $district['DistanceFromCenter'],
            'imageURL' => $district['ImageURL'],
            'attractions' => $attractions,
        ];

        // إرسال البيانات بتنسيق JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo json_encode(['error' => 'لم يتم العثور على المديرية.']);
    }
} else {
    echo json_encode(['error' => 'District ID is missing.']);
}

$conn->close();
?>
