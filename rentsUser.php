<?php

require "config.php";

if(!isset($_SESSION['username'])) //if logged out, redirect to home page
    header("Location: index.php");


$stmt = $pdo->query("SELECT 1 FROM rents");

$data = $stmt->fetch();

$userID = $_SESSION['id']; //dohvatimo ko je ulogovani korisnik

$sql = "SELECT RentID, rents.BookID, UserID, Approved, Returned, Title, Author, Amount FROM rents 
            JOIN books ON books.BookID = rents.BookID WHERE UserID = :userID";
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
                        <td><?= $row['Title'];?></td>
                        <td><?= $row['Author']?></td>
                        <td><?= $row['Approved']?></td>
                        <td><?= $row['Returned']?></td>
                        <td>
                        <!--Discuss various cases whether a book rent is pending, declined or accepted
                        and then wait for it to be returned-->
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
                                <input type="hidden" value="<?= $row['Amount']?>" name="Amount">
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
