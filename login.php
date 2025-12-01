<?php 
    session_start();
    require 'config/config.php';

    $error = '';

    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if($result && password_verify($password,$result['password'])){
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['user'] = $result['name']; 
            header('Location: index.php');
        }
        else{
            $error = "Email หรือ Password ไม่ถูกต้อง";
        }
    }   
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login ระบบเข้า-ออกงาน</title>
<link rel="stylesheet" href="styles/login.css">
</head>
<body>
<div class="container">
    <h2>เข้าสู่ระบบ</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button name="login">Login</button>
    </form>
</div>
</body>
</html>