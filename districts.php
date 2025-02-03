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

// استعلام لجلب جميع المديريات
$sql = "SELECT * FROM Districts";
$result = $conn->query($sql);

// تخزين المديريات في مصفوفة
$districts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $districts[] = $row;
    }
}

// استعلام لجلب المعالم السياحية
$sql_attractions = "SELECT * FROM TouristAttractions";
$result_attractions = $conn->query($sql_attractions);
$attractions = [];
if ($result_attractions->num_rows > 0) {
    while($row = $result_attractions->fetch_assoc()) {
        $attractions[$row['DistrictID']][] = $row;
    }
}

// استعلام لجلب التقييمات
$sql_reviews = "SELECT * FROM Reviews";
$result_reviews = $conn->query($sql_reviews);
$reviews = [];
if ($result_reviews->num_rows > 0) {
    while($row = $result_reviews->fetch_assoc()) {
        if($row['HotelID']){
            $reviews['hotel'][$row['HotelID']][] = $row;
        }
        if($row['RestaurantID']){
            $reviews['restaurant'][$row['RestaurantID']][] = $row;
        }
        if($row['ActivityID']){
            $reviews['activity'][$row['ActivityID']][] = $row;
        }
    }
}


$conn->close();
?>

<html lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>منصة السياحة في تعز</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">

<?php include 'side_bar.php'; ?>

<div class="bg-white p-4 shadow-lg relative z-0">
    <div class="container mx-auto">
        <div class="relative">
            <input class="p-2 w-full rounded-lg text-black" placeholder="ابحث عن مديرية..." type="text"/>
            <button class="absolute right-2 top-2 text-gray-600">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</div>
<main class="container mx-auto p-4">
    <h2 class="text-3xl font-bold mb-4">المديريات</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($districts as $district): ?>
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <img alt="صورة لمديرية <?php echo $district['Name']; ?> تظهر معالمها السياحية"
                     class="w-full h-48 object-cover" height="200"
                     src="<?php echo $district['ImageURL']; ?>" width="300">
                <div class="p-4">
                    <h3 class="text-xl font-bold mb-2"><?php echo $district['Name']; ?></h3>
                    <p class="text-gray-700 mb-4"><?php echo $district['HistoricalBackground']; ?> وتبعد <?php echo $district['DistanceFromCenter']; ?> كم عن مركز محافظة تعز.</p>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg explore-button"
                            data-id="<?php echo $district['DistrictID']; ?>">
                        استكشاف
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" id="popup-modal">
    <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-1/2 lg:w-1/3 max-h-screen overflow-y-auto transform transition-all duration-300 ease-in-out relative">
       <button class="absolute top-2 right-2 text-gray-600 text-2xl" onclick="closePopup()">
          <i class="fas fa-times"></i>
        </button>
        <div class="p-4">
            <h3 class="text-2xl font-bold mb-2" id="popup-title"></h3>
            <img alt="صورة بانر كبيرة للمديرية" class="w-full h-64 object-cover mb-4" height="400" id="popup-image"
                 src="" width="600"/>
            <p class="text-gray-700 mb-4" id="popup-description"></p>
            <h4 class="text-xl font-bold mb-2">المعالم السياحية</h4>
            <div class="grid grid-cols-2 gap-2 mb-4" id="popup-landmarks"></div>
            <h4 class="text-xl font-bold mb-2">الأنشطة الموجودة</h4>
            <ul class="list-disc list-inside mb-4" id="popup-activities"></ul>
            <h4 class="text-xl font-bold mb-2">تقييمات المستخدمين</h4>
            <div class="mb-4" id="popup-reviews"></div>
            <p class="text-gray-700 mb-4" id="popup-distance"></p>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg mb-2" onclick="exploreResidentialBlocks()">
                استكشف المربعات السكنية
            </button>
        </div>
    </div>
</div>
<script>
    function toggleMenu() {
        const menu = document.getElementById('menu');
        menu.classList.toggle('hidden');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const exploreButtons = document.querySelectorAll('.explore-button');
        exploreButtons.forEach(button => {
            button.addEventListener('click', () => {
                const districtID = button.getAttribute('data-id');
                openPopup(districtID);
            });
        });
    });

   function openPopup(districtID) {
        const title = document.getElementById('popup-title');
        const image = document.getElementById('popup-image');
        const description = document.getElementById('popup-description');
        const landmarks = document.getElementById('popup-landmarks');
        const activities = document.getElementById('popup-activities');
        const reviews = document.getElementById('popup-reviews');
        const distance = document.getElementById('popup-distance');

        fetchDistrictData(districtID)
            .then(data => {
                title.textContent = data.name;
                image.src = data.imageURL;
                image.alt = 'صورة بانر كبيرة لمديرية ' + data.name + ' تظهر معالمها السياحية';
                description.textContent = data.historicalBackground;
                distance.textContent = 'المسافة من مركز المحافظة: ' + data.distanceFromCenter + ' كم';

                landmarks.innerHTML = '';
                if (data.attractions && data.attractions.length > 0) {
                    data.attractions.forEach(attraction => {
                        landmarks.innerHTML += `
                        <div>
                        <img src="${attraction.ImageURL}" alt="صورة مصغرة لـ  ${attraction.Name}" class="w-full h-24 object-cover mb-2">
                             <p class="text-gray-700">${attraction.Name}</p>
                        </div>
                    `;
                    });
                } else {
                    landmarks.innerHTML = `<p class="text-gray-700">لا توجد معالم سياحية.</p>`
                }

                activities.innerHTML = `<li>الأنشطة الثقافية والاجتماعية</li>`;
                reviews.innerHTML = getReviewsHTML(districtID);

                document.getElementById('popup-modal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error fetching district data:', error);
            });
    }

    function getReviewsHTML(districtID) {
    let reviewsHTML = '';
    <?php if (!empty($reviews['activity'])): ?>
        <?php foreach ($reviews['activity'] as $activityId => $activityReviews): ?>
        if(districtID == <?php echo $activityId ?>){
            <?php foreach($activityReviews as $review): ?>
            reviewsHTML += '<p class="text-gray-700">تقييم المستخدمين: <?php echo $review["Rating"] ?>/5</p> <p class="text-gray-700">تعليقات: "<?php echo $review["Comment"] ?>"</p>';
            <?php endforeach; ?>
        }
        <?php endforeach; ?>
    <?php endif; ?>
        if(!reviewsHTML){
            reviewsHTML += '<p class="text-gray-700">لا توجد تقييمات للمديرية.</p>';
        }
    return reviewsHTML;
    }


    async function fetchDistrictData(districtID) {
        try {
            const response = await fetch(`get_district_data.php?district_id=${districtID}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Failed to fetch district data:', error);
            throw error;
        }
    }


    function closePopup() {
        document.getElementById('popup-modal').classList.add('hidden');
    }

    function exploreResidentialBlocks() {
        const districtID = document.querySelector('#popup-modal').getAttribute('data-district-id');
        window.location.href = `residential_squares.php?district_id=${districtID}`;
    }


  //  بعد أن يتم عرض البوب اب الخاص بالمديرية ،، نقوم بإضافة خاصية الـ data-district-id  للبوب اب بحيث نقوم بإسناد رقم id الخاص بالمديرية ،، لها ،، ثم عند الضغط على زر ( استكشف المربعات السكنية ) نستخدمها في الانتقال للرابط
        document.addEventListener('DOMContentLoaded', () => {
            const exploreButtons = document.querySelectorAll('.explore-button');
            exploreButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const districtID = button.getAttribute('data-id');
                     document.getElementById('popup-modal').setAttribute('data-district-id', districtID);

                    openPopup(districtID);
                });
            });
        });
</script>
</body>
</html>
