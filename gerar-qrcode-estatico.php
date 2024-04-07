<?php

require __DIR__.'/vendor/autoload.php';

use \App\Pix\Payload;
use Mpdf\QrCode\QrCode;
use Mpdf\QrCode\Output;

//INSTANCIA PRINCIPAL DO PAYLOAD PIX
$obPayload = (new Payload)->setPixKey('16996030585')
                          ->setDescription('Pagamento do Pedido de 010202')
                          ->setMerchantName('Jonatas de Moraes da Silva')
                          ->setMerchantCity('Taquaritinga-SP')
                          ->setAmount('150')
                          ->setTxid('JHONSILVA016');

//CODIGO DE PAGAMENTO PIX
$payloadQrCode = $obPayload->getPayload();

//QR CODE
$obQrCode = new QrCode($payloadQrCode);

//IMAGEM DO QR CODE
$image = (new Output\Png)->output($obQrCode,400);

?>

<h1>QR CODE ESTÁTICO DO Pix</h1>

<br>

<img src="data:image/png;base64, <?=base64_encode($image)?>">

<br><br>

Código pix:<br>
<strong><?=$payloadQrCode?></strong>