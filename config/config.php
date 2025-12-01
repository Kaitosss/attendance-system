<?php 
    require __DIR__.'/../vendor/autoload.php';

    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__.'/..');
    $dotenv->load();

    $conn = new mysqli(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        $_ENV['DB_NAME'],
    );

    if($conn->connect_error){
        die('Connect failed: '.$conn->connect_error);
    }
?>