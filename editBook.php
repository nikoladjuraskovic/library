<?php

require "config.php";

if(!isset($_SESSION['username'])) //if logged out, redirect to home page
    header("Location: index.php");

if($_SESSION['role'] != "admin") //if someone is not admin, then redirect
    header("Location: index.php");


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
        $amount = $_POST["Amount"];

        $stmt = $pdo->prepare("UPDATE books SET Title = :Title, Author = :Author, Year = :Year, Amount = :Amount WHERE bookID = :bookID");
        $stmt->execute(["bookID" => $bookID, "Title" => $bookTitle, "Author" => $bookAuthor, "Year" => $bookYear, "Amount" => $amount]);


        $pdo = null;

        //so that we cannot post multiple times in a row
        header('Location: show.php');
    }
}


?>

<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>
        <div class="container">


            <h2>Edit book</h2>

            <br>

            <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" id="editForm">

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
                    <label for="Amount">Amount:</label>
                    <input type="number" value="<?= $row["Amount"] ?>" name="Amount" id="Amount" class="form-control" required>
                </div>
                <br>
                <div class="form-group">
                    <input type="hidden" value="editBook" name="form_type" id="editBook">
                    <input type="submit" value="Edit book" class="btn btn-warning">
                </div>


            </form>

        </div>

</main>
        <script src="editBook.js"></script>
        <script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>

<?php require "views/partials/footer.php"?>