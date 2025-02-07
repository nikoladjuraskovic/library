<?php

session_start();

$_SESSION['user'] = 'nikola';


var_dump($_SESSION);
echo "<br>";

$session_id = session_id();
echo "SESSION ID: ". $session_id;




session_destroy();

?>


<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>

<main>
    <div class="container">


    </div>

</main>



<?php require "views/partials/footer.php"?>
