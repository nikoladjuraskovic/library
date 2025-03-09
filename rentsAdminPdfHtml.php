<?php


require_once "config.php";

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


?>

<style>
    *{
        font-family: sans-serif;
    }
    table, th, td{
        border: 2px solid #564b4b;
        border-collapse: collapse;
        /*background-color: aliceblue;*/
    }

    th, td{
        padding: 5px 5px;
    }

    /*
    tr:nth-child(even) td{
        background-color: lightsteelblue;
    }
    */


    .container {
        width: 80%;
        margin: auto;
        overflow: hidden;
    }


</style>



<div class="container">

<h2>Rented books Approvals Report</h2>

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

    <h4>Library &copy; <?= date("d.m.Y H:i\h") ?>  </h4>

</div>