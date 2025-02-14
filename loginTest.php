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

        <h2>Welcome, <?= $usernameNav ?? "guest" ?></h2>
        <h2>Role: <?= $roleNav ?? "Anonymous" ?></h2>
    </div>
</main>

<?php require "views/partials/footer.php"?>
