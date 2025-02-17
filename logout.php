<?php

//session_start();
require "config.php";

/*
 * Ako username nije podesen u sesiji, to znaci da nismo ulogovani i tako naznaci
 * inace,
 * jesmo ulogovani i tako naznaci u $loggedIn
 * */


if(!isset($_SESSION['username']))
    $loggedIn = false;
else
    $loggedIn = true;

if($_SERVER["REQUEST_METHOD"] == "POST") {

    //ako smo ulogovani, onda se izloguj brisuci sesiju
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $role = $_SESSION['role'];

        $_SESSION = array();
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path']);
        session_destroy();
        echo "You have been logged out.";
        //immediately transfer to index.php
        header("location: index.php");

    }  else{
        echo "You are not logged in.";
    }
}


?>

<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>
    <div class="container">
        <h2>Log out</h2>

        <form action="logout.php" method="post">

            <!--Samo ako sam ulogovan, omoguci korisniku da se izloguje, inace ne.-->

            <?php if($loggedIn == true) :  ?>
                <input type="submit" value="Log out" class="btn btn-outline-danger">
            <?php else: ?>
                <input type="submit" value="Log out" class="btn btn-outline-danger" disabled>
            <?php endif; ?>
            <!--TODO Stranica ne refreshuje dugme logout kao sto refreshuje dugme login u login.php nakon
            TODO izlogovanja(u logout.php) odnosno nakon ulogovanja(u login.php)-->
        </form>

    </div>
</main>

<?php require "views/partials/footer.php"?>
