<?php
session_start();
?>

<!DOCTYPE html>
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

<main class="container mx-auto p-4">
    <section class="text-center mb-12">
        <h2 class="text-4xl font-bold mb-6">مرحباً بك في منصة السياحة في تعز</h2>
        <p class="text-gray-700 mb-8">اكتشف جمال تعز وتراثها العريق، وابدأ مغامرتك الآن!</p>
        <a href="districts.php"
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg inline-block">
            هيا نستكشف المديريات
        </a>
    </section>

    <section class="bg-white rounded-lg shadow-lg p-6 mb-12">
        <h2 class="text-2xl font-bold mb-4 text-center">عن محافظة تعز</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <div>
                <p class="text-gray-700 mb-4">
                    تعتبر محافظة تعز إحدى أهم المحافظات اليمنية، وتشتهر بتاريخها العريق وتنوع تضاريسها. تتميز تعز بمعالمها التاريخية
                    والسياحية الفريدة، كما أنها تعتبر مركزًا ثقافيًا وتجاريًا هامًا.
                </p>
                <p class="text-gray-700 mb-4">
                     تضم تعز العديد من المديريات التي تزخر بالمعالم السياحية والتاريخية،
                     وتقدم تجارب فريدة للزوار من خلال مطاعمها وفنادقها المتنوعة، بالإضافة إلى الأنشطة الترفيهية المتوفرة فيها.
                     كما ان المربعات السكنية تعتبر جزء مهم ومميز في كل مديرية.
                </p>
            </div>
            <div>
                <img alt="صورة لمدينة تعز ومعالمها" class="w-full rounded-lg shadow-md"
                     src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Taiz_city_-_HDR_%2815356981111%29.jpg/1280px-Taiz_city_-_HDR_%2815356981111%29.jpg"/>
            </div>
        </div>
    </section>

    <section class="bg-white rounded-lg shadow-lg p-6 mb-12">
        <h2 class="text-2xl font-bold mb-4 text-center">خدماتنا</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div class="text-center">
               <i class="fas fa-map-marked-alt text-4xl mb-2 text-blue-600"></i>
                <h3 class="text-xl font-bold mb-2">استكشاف المديريات</h3>
                <p class="text-gray-600">تصفح المديريات والمعالم السياحية في تعز.</p>
            </div>
            <div class="text-center">
                  <i class="fas fa-building text-4xl mb-2 text-blue-600"></i>
                <h3 class="text-xl font-bold mb-2">المربعات السكنية</h3>
                <p class="text-gray-600">استكشف المربعات السكنية داخل كل مديرية.</p>
            </div>
              <div class="text-center">
                 <i class="fas fa-hotel text-4xl mb-2 text-blue-600"></i>
                <h3 class="text-xl font-bold mb-2">حجز الفنادق</h3>
                <p class="text-gray-600">احجز في أفضل الفنادق داخل المربعات السكنية.</p>
            </div>
            <div class="text-center">
                  <i class="fas fa-utensils text-4xl mb-2 text-blue-600"></i>
                <h3 class="text-xl font-bold mb-2">المطاعم</h3>
                <p class="text-gray-600">اكتشف المطاعم المتنوعة داخل المربعات السكنية.</p>
            </div>
             <div class="text-center">
                 <i class="fas fa-car text-4xl mb-2 text-blue-600"></i>
                <h3 class="text-xl font-bold mb-2">تأجير السيارات</h3>
                 <p class="text-gray-600">استأجر سيارة بكل سهولة داخل المربعات السكنية.</p>
            </div>
            <div class="text-center">
                <i class="fas fa-theater-masks text-4xl mb-2 text-blue-600"></i>
                <h3 class="text-xl font-bold mb-2">الأنشطة الترفيهية</h3>
                <p class="text-gray-600">استمتع بالأنشطة الترفيهية المتوفرة داخل المربعات السكنية.</p>
           </div>
            <div class="text-center">
                 <i class="fas fa-suitcase-rolling text-4xl mb-2 text-blue-600"></i>
                <h3 class="text-xl font-bold mb-2">باقات سياحية</h3>
                 <p class="text-gray-600">اختر من الباقات السياحية المتنوعة.</p>
            </div>
            <div class="text-center">
                <i class="fas fa-ticket-alt text-4xl mb-2 text-blue-600"></i>
               <h3 class="text-xl font-bold mb-2">حجوزاتي</h3>
                 <p class="text-gray-600">تتبع جميع حجوزاتك في مكان واحد.</p>
            </div>

        </div>
    </section>
</main>
   <script>
        function toggleMenu() {
            const menu = document.getElementById('menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>
