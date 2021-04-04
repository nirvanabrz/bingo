<?php

namespace Bingo;

require_once __DIR__ . '/Data.php';

use Bingo\Data;

/**
 *  Classe responsável por criar a extrutura da cartela de bingo
 *  Ao ser instanciada é necessário informar o $id, que é o nome 
 *  do arquivo JSON que contem os parametros para a criação.
 */
class Bingo 
{
    protected $jsonData;

    /**
     *  Contrutor
     */
    function __construct($id)
    {
        $data = new Data($id);
        $this->jsonData = $data->jsonData;    
    }

    /**
     *  Impime um cartela em modo texto
     */
    public function cardPrint()
    {
        # inicializa as contagens e array de resultado
        $row = 0;
        $col = 0;
        $drawnNumbers = [];

        # Faz um <pre> para manter a formatação TXT do resultado
		echo "<pre>";

        # Define o cabecalho da cartela
        if ($this->jsonData['data']['type'] != 'free')
            echo " B   I   N   G   O  \r\n";

        #Loop de $row
        for ($i=0; $i <= 4; $i++) 
        { 
            # loop de $col
            for ($ii=0; $ii < 5; $ii++) 
            {                
                # Se for o meio da cartela imprime o asterisco ao invez do numero 
				if (($i === 2) && ($ii  === 2))
					echo str_pad("*", 4, " ", STR_PAD_BOTH);
				
                # Faz o sorteio e imprime
                else
				{
                    # faz um sorteio de um novo numero
					$drawnRand = $this->rand($drawnNumbers);
					
                    # faz um push no array de numeros sorteados com um novo numero
                    array_push($drawnNumbers,$drawnRand);

                    # imprime o numero
                	echo str_pad($drawnRand, 4, " ", STR_PAD_BOTH);
				}
            }

            # EOF
			echo "\r\n";
        }
    }

    /**
     *  Gera cartela em um array
    */
    public function cardArray() : array
    {
        # inicializa as contagens e array de resultado
        $row = 0;
        $col = 0;
        $drawnNumbers = [];

        #inicia o array da cartela com o título
        if ($this->jsonData['data']['type'] != 'free')
            $card = [
                [ 1 => "B", 2 => "I", 3 => "N", 4 => "G", 5 => "O"]
            ];

        #Loop de $row
        for ($i=1; $i <= 5; $i++) 
        { 
            #Loop de $col
            for ($ii=1; $ii < 6; $ii++) 
            { 
                # Se for o meio da cartela adiciona no array $card um asterisco ao invez do numero 
				if (($i === 3) && ($ii  === 3))
                    $card[$i][$ii] = "*";

                # Faz o sorteio e adiciona no array $card                    
				else
				{
                    # faz um sorteio de um novo numero
					$drawnRand = $this->rand($drawnNumbers);
					
                    # faz um push no array de numeros sorteados com um novo numero
                    array_push($drawnNumbers,$drawnRand);
                    
                    # Adiciona o numero sorteado no array $card
                    $card[$i][$ii] = $drawnRand;
				}
            }
        }

        # retorno a cartela - $card
        return $card;
    }

    /**
     *  Gera uma cartela em JSON
    */
    public function cardJson()
    {
        # faz o encode do array $card para um Json
        return json_encode($this->cardArray());
    }

    /**
     *  Gera um número aleatório para cartela e 
     *  controla para que o numero nao repita.
     *  O parametro $drawnNumbers, é um array
     *  que contem os números já gerados.
    */
    private function rand($drawnNumbers)
    {
        # pega o número maximo da cartela
        $maxNumber = $this->jsonData['data']['max_number'];

        # gera um numero aleatorio com base no range de ao numero maximo
        $drawn = rand(1, $maxNumber);

        # Verifica se o numero ja foi sorteado de foi ele faz uma chamada recursiva até encontrar uma nao tenha sido
        if (gettype(array_search($drawn, $drawnNumbers)) === "integer")
            return $this->rand($drawnNumbers);
		else
        	return $drawn;
    }

    /**
     *  Renderiza a cartela do bingo em HTML numa table.
     *  Vale lembrar que é preciso fazer include o cards.css para que fique mais apresentavel
    */
    public function cardRender()
    {
        # Cria um array no formato de array
        $cardArray = $this->cardArray();
    
        # renderiza o content e a table
        $renderReturn =  '<div class="content">';
        $renderReturn .=  '<table>';
    
        # Percorre as linhas do array $cardArray
        foreach ($cardArray as $keyRow => $row) 
        {
            # Renderiza a linha da table
            $renderReturn .= '<tr class="text-center">';
    
            # Percorre as colunas do $cardArray
            foreach ($row as $keyCol => $col) 
            {
                # Se form indice 0 (zero) renderiza o cambeçalho
                if ($keyRow === 0) // cabecalho
                    $renderReturn .= "    <th>" . $col . "</th>";
                
                # Se NÂO, renderiza o numero 
                else
                    $renderReturn .= "    <td>" . $col . "</td>";
            }
    
            # Renderiza o fechamento da linha
            $renderReturn .= "</tr>";
        }
    
        # renderiza o fechamendo do table e do content
        $renderReturn .= "</table>"; 
        $renderReturn .= "</div>"; 
    
        # retorna um HTML contendo a cartela
        return $renderReturn;
    }    
}
