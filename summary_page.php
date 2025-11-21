<?php
session_start(); 

$dataFile = __DIR__ . '/data/registrations.json';

$success_message = ''; // ไม่ขึ้น Warning อีก
$last_submission = null;
// โหลดข้อมูล
$records = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $records = json_decode($json, true);
    if (!is_array($records)) $records = [];
}

// 3. สร้าง HTML สำหรับแสดงผลข้อมูลที่บันทึกไว้ทั้งหมด (Saved Registrations)
$resultHtml = '';
foreach ($records as $r) {
    $ename    = htmlspecialchars($r['name']    ?? '', ENT_QUOTES, 'UTF-8');
    $esurname = htmlspecialchars($r['surname'] ?? '', ENT_QUOTES, 'UTF-8'); 
    $eemail   = htmlspecialchars($r['email']   ?? '', ENT_QUOTES, 'UTF-8');
    $etel     = htmlspecialchars($r['tel']     ?? '', ENT_QUOTES, 'UTF-8');
    
    $resultHtml .= "
       <div class='border p-3 bg-white rounded mb-2 shadow-sm'>
          <strong>Name:</strong> {$ename} {$esurname}<br>
          <strong>Email:</strong> {$eemail}<br>
         <strong>Tel:</strong> {$etel}
        </div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    
    <link href="Style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=B612:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap');
    </style>
    
    <title>Registration Summary</title>
</head>

<body>
    <header class="header"> 
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

    <div class="container mt-5 mb-5" style="min-height: 70vh;">
        <div class="card shadow-sm p-4">
            <h3 class="mb-4 text-primary text-center">Registration Summary</h3>

            <div id="display-info" class="text-center mt-5 p-3 border rounded">
            <h4 class="text-center mb-3 text-secondary">Saved Registrations (<?= count($records) ?>)</h4>
            <?= $resultHtml ?>
                </div>
            
            <?php if ($success_message && $last_submission): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $success_message; ?>
                </div>
                
                <div class="text-center mt-4 p-3 border rounded" style="background-color: #fcf8e3;"> 
                    <h5 class="text-success">ฟอร์มที่กรอกมาล่าสุด</h5>
                    <p class="mb-1"><strong>Name:</strong> <?= htmlspecialchars($last_submission['name']) ?></p>
                    <p class="mb-1"><strong>SurName:</strong> <?= htmlspecialchars($last_submission['surname']) ?></p>
                    <p class="mb-1"><strong>Email:</strong> <?= htmlspecialchars($last_submission['email']) ?></p>
                    <p class="mb-0"><strong>Tel:</strong> <?= htmlspecialchars($last_submission['tel']) ?></p>
                </div>
            <?php endif; ?>
            
            <div class="d-flex justify-content-center mt-4">
                <a href="index.html" class="btn btn-secondary btn-lg">
                    <i class="fas fa-home me-2"></i> Go to Home Page
                </a>
            </div>
    </div> 

  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous">
    </script>
    
    <footer><div class="footerContainer">

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

        <div class="feedbut">
            <a href="feedback.html" class="py-2 px-3 rounded-3">Feedback</a>
        </div>

        <div class="up">
            <button class="btn-top" onclick="scrollToTop()">
                <i class="fa-solid fa-arrow-up"></i>
            </button>
        </div>
        
    </div>
    </footer>
    
    <script>
    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    </script>
    
    <?php
    // ล้าง Session หลังการแสดงผล เพื่อไม่ให้แสดงซ้ำเมื่อมีการ Refresh
    unset($_SESSION['success_message']);
    unset($_SESSION['last_submission']);
    unset($_SESSION['all_records']);
    ?>

</body>
</html>