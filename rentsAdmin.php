<?php

require "config.php";

session_start();


$stmt = $pdo->query("SELECT 1 FROM rents");

$data = $stmt->fetch();

$userID = $_SESSION['id']; //dohvatimo ko je ulogovani korisnik
$sql = "SELECT * FROM rents"; //dohvatamo sve rente jer sam admin
$stmt2 = $pdo->query($sql);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $clickedButton = $_POST['button'];
    $rentID = $_POST['rentID']; // dohvatamo da vidimo koja je renta u pitanju

    if($clickedButton == "Approve"){
        echo 'Approved';
        /*
         * Ako je renta odobrena, to znaci da treba u bazi promeniti:
         * 1. Amount u Books tabeli za tu knjigu smanjiti za 1 i izvrsiti proveru da li moze da ne ode u negativni broj
         * 2. Promeniti Approved u yes u rent tabeli i Returned u no
         *
         * */

    } else if($clickedButton == "Decline"){
        echo 'Declined';
        /*
         * Ako je renta odbije,a to znaci da treba u bazi promeniti:
         * 1. Approved u tabeli rent staviti na no i returned ostaviti na -
         * */

    }
}



//$pdo = null; //zatvaranje konekcije

/*
 * Na ovoj stranici dohvatam sva iznajmljivanja knjiga koje admin moze da odbije ili prihvati
 *
 * */

?>

<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>

    <div class="container">

        <h2>Rented books Approvals</h2>

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
                    <td>Available book copies</td>
                    <td>User</td>

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
                        <td><?= $bookData['Amount']?></td>
                        <td><?php

                            $userSql = "SELECT * FROM users WHERE UserID = :userID";
                            $stmt = $pdo->prepare($userSql); //iz rente dohvatam koji je user
                            $stmt->execute(['userID' => $row["UserID"]]);
                            $userData = $stmt->fetch();
                            echo $userData['username'];


                            ?>
                        </td>
                        <td>
                            <!--forma za prihvatanje/odbijanje rente-->
                            <form action="rentsAdmin.php" method="post">
                                <div style="display: flex">
                                    <input type="submit" value="Approve" name="button" class="btn btn-outline-success">
                                    &emsp;
                                    <input type="submit" value="Decline" name="button" class="btn btn-outline-danger">
                                    <input type="hidden" value="<?=$row['RentID']?>" name="rentID">
                                </div>
                            </form>
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
