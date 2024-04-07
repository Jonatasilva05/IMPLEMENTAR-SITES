<?php

namespace App\Pix;

class Api{
    /**
     * URL base do PSP
     * @var string
     */
    private $baseUrl;

    /**
     * Cliente ID do oAuth2 do PSP
     * @var string
     */
    private $clienteID;

    /**
     * Cliente secret do oAuth2 do PSP
     * @var string
     */
    private $clienteSecret;

    /**
     * Caminho absoluto até o arquivo do certificado
     * @var string
     */
    private $certificate;

    /**
     * Define os dados iniciais da classe
     * @param string $baseUrl
     * @param string $$clienteId
     * @param string $clienteSecret
     * @param string $certificate
     */
    public function __construct($baseUrl, $clienteID,$clienteSecret,$certificate)
    {
        $this->baseUrl       =$baseUrl;
        $this->clienteID     =$clienteID;
        $this->clienteSecret =$clienteSecret;
        $this->certificate =$certificate;
    }

    /**
     * Método responsável por criar uma cobrança imediata
     * @param string $txid
     * @param array $request
     * @param array 
     */
    public function createCob($txid,$request){
        return $this->send('PUT','/v2/cob/'.$txid,$request);
    }

    /**
     * Método responsável por obter o token de acesso ás APIs Pix
     * @return string
     */
    private function getAccesToken(){
        //ENDPOINT COMPLETO
        $endpoint = $this->baseUrl.'/oauth/token';

        //HEADERS
        $headers = [
            'Content-Type: application/json'
        ];

        //CORPO DA REQUISIÇÃO
        $request = [
            'grant_type' => 'client_credentials'
        ];

        //CONFIGURAÇÃO DO CURL
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL             => $endpoint,
            CURLOPT_USERPWD         => $this->clienteID.':'.$this->clienteSecret,
            CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CUSTOMREQUEST   => 'POST',
            CURLOPT_POSTFIELDS      => json_encode($request),
            CURLOPT_SSLCERT         => $this->certificate,
            CURLOPT_SSLCERTPASSWD   => '',
            CURLOPT_HTTPHEADER      => $headers
        ]);

        //EXECUTA O CURL
        $response = curl_exec($curl);
        curl_close($curl);

        //RESPONSE EM ARRAY
        $responseArray = json_decode($response,true);

        //RETORNA O ACCESS TOKEN
        return $responseArray['acces_token'] ?? '';

    }

    /**
     * Método responsável por enviar requisições para o PSP
     * @param string $method
     * @param string $resource
     * @param array $request
     * @return array 
     */
    private function send($method,$resource,$request = []){
        //ENDPOINT COMPLETO
        $endpoint = $this->baseUrl.$resource;

        //HEADERS
        $headers = [
            'Cache-Control: no-cache',
            'Content-type: application/json',
            'Autorization: Bearer '.$this->getAccesToken()
        ];

        //CONFIGURAÇÃO DO CURL
        $curl = curl_init();
        curl_setopt_array($curl,[
            CURLOPT_URL             => $endpoint,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_CUSTOMREQUEST   => $method,
            CURLOPT_SSLCERT         => $this->certificate,
            CURLOPT_SSLCERTPASSWD   => '',
            CURLOPT_HTTPHEADER      => $headers
        ]);

        switch ($method) {
            case 'POST':
            case 'PUT':
                curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($request));
                break;
        }

        //EXECUTA O CURL
        $response = curl_exec($curl);
        curl_close($curl);

        //RETORNA O ARRAY DA RESPOSTA
        return json_decode($response,true);
        
    }

}

?>