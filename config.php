<?php

//PODESAVANJE SESIJE NA POCETKU SVAKE SKRIPTE
ini_set('session.gc_maxlifetime', (60 * 60 * 24)); //duzina trajanja sesije je 1 dan
session_start();

/*
 * We display the username and role on every web page using the flash message technique
 * */

if(isset($_SESSION['username'])){
    $usernameNav = $_SESSION['username'];
    $roleNav = $_SESSION['role'];
}


$host = 'localhost'; //127.0.0.1
$db = 'library';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';


$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {

    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (Exception $e) {
    echo 'Error Message: ' . $e->getMessage() . PHP_EOL;
    echo 'Error Code: ' . $e->getCode() . PHP_EOL;
    //NOTE it is better to show the user(client) just that a server error occurred
    //and make the details visible only to the server
}


