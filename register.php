<?php
// 1. ต้องเป็นคำสั่งแรกสุด
session_start(); 

// กำหนด Path ไฟล์
$dataFile = __DIR__ . '/data/registrations.json';
$records = [];
$error = '';

// กำหนดค่าเริ่มต้นตัวแปร
$name    = '';
$surname = '';
$email   = '';
$tel     = '';

if (!is_dir(__DIR__ . '/data')) {
    @mkdir(__DIR__ . '/data', 0777, true);
}

// โหลดข้อมูลเดิม
if (file_exists($dataFile)) {
    $json_data = file_get_contents($dataFile);
    $records = json_decode($json_data, true);
    if (!is_array($records)) $records = [];
}

// 2. ส่วนประมวลผลเมื่อกด SUBMIT (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // รับค่าจากฟอร์ม
    $name    = trim($_POST['name']    ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $email   = trim($_POST['email']   ?? '');
    $tel     = trim($_POST['tel']     ?? '');

    // ตรวจสอบว่ากรอกครบไหม
    if ($name && $surname && $email && $tel) {
        
        // เพิ่มข้อมูลใหม่ลงใน Array
        $new_entry = [
            'name'    => $name, 
            'surname' => $surname, 
            'email'   => $email, 
            'tel'     => $tel,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        $records[] = $new_entry;

        if (file_put_contents($dataFile, json_encode($records, JSON_PRETTY_PRINT)) !== false) {
            
            $_SESSION['success_message'] = "Your information has been successfully registered!";
            $_SESSION['last_submission'] = $new_entry;
            $_SESSION['all_records'] = $records;

            echo "<script>
                alert('✓ ลงทะเบียนสำเร็จ! ขอบคุณที่ลงทะเบียนกับเรา');
                window.location.href = 'index.html';
            </script>";
            exit;
        } else {
            $error = 'Error: Unable to write to data/registrations.json. Please check folder permissions.';
        }
    } else {
        $error = 'Please fill in all required fields!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="CSS/Style.css" rel="stylesheet">
    <link href="form-validation.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=B612:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap');
    </style>
    <title>Register - EventHorizon</title>
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

    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            <h3 class="mb-4 text-primary text-center">Registration Form</h3>
            
            <?php if ($error): ?>
                 <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>❌ Error:</strong> <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                 </div>
            <?php endif; ?>

            <form class="row g-3" method="POST" action="register.php" novalidate>
                <div class="col-12">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required value="<?= htmlspecialchars($name) ?>" placeholder="กรอกชื่อของคุณ">
                </div>
                
                <div class="col-12">
                    <label for="surname" class="form-label">Surname <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="surname" name="surname" required value="<?= htmlspecialchars($surname) ?>" placeholder="กรอกนามสกุลของคุณ">
                </div>
                
                <div class="col-12">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($email) ?>" placeholder="example@email.com">
                </div>
                
                <div class="col-md-12">
                    <label for="tel" class="form-label">Tel <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tel" name="tel" placeholder="0xx-xxx-xxxx" required value="<?= htmlspecialchars($tel) ?>">
                </div>

                <div class="col-12 d-flex align-items-center justify-content-center mt-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="gridCheck" required>
                        <label class="form-check-label" for="gridCheck">
                            Click here to receive updates and benefits. <span class="text-danger">*</span>
                        </label>
                    </div>
                </div>
                
                <div class="col-12 d-flex align-items-center justify-content-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5">SUBMIT</button>
                </div>
            </form>
        </div>
    </div> 

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    
    <script src="register-validation.js"></script>

    <footer>
        <div class="footerContainer">
            <div class="Address">
                <p>มหาวิทยาลัยธรรมศาสตร์ ศูนย์รังสิต<br>
                99 หมู่ 18 ถนนพหลโยธิน ตำบลคลองหนึ่ง<br> 
                อำเภอคลองหลวง จังหวัดปทุมธานี 12120</p>
            </div>
            <div class="Contact">
                <p>Contact US</p>
                <div class="list">
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