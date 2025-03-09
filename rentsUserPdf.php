<?php

require "config.php";

if(!isset($_SESSION['username'])) //if logged out, redirect to home page
    header("Location: index.php");

require "dompdf/autoload.inc.php";


use Dompdf\Dompdf;

try {

    $dompdf = new Dompdf();

    ob_start();
    require "rentsUserPdfHtml.php";
    $html = ob_get_contents();
    ob_get_clean();

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $filename = $_SESSION['username'] . "-rents-report" . date("d.m.Y-H:i");

    $dompdf->stream($filename, array("Attachment" => false));


} catch(Exception $e) {
    echo $e->getMessage();
    echo $e->getTraceAsString();
    echo $e->getCode();
}