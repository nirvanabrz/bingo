<?php

namespace Bingo;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/Data.php';
require_once __DIR__ . '/Utils.php';

use Bingo\Data;
use Bingo\Utils;

/**
 *  Classe responsavel por gerar o PDF
*/

class Pdf {

    /**
    * Função statica que gera arquivo PDF para ser baixado recebe dois parametros:
    * $html, é o conteúdo em HTML do PDF e $stylesheet, que são 
    * as classes CSS que vão melhorar o resultado do HTML
    */    

    static function render($id, $html, $stylesheet)
    {
        $data = new Data($id);
        $jsonData = $data->jsonData['data'];    

        # Instancia a classe do Mpdf
        $mpdf = new \Mpdf\Mpdf([
            'format' => array(70, 110),
            'margin_left' => 0,
            'margin_right' => 0,
            'margin_top' => 0,
            'margin_bottom' => 0,
            'margin_header' => 0,
            'margin_footer' => 0,
        ]);
        
        # Grupo de funções para configurar o PDF
        $mpdf->SetDefaultBodyCSS('background', "url('". __DIR__ . "/../assets/bg_" . $jsonData['bg'] . ".jpg')");
        $mpdf->SetDefaultBodyCSS('background-image-resize', 6);
        $mpdf->SetFont('LocalBrewery');
        $mpdf->SetAuthor('BINGO - By Silvio Mendes Pedrosa - ' . $jsonData['firm']);
        $mpdf->SetCreator('BINGO - ' . $jsonData['firm']);
        $mpdf->SetSubject('Cartela de BINGO - ' . $jsonData['firm'] . " - " . Utils::now());
        $mpdf->SetTitle('Cartela de BINGO - ' . $jsonData['firm'] . " - " . Utils::now());
    
        # Grupo de funções que escrevem o PDF
        $mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output();
        $mpdf->Close();
    }    

}