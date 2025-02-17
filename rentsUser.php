<?php

require "config.php";




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
    $bookID = $_POST['BookID'];
    $amount = $_POST['Amount'];
    $sql2 = "UPDATE rents SET Returned = 'Returned' WHERE RentID = :RentID";
    $stmt3 = $pdo->prepare($sql2);
    $stmt3->execute(['RentID' => $rentID]);


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
                    <th>Title</th>
                    <th>Author</th>
                    <th>Approval</th>
                    <th>Returned</th>
                    <th>Status</th>

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
                        <!--Discuss various cases whether a book rent is pending, declined or accepted
                        and then waiting for it to be returned-->
                            <form action="rentsUser.php" method="post">
                                <?php if($row['Approved'] === 'Approved' && $row['Returned'] === '-') : ?>
                                    <input type="submit" value="Return book" class="btn btn-outline-info">
                                    <?php else: if($row['Returned'] === 'Returned') : ?>
                                        <span style="color: darkgreen">Book returned</span>
                                    <?php else: if($row['Approved'] === 'pending' && $row['Returned'] === '-') : ?>
                                        <span style="color: darkgoldenrod">Book rent pending approval</span>
                                        <?php else: if($row['Approved'] === 'Declined') : ?>
                                            <span style="color: red">Book rent declined</span>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <input type="hidden" value="<?= $row['RentID']?>" name="RentID">
                                <input type="hidden" value="<?= $row['BookID']?>" name="BookID">
                                <input type="hidden" value="<?= $bookData['Amount']?>" name="Amount">
                            </form>



                        </td>
                    </tr>

                <?php } ?>

            <?php } else { ?>
                <h3 style="color: red">No data</h3>
            <?php } ?>


        </table>

    </div>

</main>


<?php require "views/partials/footer.php"?>
