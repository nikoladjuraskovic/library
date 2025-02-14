<?php

//session_start();
require "config.php";


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

            <input type="submit" value="Log out" class="btn btn-outline-danger">

        </form>

    </div>
</main>

<?php require "views/partials/footer.php"?>
