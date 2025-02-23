<?php

require "config.php";

if(isset($_SESSION['username'])) //if logged in, redirect to home page, we want to disable logged-in users to register
    header("Location: index.php");


if(!isset($_SESSION['username']))
    $loggedIn = false;
else
    $loggedIn = true;



if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = "user"; //change to 'admin' when you want to register an administrator

    $query = "INSERT INTO users (username, password, role) VALUES (:username, :hash, :role)";


    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $hash, $role]);

    echo "User registered successfully!";

    $pdo = null;
    /*
     *
     * Administrator
     * user: admin
     * password: admin
     *
     * user: user
     * password: 12345
     * */
}

?>

<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>
<main>

    <div class="container">

        <h2>Register User</h2>

        <br>

        <form action="register.php" method="post"  id="forma">

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

            <!--enable only non logged in visitors to register-->
            <?php if($loggedIn === false ) : ?>
                <input type="submit" value="Register!" class="btn btn-info">
            <?php else : ?>
                <input type="submit" value="Register!" class="btn btn-info" disabled>
            <?php endif; ?>

        </form>

    </div>

</main>
<script src="register.js"></script>

<?php require "views/partials/footer.php"?>
