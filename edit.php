<?php

require "config.php";

$stmt = $pdo->query("SELECT 1 FROM Books");
$data = $stmt->fetch();

$stmt = $pdo->query("SELECT * FROM books");

$pdo = null;


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

            <h2>Edit books</h2>

            <br>
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
                        while($row = $stmt->fetch()) {
                    ?>
                    <tr>
                        <td><?= $row['Title'] ?></td>
                        <td><?= $row['Author'] ?></td>
                        <td><?= $row['Year'] ?></td>
                        <td>
                            <form action="editBook.php" method="post">
                                <input type="hidden" value="<?= $row['BookID'] ?>" name="id" id="id" >
                                <input type="hidden" value="chooseBook" name="form_type" id="chooseBook">
                                <input type="submit" value="Edit book" class="btn btn-warning">

                            </form>
                        </td>
                    </tr>

                    <?php
                        }
                    } else {
                    ?>
                    <h3 style="color: red">No data</h3>
                    <?php } ?>
            </table>

            <br>



        </div>


        <script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>
</body>
</html>
