<?php

require "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = "user";

    $query = "INSERT INTO users (username, password, role) VALUES (:username, :hash, :role)";


    $stmt = $pdo->prepare($query);
    $stmt->execute([$username, $hash, $role]);

    echo "User registered successfully!";

    $pdo = null;


    /*
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

        <form action="register.php" method="post">

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

            <input type="submit" value="Register!" class="btn btn-info">

        </form>

    </div>

</main>


<?php require "views/partials/footer.php"?>
