<?php
session_start();

// กำหนด path ไฟล์ JSON
$dataFile = __DIR__ . '/data/feedback.json';
$records = [];

// ถ้าไม่มีโฟลเดอร์ data ให้สร้าง
if (!is_dir(__DIR__ . '/data')) {
    @mkdir(__DIR__ . '/data', 0777, true);
}

// โหลด feedback เดิม
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $records = json_decode($json, true);
    if (!is_array($records)) $records = [];
}

// เมื่อส่งฟอร์ม
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $rating  = trim($_POST['rating'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // ตรวจสอบข้อมูล
    if ($name && $email && $rating && $message) {

        $new_feedback = [
            'name' => $name,
            'email' => $email,
            'rating' => $rating,
            'message' => $message,
            'time' => date("Y-m-d H:i:s")
        ];

        $records[] = $new_feedback;

        // บันทึกลงไฟล์
        if (file_put_contents($dataFile, json_encode($records, JSON_PRETTY_PRINT)) !== false) {
            echo "<script>
                alert('✓ ขอบคุณสำหรับความคิดเห็นของคุณ');
                window.location.href = 'index.html';
            </script>";
            exit;
        } else {
            echo "<script>alert('❌ ไม่สามารถบันทึกข้อมูลได้');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Feedback - EventHorizon</title>
  <link rel="stylesheet" href="CSS/Style.css">
  <link href="CSS/form-validation.css" rel="stylesheet">
  <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=B612:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap');
  </style>
</head>

<body class="headfeed">
  
    <header class="header"> <!-- ไตเติ้ล -->
        <div class="logo-section">
        <img src="./resources/photo.jpeg" alt="Logo" class="logo-img">

        <div class="site-name">
            <a href="index.html" class="title"><span class="empalphabet">E</span>VENT<span class="grp">HORIZON</span></a>
        </div>
        </div>

        <div class="nav-links">
        <a href="index.html">Home</a>
        <a href="register.php">Register</a>
        </div>
    </header>

<div class = "feedform-container">
  <form class="feedback-form" method="POST" action="feedback.php">
    <h2>FEEDBACK</h2>
    <label for="name">Name <span style="color: red;">*</span></label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>
    <label for="email">E-mail <span style="color: red;">*</span></label>
    <input type="email" id="email" name="email" placeholder="example@email.com" required>
    <label for="rating">Satisfaction level: <span style="color: red;">*</span></label>
    <select id="rating" name="rating" required>
      <option value="">-- Please rate the following --</option>
      <option value="5">Excellent (5)</option>
      <option value="4">Very Good (4)</option>
      <option value="3">Average (3)</option>
      <option value="2">Acceptable (2)</option>
      <option value="1">Needs Improvement (1)</option>
    </select>
    <label for="message">Additional comments <span style="color: red;">*</span></label>
    <textarea id="message" name="message" placeholder="Write your comment here..." required></textarea>
    <button type="submit">SUBMIT</button>
    <div class="success-message" id="success-message">
       ขอบคุณสำหรับความคิดเห็นของคุณ
    </div>
  </form>

  <script src="feedback-validation.js"></script>
  
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
        </div>
        
    </div>
  </footer>
</body>

</html>