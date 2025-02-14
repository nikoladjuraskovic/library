<?php

require "config.php";


session_start(); //ne vidi $_SESSION ako ne stavim ovo.....

$stmt = $pdo->query("SELECT 1 FROM Books");

$data = $stmt->fetch();

$stmt2 = $pdo->query("SELECT * FROM Books");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $bookID = $_POST["BookID"]; //dohvatamo knjigu koju hoce da rentira korsnik
    $userID = $_SESSION["id"]; // citamo koji je to korisnik

    //ako knjiga nije odobrena onda kazemo da je vracena, iako nikad nije ni data
    $sql = "INSERT INTO rents (BookID, UserID, Approved, Returned) VALUES (:bookID, :userID, 'pending', '-')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["bookID" => $bookID, "userID" => $userID]); // ubacimo zahvtev za knjigu



}



$pdo = null; //zatvaranje konekcije

?>

<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>

    <div class="container">

        <h2>Books in Library</h2>

        <br>

        <?php if($_SERVER["REQUEST_METHOD"] == "POST") echo "Book succesfully rented!"  ?>
        <table class="table">
            <?php
            if($data) {
                ?>

                <tr>
                    <td>Title</td>
                    <td>Author</td>
                    <td>Year</td>
                    <td>Available copies</td>

                </tr>
                <?php
                while($row = $stmt2->fetch()) {

                    if($row['Amount'] > 0) {
                    //samo ako ima knjiga za rentu, onda ih prikazi
                    ?>
                    <tr>
                        <td><?= $row['Title']?></td>
                        <td><?= $row['Author']?></td>
                        <td><?= $row['Year']?></td>
                        <td><?= $row['Amount']?></td>
                        <td>
                            <form action="showAvailable.php" method="post">
                                <input type="submit" value="Request book" class="btn btn-outline-primary">
                                <input type="hidden" value="<?= $row['BookID']?>" name="BookID">
                            </form>

                        </td>
                    </tr>

                    <?php
                    }
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
