<?php

require "config.php";




$stmt = $pdo->query("SELECT 1 FROM Books");

$data = $stmt->fetch();

$stmt2 = $pdo->query("SELECT * FROM Books");

$pdo = null; //zatvaranje konekcije

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Books table</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="container">

        <a href="show.php">Books</a>
        <a href="insert.php">Insert book</a>
        <a href="delete.php">Delete book</a>
        <a href="edit.php">Edit books</a>
        
        <h2>Books in Library</h2>

        <br>

        <table class="table">
            <?php
                if($data) {
            ?>

            <tr>
                <td>Title</td>
                <td>Author</td>
                <td>Year</td>

            </tr>
            <?php
                while($row = $stmt2->fetch()) { ?>
                    <tr>
                        <td><?= $row['Title']?></td>
                        <td><?= $row['Author']?></td>
                        <td><?= $row['Year']?></td>
                    </tr>
                    
            <?php
                }
                } else{
            ?>
            <h3 style="color: red">No data</h3>
            <?php   }
                ?>


        </table>

    </div>

</body>
</html>
