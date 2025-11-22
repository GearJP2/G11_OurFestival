<?php
session_start();

// Path ไฟล์ feedback.json
$dataFile = __DIR__ . '/data/feedback.json';

// โหลดข้อมูล
$records = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $records = json_decode($json, true);
    if (!is_array($records)) $records = [];
}
?>
<!DOCTYPE html>
<html lang="th">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link href="CSS/Style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=B612:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap');
    </style>
    <title>Feedback Summary</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Noto Sans Thai", sans-serif;
        }
        .feedback-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .rating-box {
            font-size: 18px;
            font-weight: bold;
            color: #ff9800;
        }
    </style>
</head>

<body>
    
<header class="header">
    <div class="logo-section">
        <img src="./resources/photo.jpeg" alt="Logo" class="logo-img">

        <div class="site-name">
            <a href="index.html" class="title">
                <span class="empalphabet">E</span>VENT<span class="grp">HORIZON</span>
            </a>
        </div>
    </div>

    <div class="nav-links">
        <a href="index.html">Home</a>
        <a href="register.php">Register</a>
    </div>
</header>

    <div class="container mt-5 mb-5">
        <h2 class="text-center text-primary mb-4">Feedback Summary</h2>

        <div class="text-center mb-4">
            <h5 class="text-secondary">จำนวนความคิดเห็นทั้งหมด: <?= count($records) ?></h5>
        </div>

        <?php if (empty($records)) : ?>
            <div class="alert alert-warning text-center">ยังไม่มี Feedback ในระบบ</div>
        <?php else : ?>

            <?php foreach ($records as $fb): ?>
                <div class="feedback-card mb-3">
                    <p><strong>ชื่อ:</strong> <?= htmlspecialchars($fb['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($fb['email']) ?></p>
                    <p><strong>ระดับความพึงพอใจ:</strong> 
                        <span class="rating-box"><?= str_repeat("⭐", $fb['rating']) ?></span>
                        (<?= $fb['rating'] ?>/5)
                    </p>
                    <p><strong>ความคิดเห็นเพิ่มเติม:</strong><br>
                        <?= nl2br(htmlspecialchars($fb['message'])) ?>
                    </p>
                    <p class="text-muted" style="font-size: 14px;">
                        <strong>เวลา:</strong> <?= $fb['time'] ?>
                    </p>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="index.html" class="btn btn-secondary btn-lg">กลับสู่หน้าแรก</a>
        </div>

    </div>
<footer><!-- ไบร์ท -->
    <div class="footerContainer">

        <div class="Address">
            <p>มหาวิทยาลัยธรรมศาสตร์ ศูนย์รังสิต<br>
                99 หมู่ 18 ถนนพหลโยธิน ตำบลคลองหนึ่ง<br> 
                อำเภอคลองหลวง จังหวัดปทุมธานี 12120</p>
        </div>
        
        <div class="Contact">
            <p>Contact US</p>
            <div Class="list">
                <a href=""><i class="fa-brands fa-facebook"></i></a>
                <a href=""><i class="fa-brands fa-instagram"></i></a>
                <a href=""><i class="fa-brands fa-twitter"></i></a>
                <a href=""><i class="fa-brands fa-youtube"></i></a>
            </div>  
        </div>

        <div class="rightside">
            <div class="feedbut">
                <a href="feedback.php" class="py-2 px-3 rounded-3">Feedback</a>
            </div>
            <div class="up">
                <button class="btn-top" onclick="scrollToTop()">
                     <i class="fa-solid fa-arrow-up"></i>
                    </button>
            </div>
        </div>
        
    </div>
  </footer>

  <script>
    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  </script>

</body>
</html>
