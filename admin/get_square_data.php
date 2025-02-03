<?php
// الاتصال بقاعدة البيانات (تأكد من تعديل بيانات الاتصال)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_ter2"; // استبدل your_database_name باسم قاعدة البيانات الخاصة بك

// إنشاء اتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}
// التحقق من وجود معرف المربع السكني
if(isset($_GET['square_id']) && is_numeric($_GET['square_id'])){
    $square_id = $_GET['square_id'];

    // استعلام لجلب بيانات المربع السكني مع ImageURL
   $square_sql = "SELECT SquareID, Name, DistanceFromDistrictCenter, ImageURL FROM ResidentialSquares WHERE SquareID = " . $square_id;
    $square_result = $conn->query($square_sql);

    if($square_result && $square_result->num_rows > 0){
        $square_row = $square_result->fetch_assoc();
        $square_name = $square_row['Name'];
        $distance = $square_row['DistanceFromDistrictCenter'];
          $square_image = $square_row['ImageURL'];

            if (empty($square_image)) {
                $square_image = "https://placehold.co/600x400"; // استخدام صورة افتراضية إذا لم يكن هناك رابط
            }


        // استعلام لجلب الفنادق الموجودة في المربع السكني
         $hotels_sql = "SELECT HotelID, Name , MainImageURL FROM Hotels WHERE SquareID = " . $square_id;
        $hotels_result = $conn->query($hotels_sql);
        $hotels_html = "";
        if($hotels_result && $hotels_result->num_rows > 0){
             while($hotel_row = $hotels_result->fetch_assoc()){
               $hotel_image = $hotel_row['MainImageURL'];

              if (empty($hotel_image)) {
                  $hotel_image = "https://placehold.co/100x100"; // استخدام صورة افتراضية إذا لم يكن هناك رابط
              }

              $hotels_html .= '<div><img src="' . $hotel_image . '" alt="صورة مصغرة لفندق" class="w-full h-24 object-cover mb-2"><p class="text-gray-700">' . $hotel_row['Name'] . '</p></div>';
            }
        } else {
          $hotels_html = "<p>لا توجد فنادق متاحة في هذا المربع</p>";
        }
        
         // استعلام لجلب المطاعم الموجودة في المربع السكني
        $restaurants_sql = "SELECT RestaurantID, Name , MainImageURL FROM Restaurants WHERE SquareID = " . $square_id;
        $restaurants_result = $conn->query($restaurants_sql);
        $restaurants_html = "";
        if($restaurants_result && $restaurants_result->num_rows > 0){
           while($restaurant_row = $restaurants_result->fetch_assoc()){
             $restaurant_image = $restaurant_row['MainImageURL'];

              if (empty($restaurant_image)) {
                  $restaurant_image = "https://placehold.co/100x100"; // استخدام صورة افتراضية إذا لم يكن هناك رابط
              }

              $restaurants_html .= '<div><img src="' . $restaurant_image . '" alt="صورة مصغرة لمطعم" class="w-full h-24 object-cover mb-2"><p class="text-gray-700">' . $restaurant_row['Name'] . '</p></div>';
           }
        } else {
          $restaurants_html = "<p>لا توجد مطاعم متاحة في هذا المربع</p>";
        }
        
         // استعلام لجلب الأماكن الترفيهية الموجودة في المربع السكني
        $entertainment_sql = "SELECT PlaceID, Name, MainImageURL FROM EntertainmentPlaces WHERE SquareID = " . $square_id;
        $entertainment_result = $conn->query($entertainment_sql);
        $entertainment_html = "";
        if($entertainment_result && $entertainment_result->num_rows > 0){
           while($entertainment_row = $entertainment_result->fetch_assoc()){
             $entertainment_image = $entertainment_row['MainImageURL'];
              if (empty($entertainment_image)) {
                 $entertainment_image = "https://placehold.co/100x100"; // استخدام صورة افتراضية إذا لم يكن هناك رابط
              }

              $entertainment_html .= '<div><img src="' . $entertainment_image . '" alt="صورة مصغرة لمكان ترفيهي" class="w-full h-24 object-cover mb-2"><p class="text-gray-700">' . $entertainment_row['Name'] . '</p></div>';
            }
        }  else {
          $entertainment_html = "<p>لا توجد أماكن ترفيهية متاحة في هذا المربع</p>";
        }
        
       // استعلام لجلب خدمات السيارات الموجودة في المربع السكني
        $services_sql = "SELECT CarID, Name , MainImageURL FROM Cars WHERE SquareID = " . $square_id;
        $services_result = $conn->query($services_sql);
        $services_html = "";
        if($services_result && $services_result->num_rows > 0){
            while($service_row = $services_result->fetch_assoc()){
                $service_image = $service_row['MainImageURL'];
                  if (empty($service_image)) {
                     $service_image = "https://placehold.co/100x100"; // استخدام صورة افتراضية إذا لم يكن هناك رابط
                  }
              $services_html .= '<div><img src="' . $service_image . '" alt="صورة مصغرة لخدمة سيارات" class="w-full h-24 object-cover mb-2"><p class="text-gray-700">' . $service_row['Name'] . '</p></div>';
           }
        } else {
             $services_html = "<p>لا توجد خدمات سيارات متاحة في هذا المربع</p>";
        }
        

        $response = array(
            'square_name' => $square_name,
            'square_image' => $square_image,
            'distance' => $distance,
            'hotels_html' => $hotels_html,
            'restaurants_html' => $restaurants_html,
            'entertainment_html' => $entertainment_html,
            'services_html' => $services_html
         );
        
    } else {
           $response = array('error' => 'Square not found');
    }
    

} else {
    $response = array('error' => 'Invalid square ID');
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
