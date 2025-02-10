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
        <a href="insert.php">Insert book</a>
        <a href="delete.php">Delete book</a>
        <a href="edit.php">Edit books</a>

    </div>

    <div>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
        <a href="loginTest.php">Login Test</a>
        <a href="logout.php">Log out</a>
    </div>

    </div>

        <h4>User: <?= $usernameNav ?? "Guest" ?></h4>
        <h4>Role: <?= $roleNav ?? "Anonymous" ?></h4>

    </div>
</nav>