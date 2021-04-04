<link rel="stylesheet" href="assets/card.css">
<?php
# https://github.com/chillerlan/php-qrcode

// ini_set('display_errors', 1); 
// echo "<pre>";

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/Bingo.php';
require_once __DIR__ . '/lib/Pdf.php';
require_once __DIR__ . '/lib/Data.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Bingo\Bingo;
use Bingo\Pdf;
use Bingo\Data;

# Carrega Css para o card
$stylesheet = file_get_contents(__DIR__ . '/assets/card.css');

# Decodifica o parametro que foi passado na query da URL com nome de params
$params =  json_decode(base64_decode($_GET["params"]));

# Ajusta as opções do QRCode
$options = new QROptions([
    'version' => 5, //versao do QRCode
    'eccLevel' => QRCode::ECC_L, //Error Correction Feature Level L
    'outputType' => QRCode::OUTPUT_IMAGE_PNG, //setando o output como PNG
    // 'imageBase64' => false //evitando que seja gerado a imagem em base64
    ]);
    
$id = $params[0];

# instancia a classe Bingo
$bingo = new Bingo($params[0]);    

# cria HTML que será usado para gerar o PDF
$html = '<h3 class="title">Limoeiro Azul</h3>';
$html .= $bingo->cardRender();
$html .= '<div class="img-content"><img class="qr-code" src="'.(new QRCode($options))->render($params[1]).'" /></div>';

$data = new Data($params[0]);
$jsonData = $data->jsonData['data'];    


if ($jsonData['is_pdf']):
    # Chamada da função que arquivo PDF
    Pdf::render($params[0], $html, $stylesheet);
else:
    $print = true;
    include "header.php";
?>

<?= $html; ?>
<?php 
    include "footer.php";
endif;
?>