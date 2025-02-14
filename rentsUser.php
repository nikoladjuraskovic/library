<?php

require "config.php";

session_start();


$stmt = $pdo->query("SELECT 1 FROM rents");

$data = $stmt->fetch();

$userID = $_SESSION['id']; //dohvatimo ko je ulogovani korisnik
$sql = "SELECT * FROM rents WHERE UserID = :userID";
$stmt2 = $pdo->prepare($sql);
$stmt2->execute(['userID' => $userID]);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    /*
     * Ako vracamo rentu mozemo je obrisati iz baze ili bolje zadrzati podatke ko je iznajmio knjigu
     *
     * 1. Azurirati podatak Returned u rents da je knjiga vracena
     * 2. U tabeli Books u koloni Amount povecati Amount za 1
     *
     * */

    $rentID = $_POST['RentID'];
    $sql2 = "UPDATE rents SET Returned = 'Returned' WHERE RentID = :RentID";
    $stmt3 = $pdo->prepare($sql2);
    $stmt3->execute(['RentID' => $rentID]);

    /*Prvo treba iz rente dohvatiti bookId i onda promeniti kolicinu knjiga*/
    $sql3 = "SELECT BookID FROM rents WHERE RentID = :RentID";
    $stmt4 = $pdo->prepare($sql3);
    $stmt4->execute(['RentID' => $rentID]);
    $book = $stmt4->fetch(); // $book je array sa jednim elementom
    //var_dump($book);
    $bookID = $book['BookID'];
    $sql4 = "UPDATE books SET Amount = Amount + 1 WHERE BookID = :BookID";
    $stmt5 = $pdo->prepare($sql4);
    $stmt5->execute(['BookID' => $bookID]);

}


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
                            //TODO prebaciti u backend deo gore
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
                        <td>
                            <?php
                            //samo ako je renta odobrena i ako knjiga nije vracena, onda omoguci vracanje knjige
                            if($row['Approved'] == "Approved" && $row['Returned'] != "Returned") {
                            ?>
                            <form action="rentsUser.php" method="post">
                                <input type="submit" value="Return book" class="btn btn-outline-info">
                                <input type="hidden" value="<?= $row['RentID']?>" name="RentID">
                            </form>
                            <?php } else{ ?>
                            <form action="rentsUser.php" method="get">
                                <input type="submit" value="Rent pending, rejected or book returned" class="btn btn-outline-danger" disabled>
                                <input type="hidden" value="<?= $row['RentID']?>" name="RentID">
                            </form>
                            <?php } ?>
                        </td>
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
