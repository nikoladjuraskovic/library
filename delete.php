<?php

require "config.php";

$stmt = $pdo->query("SELECT 1 FROM books");
$data = $stmt->fetch();

$stmt = $pdo->query("SELECT * FROM books");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $stmt2 = $pdo->prepare("DELETE FROM books WHERE BookID = :id");

    $stmt2->execute(array(":id" => $id));

    header('Location: delete.php');
}

$pdo = null; //zatvaranje konekcije

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Delete Books</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-5.3.3-dist/css/bootstrap.css">
</head>
<body>
        <div class="container">
            <a href="show.php">Books</a>
            <a href="insert.php">Insert book</a>
            <a href="delete.php">Delete book</a>
            <a href="edit.php">Edit books</a>
            <h2> Delete books</h2>

            <table class="table">
                <?php
                    if($data) {
                ?>

                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year</th>

                </tr>
                <?php
                    while ($row = $stmt->fetch()) {
                 ?>
                <tr>
                    <td><?= $row["Title"]?></td>
                    <td><?= $row["Author"]?></td>
                    <td><?= $row["Year"]?></td>
                    <td>
                    <form action="delete.php" method="post" id="form">
                        <input type="hidden" value="<?= $row["BookID"]?>" name="id">
                        <input type="submit" value="Delete book" class="btn btn-danger">
                    </form>
                    </td>
                </tr>

                <?php }
                    }
                ?>
            </table>

        </div>

<script src="insert.js"></script>
<script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>
