<?php 
    require 'config/config.php';
    session_start();

    if(!$_SESSION['user_id']){
        header('Location: login.php');
        exit;
    }

    $message = '';
    $user_id = $_SESSION['user_id'];
    $date = date('Y-m-d');
    $time = date('H:i:s');

    $stmt = $conn->prepare('SELECT * FROM attendance WHERE user_id = ? AND date = ?');
    $stmt->bind_param('is',$user_id,$date);
    $stmt->execute();
    $result = $stmt->get_result();
    $attendance = $result->fetch_assoc();
    $stmt->close();

    if(isset($_POST['clock'])){
        if(!$attendance){
            $stmt = $conn->prepare("INSERT INTO attendance (user_id,date,time_in,status) VALUES (?,?,?,?)");
            $status = "มาปกติ";
            $stmt->bind_param("isss",$user_id,$date,$time,$status);
            $stmt->execute();
            $stmt->close();
            $message = "บันทึกเวลาเข้างานเรียบร้อย: $time";
        }
        else if($attendance['time_in'] && !$attendance['time_out']){
            $stmt = $conn->prepare("UPDATE attendance SET time_out=? WHERE user_id=? AND date=?");
            $stmt->bind_param("sis",$time,$user_id,$date);
            $stmt->execute();
            $stmt->close();
            $message = "บันทึกเวลาออกงานเรียบร้อย: $time";
        }
        else {
            $message = "วันนี้คุณบันทึกเวลาเข้าและออกแล้ว ไม่สามารถกดได้อีก";
        }
    }
?>  

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>หน้าแรก</title>
<link rel="stylesheet" href="styles/index.css">
</head>
<body>
<div class="container">
    <h2>ระบบเข้า-ออกงาน</h2>
    <?php if($message) echo "<p>$message</p>"; ?>
    <form method="POST">
        <button name="clock">กดเพื่อบันทึกเวลาเข้า/ออก</button>
    </form>
    <a href="logout.php">ออกจากระบบ</a>
</div>
</body>
</html>