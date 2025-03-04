<?php

require "config.php";

if(!isset($_SESSION['username']))
    header("Location: index.php");

if($_SESSION['role'] != "admin")
    header("Location: index.php");

$error = "";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{

    if($_FILES["file"]["type"] === "application/json" || $_FILES["file"]["type"] === "text/xml")
    {
        foreach ($_FILES["file"] as $key => $value) {
            echo "[$key] => $value" . "<br>";
        }

        if(file_exists("files/" . $_FILES["file"]["name"])){
            $error = "File already exists.";
        } else{

            //upload file to folder files
            move_uploaded_file($_FILES["file"]["tmp_name"], "files/". $_FILES["file"]["name"]);

            if($_FILES["file"]["type"] === "text/xml")
            {
                $books = simplexml_load_file("files/" . $_FILES["file"]["name"]);

            } else { // otherwise(it will always be json here)

                $books_from_json = file_get_contents("files/" . $_FILES["file"]["name"]);
                $books = json_decode($books_from_json);
            }
                foreach($books as $book){
                    $title = $book->title;
                    $author = $book->author;
                    $year = $book->year;
                    $amount = $book->amount;

                    $sql = "INSERT INTO books (title, author, year, amount) VALUES(:title, :author, :year, :amount)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(["title" => $title, "author" => $author, "year" => $year, "amount" => $amount]);
                    header("Location: show.php");

                }
            }


    } else{
        $error = "Only xml and json files are allowed!";
    }

    $pdo = null;
    exit(0);
}




?>

<?php require "views/partials/header.php"?>
<?php require "views/partials/nav.php"?>
<main>
    <div class="container">

        <h2>Insert book via uploaded file(Xml or Json)</h2>

        <form action="insertFile.php" method="post" enctype="multipart/form-data">

            <div id="greska">
                <?=$error?>
            </div>

            <input type="file" value="Choose file..." name="file" required>
            <input type="submit" value="Upload file" class="btn btn-outline-primary">
        </form>

    </div>
</main>


<?php require "views/partials/footer.php"?>



