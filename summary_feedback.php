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
    <title>Feedback Summary</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

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

</body>
</html>
