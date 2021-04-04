<?php

namespace Bingo;

/**
 *  Classe responsável por carregar para memoria 
 *  o arquivo JSON que fica na pasta data da aplicação
 *  possui trativa de erros para quando houver
 */

class Data 
{
    public $jsonData;
    
    /**
     *  Contrutor
     */    
    function __construct($id = NULL)
    {
        if ($id != NULL)
            $this->jsonData = $this->readJsonData($id);
    }

    /**
     *  Faz a leitura do arquivo JSON da pasta data da aplição
     *  recebe um parametro $id, que é nome do arquivo JSON, sem 
     *  extensão. Retorna um array com estrutura capaz de controlar
     *  os erros gerados mais os dados do arquivo.
     */    

    public function readJsonData($id = NULL)
    {
        # Se o id for nulo retorna erro
        if ($id === NULL)
            return [
                "success" => false,
                "data" => "Id nao informado!"
            ];

        # Define o nome do arquivo JSON com base no $id
        $jsonFile = './data/' . $id . ".json";
 
        # Verifica se o arquivo existe na pasta data, Se NAO retorna erro
        if (!file_exists($jsonFile))
            return [
                "success" => false,
                "data" => "Arquivo de dados não encontrado!"
            ];

        # Pega o conteudo do arquivo 
        $jsonDataFileString = file_get_contents($jsonFile);

        # trata erros no ato de decodificar o arquivos JSON em um array
        try 
        {
            return [
                "success" => true,
                "data" => (array) json_decode($jsonDataFileString)
            ];

        } 
        # Retorno arrp caso o decode nao der certo
        catch (\Throwable $th) 
        {
            return [
                "success" => false,
                "data" => $th->getMessage()
            ];            
        }
    }
}