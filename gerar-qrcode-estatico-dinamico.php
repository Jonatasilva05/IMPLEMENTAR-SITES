<?php

require __DIR__.'/vendor/autoload.php';

use \App\Pix\Api;
use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

$obApiPix = new Api('https://pix-h.api.efipay.com.br',
                    'Client_Id_a56f879123f04929e1a9da9b159a2278ee3feeec',
                    'Client_Secret_7e8b6d355316840cd884536c93c8e355176da89c',
                    __DIR__.'/files/cetificates/moraes-salgados.pem');

$request = [
    'calendario' => [
        'expiracao' => 3600
    ],
    'devedor' => [
        'cpf'  => '12345678909',
        'nome' => 'Jhon Silva',
    ],
    'valor' => [
        'original' => '10.00'
    ],
    'chave' => '16996030585',
    'solicitacaoPagador' => 'Pagamento do pedido  123'
];

$response = $obApiPix->createCob('JHONSILVA12345678090900002',$request);

if(!isset($response['location'])){
    echo "Problemas ao gerar Pix dinâmico";
    echo "<pre>";
    print_r($response);
    echo "</pre>";exit;
}