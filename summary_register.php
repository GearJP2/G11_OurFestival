<?php
// 1. รับค่าจากฟอร์ม
$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$tel = $_POST['tel'];

// 2. ตั้งค่าการเชื่อมต่อ Database (XAMPP Default)
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "event_db"; // ต้องตรงกับชื่อ Database ที่เราสร้างในขั้นตอนที่ 1

// สร้างการเชื่อมต่อ
$conn = mysqli_connect($servername, $username_db, $password_db, $dbname);

// เช็คว่าต่อติดไหม
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 3. คำสั่ง SQL บันทึกข้อมูล (INSERT)
$sql = "INSERT INTO users (name, surname, email, tel) VALUES ('$name', '$surname', '$email', '$tel')";
$save_status = "";

if (mysqli_query($conn, $sql)) {
    $save_status = "success"; // บันทึกสำเร็จ
} else {
    $save_status = "error: " . mysqli_error($conn); // บันทึกไม่ผ่าน
}

// ปิดการเชื่อมต่อ
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="Style.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=B612:ital,wght@0,400;0,700;1,400;1,700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100..900&display=swap');
    </style>
    <title>Summary Register</title>
</head>
<body>

    <script>
        // รับค่าสถานะจาก PHP มาเช็ค
        var status = "<?php echo $save_status; ?>";
        if(status == "success"){
            alert("บันทึกข้อมูลลงระบบสำเร็จเรียบร้อย! (Saved to Database)");
        } else {
            alert("เกิดข้อผิดพลาดในการบันทึก: " + status);
        }
    </script>

    <header class="header">
        <div class="logo-section">
            <img src="./resources/photo.jpeg" alt="Logo" class="logo-img"> 
            <div class="site-name">
                <a href="index.html" class="title"><span class="empalphabet">E</span>VENT<span class="grp">HORIZON</span></a>
            </div>
        </div>
        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="register.html">Register</a>
        </div>
    </header>

    <div class="container mt-5">
        <div class="card shadow-sm p-4">
            <h3 class="mb-4 text-success text-center">Registration Summary</h3>
            
            <?php if($save_status == "success"): ?>
                <div class="alert alert-success text-center" role="alert">
                    Data has been saved to XAMPP Database successfully!
                </div>
            <?php else: ?>
                <div class="alert alert-danger text-center" role="alert">
                    Database Error! Check your XAMPP connection.
                </div>
            <?php endif; ?>
            
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%" class="table-light">Name</th>
                            <td><?php echo $name; ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Surname</th>
                            <td><?php echo $surname; ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Email</th>
                            <td><?php echo $email; ?></td>
                        </tr>
                        <tr>
                            <th class="table-light">Tel</th>
                            <td><?php echo $tel; ?></td>
                        </tr>
                    </table>
                    
                    <div class="text-center mt-4">
                        <a href="index.html" class="btn btn-secondary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <div class="footerContainer">
            <div class="Address">
                <p>มหาวิทยาลัยธรรมศาสตร์ ศูนย์รังสิต<br>
                   99 หมู่ 18 ถนนพหลโยธิน ตำบลคลองหนึ่ง<br> 
                   อำเภอคลองหลวง จังหวัดปทุมธานี 12120</p>
            </div>
            <div class="Contact">
                <p>Contact US</p>
            </div>
            <div class="feedbut">
                <a href="feedback.html" class="py-2 px-3 rounded-3">Feedback</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>