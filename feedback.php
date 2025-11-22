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
                alert('ขอบคุณสำหรับความคิดเห็นของคุณ');
                window.location.href = 'index.html';
            </script>";
            exit;
        } else {
            echo "<script>alert('ไม่สามารถบันทึกข้อมูลได้');</script>";
        }
    }
}
?>
  




<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Feedback</title>
  <link rel="stylesheet" href="Style.css">
  <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=B612:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap');
    </style>
</head>

<body class= "headfeed" >
  
  <form class="feedback-form" method="POST" action="feedback.php">
    <h2>FEEDBACK</h2>

    <label for="name">Name</label>
    <input type="text" id="name" name="name" placeholder="Enter your name" required>

    <label for="email">E-mail</label>
    <input type="email" id="email" name="email" placeholder="example@email.com" required>

    <label for="rating">Satisfaction level:</label>
    <select id="rating" name="rating" required>
      <option value="">-- Please rate the following --</option>
      <option value="5">Excellent (5)</option>
      <option value="4">Very Good (4)</option>
      <option value="3">Average (3)</option>
      <option value="2">Acceptable (2)</option>
      <option value="1">Needs Improvement (1)</option>
    </select>

    <label for="message">Additional comments</label>
    <textarea id="message" name="message" placeholder="Write your comment here..." required></textarea>

    <button type="submit">SUBMIT</button>

    <div class="success-message" id="success-message">
       ขอบคุณสำหรับความคิดเห็นของคุณ
    </div>
  </form>

  <script>
    function showMessage(event) {
      event.preventDefault();
      document.getElementById("success-message").style.display = "block";
      event.target.reset();
    }
  </script>

</body>

</html>

