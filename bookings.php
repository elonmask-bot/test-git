<?php

session_start();

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


// تضمين ملف الاتصال بقاعدة البيانات
include 'db_connect.php';

// نفترض أن المستخدم مسجل الدخول ولديه ID = 1 (يجب تعديله لاحقًا)
$userID = 1;
$userID = $_SESSION['user_id'];
// دالة لجلب حجوزات المستخدم
function getUserBookings($conn, $userID)
{
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
            WHERE b.UserID = ?
            ORDER BY b.BookingDate DESC";


    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "SQL Error: " . $conn->error;
        return [];
    }
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    $bookings = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }
    return $bookings;
}

// دالة لحساب حالة الحجز
function getBookingStatus($bookingDate)
{
    $bookingDateTime = new DateTime($bookingDate);
    $bookingDateTime->setTime(0,0,0); // تعيين الوقت إلى 00:00:00
    $currentDateTime = new DateTime();
    $currentDateTime->setTime(0,0,0);
    if ($bookingDateTime < $currentDateTime) {
        return 'تمت';
    } else {
        return 'قيد الانتظار';
    }
}

// جلب حجوزات المستخدم
$bookings = getUserBookings($conn, $userID);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الحجوزات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
         .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

         .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100">

<?php include 'side_bar.php'; ?>


<main class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">حجوزاتي السابقة</h2>
    <div class="bg-white rounded-lg shadow-lg p-4">
        <?php if (empty($bookings)): ?>
            <p class="text-gray-600">لا توجد لديك أي حجوزات سابقة.</p>
        <?php else: ?>
            <table class="min-w-full leading-normal">
                <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        رقم الحجز
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        تاريخ الحجز
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        التكلفة الإجمالية
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        نوع الخدمة
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        الحالة
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr class="booking-row cursor-pointer hover:bg-gray-50" data-booking-id="<?php echo $booking['BookingID']; ?>">
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <?php echo $booking['BookingID']; ?>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <?php echo $booking['BookingDate']; ?>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <?php echo $booking['TotalCost']; ?> ريال
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <?php
                            switch ($booking['ServiceType']) {
                                case 'hotel':
                                    echo 'فندق';
                                    break;
                                case 'restaurant':
                                    echo 'مطعم';
                                    break;
                                case 'car':
                                    echo 'سيارة';
                                    break;
                                case 'activity':
                                    echo 'نشاط';
                                    break;
                                default:
                                    echo 'غير معروف';
                            }
                            ?>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <?php echo getBookingStatus($booking['BookingDate']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</main>

<div id="bookingModal" class="modal">
    <div class="modal-content">
        <span class="close">×</span>
        <h2 class="text-2xl font-bold mb-4">تفاصيل الحجز</h2>
        <div id="bookingDetailsContent">
            <p>جاري تحميل التفاصيل...</p>
        </div>
    </div>
</div>
<script>
     document.addEventListener('DOMContentLoaded', () => {
        const bookingRows = document.querySelectorAll('.booking-row');
          bookingRows.forEach(row => {
            row.addEventListener('click', () => {
                const bookingId = row.getAttribute('data-booking-id');
                fetchBookingDetails(bookingId);
            });
        });

         const modal = document.getElementById('bookingModal');
        const closeBtn = document.querySelector('.close');
            closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });
            window.addEventListener('click', (event) => {
                if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });


    async function fetchBookingDetails(bookingId) {
           try {
                const response = await fetch(`get_booking_details.php?booking_id=${bookingId}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                displayBookingDetails(data);
            } catch (error) {
                console.error('Failed to fetch booking details:', error);
            }
        }

       function displayBookingDetails(data) {
             const modal = document.getElementById('bookingModal');
            const contentDiv = document.getElementById('bookingDetailsContent');
                contentDiv.innerHTML = '';

            if (data.error) {
                    contentDiv.innerHTML = `<p class="text-red-500">${data.error}</p>`;
                } else {
                  let detailsHTML = '';

                  if(data.bookingDetails.ServiceType === 'hotel') {
                     detailsHTML += `
                        <p><strong>نوع الخدمة:</strong> فندق</p>
                        <p><strong>اسم الفندق:</strong> ${data.hotelDetails.Name}</p>
                        <p><strong>عدد الغرف:</strong> ${data.hotelDetails.NumberOfRooms}</p>
                        <p><strong>نوع الغرفة:</strong> ${data.hotelDetails.RoomType}</p>
                        <p><strong>تاريخ الوصول:</strong> ${data.hotelDetails.CheckInDate}</p>
                        <p><strong>تاريخ المغادرة:</strong> ${data.hotelDetails.CheckOutDate}</p>
                        <p><strong>السعر:</strong> ${data.hotelDetails.Price} ريال</p>
                    `;
                  } else if (data.bookingDetails.ServiceType === 'restaurant'){
                      detailsHTML += `
                        <p><strong>نوع الخدمة:</strong> مطعم</p>
                         <p><strong>اسم المطعم:</strong> ${data.restaurantDetails.Name}</p>
                          <p><strong>عدد الضيوف:</strong> ${data.restaurantDetails.NumberOfGuests}</p>
                        <p><strong>تاريخ الحجز:</strong> ${data.restaurantDetails.ReservationDate}</p>
                        <p><strong>السعر:</strong> ${data.restaurantDetails.Price} ريال</p>
                    `;
                  }  else if (data.bookingDetails.ServiceType === 'car'){
                       detailsHTML += `
                        <p><strong>نوع الخدمة:</strong> سيارة</p>
                         <p><strong>اسم السيارة:</strong> ${data.carDetails.Name}</p>
                         <p><strong>نوع السيارة:</strong> ${data.carDetails.CarType}</p>
                        <p><strong>تاريخ الاستلام:</strong> ${data.carDetails.PickupDate}</p>
                        <p><strong>تاريخ الإرجاع:</strong> ${data.carDetails.ReturnDate}</p>
                         <p><strong>السعر:</strong> ${data.carDetails.Price} ريال</p>
                    `;

                  } else if (data.bookingDetails.ServiceType === 'activity'){
                        detailsHTML += `
                        <p><strong>نوع الخدمة:</strong> نشاط</p>
                         <p><strong>اسم النشاط:</strong> ${data.activityDetails.Name}</p>
                        <p><strong>تاريخ النشاط:</strong> ${data.activityDetails.ActivityDate}</p>
                        <p><strong>عدد التذاكر:</strong> ${data.activityDetails.NumberOfTickets}</p>
                        <p><strong>السعر:</strong> ${data.activityDetails.Price} ريال</p>
                     `;
                  }
                    detailsHTML += `<p><strong>التكلفة الإجمالية:</strong> ${data.bookingDetails.TotalCost} ريال</p>`;
                   contentDiv.innerHTML = detailsHTML;

                }
            modal.style.display = 'block';
        }
</script>
</body>
</html>
