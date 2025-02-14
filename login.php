
<?php

require "config.php";




if ($_SERVER["REQUEST_METHOD"] == "POST") {

        /*Moze se desiti da neko ko je ulogovan namerno ukuca url login strane i otvori je,
        onda ga treba spreciti da se uloguje opet*/


    if(!isset($_SESSION['username'])) { //TODO NE RADI: dozvoljava logovanje iako smo vec ulogovani, za logout je reseno ako smo vec izlogovani
//TODO Resiti session_start() funkcije
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
                $_SESSION['IP'] = $_SERVER['REMOTE_ADDR'] ?? $_SERVER["HTTP_USER_AGENT"];


                echo "User " . htmlspecialchars($data['username']) . " is logged in. Welcome back!";

            } else {
                echo "Wrong password! Try again!";

            }
        } else {
            echo "Wrong username! Try again!";

        }


        $pdo = null;

    } else{
        echo "Already logged in!";
    }
} else{
    //session_start();
}






?>


<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>
<main>

    <div class="container">

        <h2>Log In User</h2>

        <br>

        <form action="login.php" method="post">

            <div id="greska">

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

            <input type="submit" value="Log In" class="btn btn-outline-primary">

        </form>

    </div>

</main>


<?php require "views/partials/footer.php"?>
