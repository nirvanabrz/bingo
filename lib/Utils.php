<?php

namespace Bingo;

use DateTime;

/**
 *  Classe com funções utilitarias 
 */

class Utils {

    /**
    *  Função estática para renderizar a mensagem de erro
    */
    static function echoError($title, $message)
    {
        echo '<div class="w3-panel w3-red">';
        echo '<h3>' . $title . '</h3>';
        echo '<p>' . $message . '</p>';
        echo '</div>';
    }


    /**
    *  Função estática que valida se a primeira data $d1 é maior que a segunda data $d2
    *  dessa forma valida se a data do bingo ainda é válida.
    */
    static function isValid($d1, $d2) 
    {    
        # pega a diferença em segundo entre as duas datas
        $seconds = strtotime($d2) - strtotime($d1);

        # Se form maior que 0 retorno true se NAO false
        return ($seconds > 0 ? true : false);
    }

    /**
    *  Função estática que pega a data de agora considerando o fuso horario de São Paulo
    */
    static function now()
    {
        # seta o fuso horario a ser considerado
        date_default_timezone_set('America/Sao_Paulo');

        # instancia um objeto de DateTime
        $date = new DateTime();
        
        # pega apenas a data de agora
        $now = $date->format('Y-m-d');
        
        # pega apenas a hora de agora considerando o fuso horario
        $timeZone = $date->format('H:i:sP');

        # concatena e retorna a data de agora
        return $now . "T" .$timeZone;
    }

    /**
    * Função estática que é fachada pra base64_encode
    * caso no futuro queira mudar o formato do encode, 
    * muda aqui e nao no resto da aplicacao
    */
    static function encode($str)
    {
        return base64_encode($str);
    }   

    /**
    * Função estática que é fachada pra base64_decode
    * caso no futuro queira mudar o formato do decode, 
    * muda aqui e nao no resto da aplicacao
    */
    static function decode($str)
    {
        return base64_decode($str);
    }   

}