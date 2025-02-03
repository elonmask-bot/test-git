<?php
// تضمين ملف الاتصال بقاعدة البيانات
include 'db_connect.php';

// التحقق من وجود booking_id
if (!isset($_GET['booking_id']) || empty($_GET['booking_id'])) {
    echo json_encode(['error' => 'لم يتم توفير معرف الحجز.']);
    exit;
}

$bookingID = $_GET['booking_id'];


$sql = "SELECT b.BookingID, b.BookingDate, b.TotalCost,
            COALESCE(hb.HotelID, rb.RestaurantID, cb.CarID, ab.ActivityID) AS ServiceID,
            CASE
                WHEN hb.HotelID IS NOT NULL THEN 'hotel'
                WHEN rb.RestaurantID IS NOT NULL THEN 'restaurant'
                WHEN cb.CarID IS NOT NULL THEN 'car'
                WHEN ab.ActivityID IS NOT NULL THEN 'activity'
                ELSE 'unknown'
            END AS ServiceType
            FROM Bookings b
            LEFT JOIN HotelBookingDetails hb ON b.BookingID = hb.BookingID
            LEFT JOIN RestaurantBookingDetails rb ON b.BookingID = rb.BookingID
            LEFT JOIN CarBookingDetails cb ON b.BookingID = cb.BookingID
            LEFT JOIN ActivityBookingDetails ab ON b.BookingID = ab.BookingID
            WHERE b.BookingID = ?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
       echo json_encode(['error' => "SQL Error: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("i", $bookingID);
    $stmt->execute();
    $result = $stmt->get_result();


    if ($result->num_rows <= 0) {
        echo json_encode(['error' => 'لم يتم العثور على تفاصيل الحجز.']);
        exit;
    }
  $bookingDetails = $result->fetch_assoc();


     $response = ['bookingDetails' => $bookingDetails];

     if($bookingDetails['ServiceType'] === 'hotel'){
          $sql = "SELECT h.Name, hbd.RoomType, hbd.NumberOfRooms, hbd.CheckInDate, hbd.CheckOutDate,hbd.Price
                 FROM HotelBookingDetails hbd
                 JOIN Hotels h ON hbd.HotelID = h.HotelID
                 WHERE hbd.BookingID = ?";

              $stmt = $conn->prepare($sql);
               if ($stmt === false) {
                   echo json_encode(['error' => "SQL Error: " . $conn->error]);
                   exit;
               }
                 $stmt->bind_param("i", $bookingID);
                $stmt->execute();
              $result = $stmt->get_result();
                 if ($result->num_rows > 0) {
                   $response['hotelDetails'] = $result->fetch_assoc();
                 }
     }
       else if($bookingDetails['ServiceType'] === 'restaurant'){
            $sql = "SELECT r.Name, rbd.ReservationDate, rbd.NumberOfGuests, rbd.Price
                 FROM RestaurantBookingDetails rbd
                 JOIN Restaurants r ON rbd.RestaurantID = r.RestaurantID
                 WHERE rbd.BookingID = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                echo json_encode(['error' => "SQL Error: " . $conn->error]);
                exit;
            }
            $stmt->bind_param("i", $bookingID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                 $response['restaurantDetails'] = $result->fetch_assoc();
            }
    }
     else if($bookingDetails['ServiceType'] === 'car'){
           $sql = "SELECT c.Name, cbd.CarType, cbd.PickupDate, cbd.ReturnDate, cbd.Price
                 FROM CarBookingDetails cbd
                 JOIN Cars c ON cbd.CarID = c.CarID
                 WHERE cbd.BookingID = ?";

          $stmt = $conn->prepare($sql);
          if ($stmt === false) {
               echo json_encode(['error' => "SQL Error: " . $conn->error]);
              exit;
           }
           $stmt->bind_param("i", $bookingID);
           $stmt->execute();
           $result = $stmt->get_result();
             if ($result->num_rows > 0) {
                $response['carDetails'] = $result->fetch_assoc();
          }
     }

      else if($bookingDetails['ServiceType'] === 'activity'){
        $sql = "SELECT ep.Name, abd.ActivityDate, abd.NumberOfTickets, abd.Price
              FROM ActivityBookingDetails abd
              JOIN EntertainmentPlaces ep ON abd.ActivityID = ep.PlaceID
             WHERE abd.BookingID = ?";

            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                 echo json_encode(['error' => "SQL Error: " . $conn->error]);
                exit;
            }
             $stmt->bind_param("i", $bookingID);
            $stmt->execute();
            $result = $stmt->get_result();
              if ($result->num_rows > 0) {
                $response['activityDetails'] = $result->fetch_assoc();
             }
        }

     header('Content-Type: application/json');
    echo json_encode($response);


$conn->close();
?>
