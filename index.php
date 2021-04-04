<?php
    # include do cabecalho
    include "header.php";

    require_once __DIR__ . '/lib/Utils.php';
    require_once __DIR__ . '/lib/Data.php';

    use Bingo\Data;
    use Bingo\Utils;

    $data = new Data($id);
    $jsonDataIndex = $data->jsonData;   
?>
        <!-- The Grid -->
        <div class="w3-row">

            <div class="w3-col m12">
                <?php if ($id != NULL): ?>
                    <?php if($jsonDataIndex['success'] === false): ?>    
                        <div class="w3-row-padding">
                            <div class="w3-col m12">
                                <div class="w3-card w3-round w3-white w3-margin-bottom">
                                    <div class="w3-container w3-padding">
                                        <?php  Utils::echoError('Erro!', $jsonDataIndex['data'] ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="w3-row-padding">
                            <div class="w3-col m8">
                                <div class="w3-card w3-round w3-white w3-margin-bottom">
                                    <form action="link.php" method="POST">
                                    <div class="w3-container w3-padding">
                                        <div class="w3-container w3-padding">
                                            <h6 class="w3-opacity">Nome</h6>
                                            <input class="w3-border w3-padding w-100p" maxlength="30" name="name" type="text">
                                            <h6 class="w3-opacity">Celular</h6>
                                            <input class="w3-border w3-padding w-100p" maxlength="20" name="phone" type="text">
                                            <input name="id" type="hidden" value="<?= $id; ?>">
                                            <input name="link" type="hidden" value="T">
                                        </div>
                                        <div class="w3-container w3-padding w3-right">
                                            <button type="submit" class="w3-button w3-theme"><i class="fas fa-save"></i> Gerar minha cartela</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="w3-col m4 w3-hide-small">
                                <div class="w3-card w3-round w3-white w3-margin-bottom">
                                    <div class="w3-container w3-padding">
                                        <!-- firm -->
                                        <div class="w3-row">
                                            <div class="w3-col m5">
                                                Promovido por
                                            </div>
                                            <div class="w3-col m7">
                                                <?= $jsonData['data']['firm'] ?>
                                            </div>
                                        </div>
                                        
                                        <!-- owner -->
                                        <div class="w3-row">
                                            <div class="w3-col m5">
                                                Responsável
                                            </div>
                                            <div class="w3-col m7">
                                                <?= $jsonData['data']['owner'] ?>
                                            </div>
                                        </div>

                                        <!-- wa -->
                                        <div class="w3-row">
                                            <div class="w3-col m5">
                                                WhatsApp
                                            </div>
                                            <div class="w3-col m7">
                                                <?= $jsonData['data']['wa'] ?>
                                            </div>
                                        </div>

                                        <!-- email -->
                                        <div class="w3-row">
                                            <div class="w3-col m5">
                                                E-mail
                                            </div>
                                            <div class="w3-col m7">
                                                <?= $jsonData['data']['email'] ?>
                                            </div>
                                        </div>

                                        <!-- valid_at -->
                                        <div class="w3-row">
                                            <div class="w3-col m5">
                                                Validate
                                            </div>
                                            <div class="w3-col m7">
                                                <?= date("d/m/Y H:i:s", strtotime($jsonData['data']['valid_at'])) ?>
                                            </div>
                                        </div>

                                        <!-- max_number -->
                                        <div class="w3-row">
                                            <div class="w3-col m5">
                                                Nr. de bolas
                                            </div>
                                            <div class="w3-col m7">
                                                <?= $jsonData['data']['max_number'] ?>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                <?php else: ?>
                    <div class="w3-row-padding">
                        <div class="w3-col m12">
                            <div class="w3-card w3-round w3-white w3-margin-bottom">
                                <div class="w3-container w3-padding">
                                    <?php  Utils::echoError('Erro!', "Lamento, é preciso informar um id na URL!"); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- End Grid -->
        </div>
<?php
    # include do rodape
    include "footer.php";
?>