<?php


require "config.php";

if (!isset($_SESSION['username'])) //if logged out, redirect to home page
    header("Location: index.php");

if ($_SESSION['role'] != "admin") //if someone is not admin, then redirect
    header("Location: index.php");

use Dompdf\Dompdf;

require "dompdf/autoload.inc.php";


try {




    $dompdf = new Dompdf();

    ob_start();
    require "rentsAdminPdfHtml.php";
    $html = ob_get_contents();
    ob_get_clean();

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $filename = $_SESSION['username'] . "-rents-report" . date("d.m.Y-H:i") . "pdf";

    $dompdf->stream($filename, array("Attachment" => false));


} catch (Exception $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
    echo $e->getCode();
}