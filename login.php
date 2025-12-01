<?php 

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
    
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button name="login">Login</button>
    </form>
</div>
</body>
</html>