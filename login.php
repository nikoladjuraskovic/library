
<?php

require "config.php";

/*
 * Ako username nije podesen u sesiji, to znaci da nismo ulogovani i tako naznaci
 * inace,
 * jesmo ulogovani i tako naznaci u $loggedIn
 * */
$loginError = "";

if(!isset($_SESSION['username']))
    $loggedIn = false;
else
    $loggedIn = true;

if(isset($_SESSION['username'])) //if logged in, redirect to home page
    header("Location: index.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {


        /*Moze se desiti da neko ko je ulogovan namerno ukuca url login strane i otvori je,
        onda ga treba spreciti da se uloguje opet*/


    if(!isset($_SESSION['username'])) {

        $username = $_POST["username"];
        $password = $_POST["password"];


        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['username' => $username]);
        $data = $stmt->fetch();
        if ($data)//Ako ima neki takav korisnik
        {

            //proveri da li je tacna sifra
            if (password_verify($password, $data['password'])) {
                //ini_set('session.gc_maxlifetime', (60 * 60 * 24)); //duzina trajanja sesije je 1 dan
                //session_start();

                $_SESSION['username'] = $username;
                $_SESSION['role'] = $data['role'];
                $_SESSION['id'] = $data['UserID'];
                $_SESSION['IP'] =  $_SERVER["HTTP_USER_AGENT"] ?? $_SERVER['REMOTE_ADDR'];


                echo "User " . htmlspecialchars($data['username']) . " is logged in. Welcome back!";
                $loggedIn = true; // Oznaci da smo ulogovani
                $loginError = "";
                //immediately transfer to index.php
                header("Location: index.php");

            } else {
                echo "Wrong password! Try again!";
                $loginError = "Wrong password!";

            }
        } else {
            echo "Wrong username! Try again!";
            $loginError = "Wrong username!";
        }


        $pdo = null;

    } else{

        echo "Already logged in!";
    }
}






?>


<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>
<main>

    <div class="container">

        <h2>Log In User</h2>

        <br>

        <form action="login.php" method="post" id="forma">

            <div id="greska">
                <?php echo $loginError; ?>
            </div>

            <br>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>

            <br>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <br>

            <!--
            Onemoguci korisniku da klikne dugme login ako je vec ulogovan.
            -->

            <?php if($loggedIn == false): ?>
                <input type="submit" value="Log In" class="btn btn-outline-primary" style="width: 100%">
            <?php else: ?>
                <input type="submit" value="Log In" class="btn btn-outline-primary" disabled  style="width: 100%">
            <?php endif; ?>

        </form>

    </div>

</main>

<script src="bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<script src="login.js"></script>

<?php require "views/partials/footer.php"?>
