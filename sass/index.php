<?php
error_reporting(E_WARNING | E_ERROR);
?><!DOCTYPE html>

<html lang="french">
<head>
    <meta charset="utf-8">

    <title></title>
    <meta name="author" content="">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="robots" content="">
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style type="text/css">

   

    </style>
</head>

<body>
<?php

$nom = 'Jean';
$aime = 'les macaronis';
$lieu = 'jardin';

?>

<div id="container">
    <h1>Salut <?php echo $nom ?>, ça va ?</h1>
    <p>coucou</p>
    <p>Hey dis <?php echo $nom ?>, il parait que tu aimes <?php echo $aime ?> ?</p>

    <h2> Des echos en chaîne : <?php echo $nom ?> <?=$aime ?> <?=$jardin ?>.</h2>



<div id="container"></div><!-- end container -->