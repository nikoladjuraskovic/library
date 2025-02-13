<?php

require "config.php";

session_start();


$stmt = $pdo->query("SELECT 1 FROM rents");

$data = $stmt->fetch();

$userID = $_SESSION['id']; //dohvatimo ko je ulogovani korisnik
$sql = "SELECT * FROM rents WHERE UserID = :userID";
$stmt2 = $pdo->prepare($sql);
$stmt2->execute(['userID' => $userID]);


//$pdo = null; //zatvaranje konekcije

?>

<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>

    <div class="container">

        <h2>Rented books</h2>

        <br>

        <table class="table">
            <?php
            if($data) {
                ?>

                <tr>
                    <td>Title</td>
                    <td>Author</td>
                    <td>Approval</td>
                    <td>Returned</td>

                </tr>
                <?php
                while($row = $stmt2->fetch()) { ?>
                    <tr>
                        <td><?php

                            $bookSql = "SELECT * FROM books WHERE BookID = :bookID";
                            $stmt = $pdo->prepare($bookSql);
                            $stmt->execute(['bookID' => $row['BookID']]);
                            $bookData = $stmt->fetch();
                            echo $bookData['Title'];


                            ?>
                        </td>
                        <td><?= $bookData['Author']?></td>
                        <td><?= $row['Approved']?></td>
                        <td><?= $row['Returned']?></td>
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
