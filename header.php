<?php

// ini_set('display_errors', 1); 
// echo "<pre>";

require_once __DIR__ . '/lib/Data.php';

use Bingo\Data;

# pega o id enviado via GET ou POST
if ($id === NULL)
    $id = ($_GET["id"] === NULL ? $_POST["id"] : $_GET["id"]);

# Instancia da class Data, com base no $id;
$jsonDataFile = new Data($id);

# Pega o retorno do arquivo JSON + controle de erro.
$jsonData = $jsonDataFile->jsonData;

# reve dados do Payload - POST, usado no link.php
$data = $_POST;

?>

<!DOCTYPE html>
<html>
<title>Bingo</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/w3.css">
<link rel="stylesheet" href="assets/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="assets/fontawesome-free-5.15.3-web/css/all.min.css">
<link rel="stylesheet" href="assets/index.css">
<body class="w3-theme-l5">

    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
    
            <?php if ($data['link'] != '') : ?>
                <a href="/bingo?id=<?= $id; ?>" class="w3-bar-item w3-button w3-padding-large w3-hover-white w3-hide-small"><i class="fa fa-chevron-left"></i> Voltar</a>
                <a href="/bingo?id=<?= $id; ?>" class="w3-bar-item w3-button w3-padding-large w3-hover-white w3-hide-large w3-hide-medium"><i class="fa fa-chevron-left"></i></a>
            <?php endif; ?>

            <a href="/bingo?id=<?= $id; ?>" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fas fa-globe w3-margin-right"></i>Bingo</a>
            
            <?php if ($print) : ?>
                <button onclick="window.print()" class="w3-bar-item w3-button w3-padding-large w3-hover-white w3-hide-small"><i class="fa fa-print"></i> imprimir</button>
            <?php endif; ?>


            <p class="w3-bar-item w3-button w3-hide-small w3-right w3-padding-large nav-p" title="WhatsAppp: <?= $jsonData['data']['wa'] ?>">
                <?= $jsonData['data']['firm'] ?>
            </p>

        </div>
    </div>

    <!-- Page Container -->
    <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">