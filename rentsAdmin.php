<?php

require "config.php";

if(!isset($_SESSION['username'])) //if logged out, redirect to home page
    header("Location: index.php");

if($_SESSION['role'] != "admin") //if someone is not admin, then redirect
    header("Location: index.php");


$stmt = $pdo->query("SELECT 1 FROM rents");

$data = $stmt->fetch();

$userID = $_SESSION['id']; //dohvatimo ko je ulogovani korisnik
//$sql = "SELECT * FROM rents"; //dohvatamo sve rente jer sam admin
$sql = "SELECT RentID, rents.BookID, rents.UserID, Approved, Returned,
        Title, Author, Amount, username FROM rents
        JOIN books ON books.BookID = rents.BookID
        JOIN users ON users.UserID = rents.UserID;";
$stmt2 = $pdo->query($sql);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $clickedButton = $_POST['button'];
    $rentID = $_POST['rentID']; // dohvatamo da vidimo koja je renta u pitanju
    $bookID = $_POST['bookID']; // dohvatamo koju knjigu odobravamo/odbijamo za rentu

    //check which button in the form was clicked
    if($clickedButton == "Approve"){
        echo 'Approved';
        /*
         * Ako je renta odobrena, to znaci da treba u bazi promeniti:
         * 1. Amount u Books tabeli za tu knjigu smanjiti za 1. User ne moze rentirati knjigu ako ih nema dovoljno, to je
         * reseno u showAvailable.php stranici.
         * 2. Promeniti Approved u Approved u rent tabeli, Returned ostaje -
         *
         * */
        $sql3 = "UPDATE books SET Amount = Amount - 1 WHERE BookID = :bookID";
        $stmt5 = $pdo->prepare($sql3);
        $stmt5->execute(array('bookID' => $bookID));

        $sql2 = "UPDATE rents SET Approved = 'Approved' WHERE rentID = :rentID";
        $stmt4 = $pdo->prepare($sql2);
        $stmt4->execute(array(':rentID' => $rentID));

    } else if($clickedButton == "Decline"){
        echo 'Declined';
        /*
         * Ako se renta odbije,a to znaci da treba u bazi promeniti:
         * 1. Approved u tabeli rent staviti na Declined i returned ostaviti na -
         * */
        $sql = "UPDATE rents SET Approved = 'Declined' WHERE rentID = :rentID";
        $stmt3 = $pdo->prepare($sql);
        $stmt3->execute([':rentID' => $rentID]);
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

        <form action="rentsAdminPdf.php" method="get" target="_blank">
            <input type="submit" name="submit" value="Export to pdf" class="btn btn-danger">
        </form>
        
        <table class="table">
            <?php
            if($data) {
                ?>

                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Approval</th>
                    <th>Returned</th>
                    <th>Available book copies</th>
                    <th>User</th>
                    <th>Status</th>

                </tr>
                <?php
                while($row = $stmt2->fetch()) { ?>
                    <tr>
                        <td><?=$row['Title']?></td>
                        <td><?= $row['Author']?></td>
                        <td><?= $row['Approved']?></td>
                        <!--Mark red to admin if a book is approved and not returned yet-->
                        <?php if($row['Approved'] === 'Approved' && $row['Returned'] === '-') : ?>
                            <td style="color:red">NOT Returned</td>
                        <?php else : ?> <!--otherwise, print from database-->
                            <td><?= $row['Returned']?></td>
                        <?php endif; ?>
                        <td><?= $row['Amount']?></td>
                        <td><?= $row['username']?></td>
                        <td>
                    <!--Discuss various cases whether the book rent is waiting approval or denial,
                    or whether it is approved or denied-->
                            <form action="rentsAdmin.php" method="post">
                                <div style="display: flex">
                                    <?php if($row["Approved"] === "pending") : ?>
                                        <input type="submit" value="Approve" name="button" class="btn btn-outline-success">&emsp;
                                        <input type="submit" value="Decline" name="button" class="btn btn-outline-danger">
                                    <?php else : if($row['Approved'] === 'Declined') :?>
                                        <span style="color: red">Book rent declined</span>
                                    <?php else : if($row['Approved'] === 'Approved') :?>
                                        <span style="color: darkgreen">Book rent approved</span>
                                    <?php endif; endif;  endif;?>
                                    <input type="hidden" value="<?=$row['RentID']?>" name="rentID">
                                    <input type="hidden" value="<?=$row['BookID']?>" name="bookID">
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
