<?php

use Books\Book;



require "Book.php";
//require "vendor/autoload.php";

echo "Test!" . PHP_EOL;

require "config.php";

/*
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


*/






$stmt = $pdo->query('SELECT * FROM books');
while($row = $stmt->fetch()){
    echo $row['Title'] . PHP_EOL;
}

echo PHP_EOL;

$year = 2010;
$stmt = $pdo->prepare('SELECT * FROM books WHERE Year > ?');
$stmt->execute([$year]);
$book = $stmt->fetch();

var_dump($book);

$year = 1954;
$stmt = $pdo->prepare('SELECT * FROM books WHERE Year = :year');
$stmt->execute(['year' => $year]);
$book = $stmt->fetch();

var_dump($book);


$sql = "INSERT INTO books (Title, Author, Year) VALUES(:title, :author, :year)";
$stmt = $pdo->prepare($sql);
$stmt->execute([":title" => "Test Book", ":author" => "Test Author", ":year" => 2024]);


$sql = "UPDATE books SET Year = :year WHERE Title = 'Test Book'";
$stmt = $pdo->prepare($sql);
$stmt->execute(['year' => 2025]);


$sql = "DELETE FROM books WHERE Title = :title";
$stmt = $pdo->prepare($sql);
$stmt->execute(['title' => 'Test Book']);


/*
 * Dohvata podatke iz baze jedan po jedan
 * */
$stmt = $pdo->query("SELECT * FROM books");
foreach($stmt as $row){
    echo $row['Title'] . PHP_EOL;
}


$book = new Book("sg", "sg", 12);
$book2 = new Book("sfds", "sfds", 12);

/*
$stmt = $pdo->query('SELECT * FROM books');
$books = $stmt->fetchAll(PDO::FETCH_CLASS, "Book");

var_dump($books);

*/

$stmt = $pdo->prepare("SELECT Title FROM books WHERE BookID = :id");
$stmt->execute(["id" => 1]);
$title = $stmt->fetchColumn();
echo "Naslov: " . $title . PHP_EOL;

$count = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
echo "Broj knjiga: " . $count . PHP_EOL;

$data = $pdo->query("SELECT Title FROM books")->fetchAll(PDO::FETCH_ASSOC);
var_dump($data);

$data = $pdo->query("SELECT Title FROM books")->fetchAll(PDO::FETCH_COLUMN);
var_dump($data);

$data = $pdo->query("SELECT Title, Author FROM books")->fetchAll(PDO::FETCH_KEY_PAIR);
var_dump($data);


$data = $pdo->query("SELECT * FROM books")->fetchAll(PDO::FETCH_UNIQUE);
var_dump($data);

$data = $pdo->query("SELECT * FROM books WHERE Year = 2010")->fetchAll();
if($data)
{
    echo "Ima podataka\n";
} else{
    echo "Nema podataka\n";
}

echo 'Kraj skripte' . PHP_EOL;