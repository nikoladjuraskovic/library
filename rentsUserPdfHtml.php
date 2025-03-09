<?php
require_once "config.php";

if(!isset($_SESSION['username'])) //if logged out, redirect to home page
    header("Location: index.php");


$stmt = $pdo->query("SELECT 1 FROM rents");

$data = $stmt->fetch();

$userID = $_SESSION['id']; //dohvatimo ko je ulogovani korisnik

$sql = "SELECT RentID, rents.BookID, UserID, Approved, Returned, Title, Author, Amount FROM rents 
            JOIN books ON books.BookID = rents.BookID WHERE UserID = :userID";
$stmt2 = $pdo->prepare($sql);
$stmt2->execute(['userID' => $userID]);


?>

<style>
    *{
        font-family: sans-serif;
    }
    table, th, td{
        border: 2px solid #564b4b;
        border-collapse: collapse;
    }

    th, td{
        padding: 5px 5px;
    }

    .container {
        width: 80%;
        margin: auto;
        overflow: hidden;
    }


</style>



<div class="container">

    <h2>Rented books <?= $_SESSION['username']?> report</h2>

    <br>

    <table>
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

                            <?php if($row['Approved'] === 'Approved' && $row['Returned'] === '-') : ?>
                                <span style="color: dodgerblue">Book rent pending return</span>
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

                    </td>
                </tr>

            <?php } ?>

        <?php } else { ?>
            <h3 style="color: red">No data</h3>
        <?php } ?>


    </table>

    <h4>Library-<?=$_SESSION['username']?> &copy; <?= date("d.m.Y. H:i\h") ?>  </h4>

</div>

