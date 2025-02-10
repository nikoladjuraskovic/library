
<?php

require "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];



    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $username]);
    $data = $stmt->fetch();
    if($data)//Ako ima neki takav korisnik
    {

        //proveri da li je tacna sifra
        if(password_verify($password, $data['password']))
        {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $data['role'];

            echo "User " . htmlspecialchars($data['username']) . " is logged in. Welcome back!";
        } else{
            echo "Wrong password! Try again!";

        }
    } else{
        echo "Wrong username! Try again!";

    }

    $pdo = null;
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
