<?php


//Ako se nismo ulogovali tj. podesili sesiju, zapocni je, ovo je zbog login.php da ne bi 2x
//zapocinjali sesiju i da bi username i role mogli da se prikazu na svakoj stranici
if(!isset($_SESSION))
    session_start();

//ako je podeseno username, to znaci da smo ulogovani na tekucoj stranici i ispisi username i role
if(isset($_SESSION['username'])){
    $usernameNav = $_SESSION['username'];
    $roleNav = $_SESSION['role'];
}


?>


<nav>

    <div class="container">

    <div class="links">

    <div>

        <a href="show.php">Books</a>
        <?php if(isset($_SESSION['username']) && $_SESSION['role'] === 'admin'){ ?>
            <a href="insert.php">Insert book</a>
            <a href="delete.php">Delete book</a>
            <a href="edit.php">Edit books</a>
            <a href="rentsAdmin.php">Approve rents</a>
        <?php } ?>

    </div>

    <div> <!--Za ulogovane korisnike prikazujemo samo login stranicu, za izlogovane login i register-->
        <?php if(isset($_SESSION['username'])) { ?>
            <a href="showAvailable.php">Rent a book</a>
            <a href="rentsUser.php">Book rents</a>
            <a href="logout.php">Log out</a>

        <?php }else {  ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php } ?>

        <a href="loginTest.php">Login Test</a>


    </div>

    </div>

        <h4>User: <?= $usernameNav ?? "Guest" ?></h4>
        <h4>Role: <?= $roleNav ?? "Anonymous" ?></h4>

    </div>
</nav>