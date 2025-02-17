<?php

//PODESAVANJE SESIJE NA POCETKU SVAKE SKRIPTE
ini_set('session.gc_maxlifetime', (60 * 60 * 24)); //duzina trajanja sesije je 1 dan
session_start();
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
$pdo = new PDO($dsn, $user, $pass, $options);


