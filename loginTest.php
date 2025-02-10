<?php

session_start();

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}


?>



<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>
    <div class="container">

        <h2>Welcome, <?= $username ?? "nobody" ?></h2>
    </div>
</main>

<?php require "views/partials/footer.php"?>
