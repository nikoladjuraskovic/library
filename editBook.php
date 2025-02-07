<?php

require "config.php";




if($_SERVER["REQUEST_METHOD"] == "POST") {


/*
 * Dvema formama pristupamo ovoj stranici POST metodom:
 * 1. kada dolazimo do stranice editBook.php iz edit.php
 * 2. kada popunjavamo formu za izmenu podataka i potvrdjujemo izmenu tj. iz editBook.php idemo opet u editBook.php
 * Zato se pitamo koja je forma submit-ovana da bi znali sta da radimo.
 *
 * */

    if($_POST["form_type"] == "chooseBook")
    {

        //echo "CHOOSE BOOK";

        $bookID = $_POST['id'];

        $stmt = $pdo->prepare("SELECT * FROM books WHERE bookID = :bookID");
        $stmt->execute(['bookID' => $bookID]);
        $row = $stmt->fetch();
    }

    else if ($_POST["form_type"] == "editBook") {

        //echo "EDIT BOOK";

        $bookID = $_POST["BookID"];
        $bookTitle = $_POST["Title"];
        $bookAuthor = $_POST["Author"];
        $bookYear = $_POST["Year"];

        $stmt = $pdo->prepare("UPDATE books SET Title = :Title, Author = :Author, Year = :Year WHERE bookID = :bookID");
        $stmt->execute(["bookID" => $bookID, "Title" => $bookTitle, "Author" => $bookAuthor, "Year" => $bookYear]);


        $pdo = null;

        header('Location: show.php');
    }
}


?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit book</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.css">
</head>
<body>
        <div class="container">
            <a href="show.php">Books</a>
            <a href="insert.php">Insert book</a>
            <a href="delete.php">Delete book</a>
            <a href="edit.php">Edit books</a>

            <h2>Edit book</h2>

            <br>

            <form action="editBook.php" method="post" id="editForm">

                <div id="greska"></div>

                <br>

                <div class="form-group">
                    <label for="BookID">Book ID:</label>
                    <input type="number" value="<?= $row["BookID"] ?>" name="BookID" id="BookID" class="form-control" readonly>
                </div>
                <br>
                <div class="form-group">
                    <label for="Title">Title:</label>
                    <input type="text" value="<?= $row["Title"] ?>" name="Title" id="Title" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="Author">Author:</label>
                    <input type="text" value="<?= $row["Author"] ?>" name="Author" id="Author" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <label for="Year">Year:</label>
                    <input type="number" value="<?= $row["Year"] ?>" name="Year" id="Year" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <input type="hidden" value="editBook" name="form_type" id="editBook">
                    <input type="submit" value="Edit book" class="btn btn-warning">
                </div>


            </form>

        </div>

        <script src="editBook.js"></script>
        <script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>
