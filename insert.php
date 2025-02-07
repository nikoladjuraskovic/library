<?php

require "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $title = $_POST["title"];
    $author = $_POST["author"];
    $year = intval($_POST["year"]);

    $stmt = $pdo->prepare("INSERT INTO books(title, author, year) VALUES(:title, :author, :year)");
    $stmt->execute(["title" => $title, "author" => $author, "year" => $year]);


    $pdo = null;
    header("location: show.php");
}

$pdo = null; //zatvaranje konekcije



?>


<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>
<main>
        <div class="container">


            <h2>Insert book</h2>

            <form action="insert.php" method="post" id="form">

                <div id="greska">

                </div>

                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" name="title" id="title" class="form-control" required>

                    <div class="invalid-feedback">
                        Please provide a valid title
                    </div>
                </div>

                <br>

                <div class="form-group">
                    <label for="author">Author:</label>
                    <input type="text" name="author" id="author" class="form-control" required>

                    <div class="invalid-feedback">
                        Please provide a valid author name
                    </div>
                </div>

                <br>

                <div class="form-group">
                    <label for="year">Year:</label>
                    <input type="number" name="year" id="year" class="form-control" required>

                    <div class="invalid-feedback">
                        Please provide a valid year
                    </div>
                </div>

                <br>

                <div class="form-group">
                    <input type="submit" value = "Insert book" class="btn btn-success">
                </div>


            </form>
        </div>
</main>
        <script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>
        <script src="insert.js"></script>


<?php require "views/partials/footer.php"?>