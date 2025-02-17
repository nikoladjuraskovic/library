<?php

/*
session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}
*/
require "config.php";


?>



<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>
    <div class="container">

        <h4>Welcome, <?= $usernameNav ?? "guest" ?></h4>
        <h4>Role: <?= $roleNav ?? "Anonymous" ?></h4>

        <h1>Library Renting App</h1>
    </div>
</main>

<?php require "views/partials/footer.php"?>
