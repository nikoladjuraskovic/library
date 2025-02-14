<?php

require "config.php";




$stmt = $pdo->query("SELECT 1 FROM Books");

$data = $stmt->fetch();

$stmt2 = $pdo->query("SELECT * FROM Books");

$pdo = null; //zatvaranje konekcije

?>

<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>

    <div class="container">

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
                <td>Amount</td>

            </tr>
            <?php
                while($row = $stmt2->fetch()) { ?>
                    <tr>
                        <td><?= $row['Title']?></td>
                        <td><?= $row['Author']?></td>
                        <td><?= $row['Year']?></td>
                        <td><?= $row['Amount']?></td>
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

</main>


<?php require "views/partials/footer.php"?>
