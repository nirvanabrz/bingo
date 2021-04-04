<?php
    // ini_set('display_errors', 1); 

    include "header.php";
    require_once __DIR__ . '/lib/Utils.php';
    require_once __DIR__ . '/vendor/autoload.php';

    use chillerlan\QRCode\QRCode;
    use chillerlan\QRCode\QROptions;
    use Bingo\Utils;

    # Define a URL base da aplicação
    $baseUrl = "http://localhost:8080/bingo";

    # Opções de geração QRCode
    $options = new QROptions([
        'eccLevel' => QRCode::ECC_M, //Error Correction Feature Level M
        'outputType' => QRCode::OUTPUT_IMAGE_PNG, //setando o output como PNG
        ]);
    
?>
        <!-- The Grid -->
        <div class="w3-row">

            <div class="w3-col m12">
                <div class="w3-row-padding">
                    <div class="w3-col m12">
                        <div class="w3-card w3-round w3-white w3-margin-bottom">
                            <div class="w3-container w3-padding">
                                
                                <?php

                                    # Verifica se os dados do formulário foram preenchidos, se NAO imprime um erro
                                    if (($data['name'] === '') || ($data['phone'] === ''))
                                        Utils::echoError('Erro!', "Formulário Vazio!");
                                    
                                    # Se SIM, seguem com o processo
                                    else 
                                    {
                                        # pega a data de validade do bingo
                                        $validAt = $jsonData['data']['valid_at'];

                                        #pega a data de hoje, respeitando o fuso horario GMT-3
                                        $now = Utils::now();
    
                                        # Verifica a validade do Bingo, se NAO, imprime erro
                                        if (!Utils::isValid($now, $validAt))
                                            Utils::echoError('Erro!', "Lamento, mas este bingo já está vencido!");
                                        
                                        # se SIM, Segue com o processo
                                        else
                                        {
                                            # gera uma string com o nme, telefoe e data de agora, para gerar QRCode de validação
                                            $stringUser = $data['name'] . " - " . $data['phone'] . " - " . $now;
                                            
                                            # gera os parametros com id e dados do usuário
                                            $params = [$id, $stringUser];

                                            # Tranforma o array params em JSON e codifica os dados para sem passados pela URL
                                            $paramsEnconed = (string) Utils::encode((string) json_encode($params));
  
                                            # Gera uma URL para a criação do PDF
                                            $pdfLink = $baseUrl . "/pdf.php?params=" . $paramsEnconed;

                                ?>

                                <div class="w3-row">
                                    <div class="w3-col m3 w3-center">
                                        <div class="img-content"><img class="qr-code" src=" <?= (new QRCode($options))->render($pdfLink) ?>" /></div>
                                    </div>
                                    <div class="w3-col m9">
                                        <h3>Tudo pronto!</h3>
                                        <h5>Você pode baixar o QrCode, ou clicando no botão Download abaixo.</h5>
                                        <div class="w3-col m12 w3-center w3-padding">
                                        <a type="button" href="<?= $pdfLink;?>" class="w3-button w3-theme bt-download"><i class="fas fa-cloud-download-alt"></i> Download</a>
                                    </div>
                                    </div>
                                </div>

                                <?php

                                        }
                                            
                                    }

                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- End Grid -->
        </div>
<?php
    include "footer.php";
?>
