<?php

require "config.php";

if(!isset($_SESSION['username'])) //if logged out, redirect to home page
    header("Location: index.php");


$stmt = $pdo->query("SELECT 1 FROM Books");
$data = $stmt->fetch();

$stmt = $pdo->query("SELECT * FROM books");

$pdo = null;


?>


<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>
        <div class="container">


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
                        <th>Amount</th>
                    </tr>

                    <?php
                        while($row = $stmt->fetch()) {
                    ?>
                    <tr>
                        <td><?= $row['Title'] ?></td>
                        <td><?= $row['Author'] ?></td>
                        <td><?= $row['Year'] ?></td>
                        <td><?= $row['Amount'] ?></td>
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

</main>
<script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<?php require "views/partials/footer.php"?>
