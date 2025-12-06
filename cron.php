<?php 
require 'vendor/autoload.php';
require 'config/config.php';
use Cron\CronExpression;

$cron = new CronExpression('0 0 * * *');

if($cron->isDue()){
    updateAbsentStatus($conn);
}

function updateAbsentStatus($conn) {
    $today = date('Y-m-d');

     $stmt = $conn->prepare("
        INSERT INTO attendance (user_id, date, status)
        SELECT id, ?, 'ไม่มา' FROM users
        WHERE id NOT IN (
            SELECT user_id FROM attendance WHERE date = ?
        )
    ");
    $stmt->bind_param('ss', $today, $today);
    $stmt->execute();
}
?>