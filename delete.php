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


<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>
<main>
        <div class="container">

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
</main>

<script src="insert.js"></script>
<script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<?php require "views/partials/footer.php"?>
