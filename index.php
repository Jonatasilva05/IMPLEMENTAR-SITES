<?php

require __DIR__.'/vendor/autoload.php';

use \App\Pix\Payload;

$obPayload = (new Payload)->setPixKey('16996030585')
                          ->setDescription('Pagamento do Pedido de Cliente')
                          ->setMerchantName('Jonatas de Moraes da Silva')
                          ->setMerchantCity('Taquaritinga-SP')
                          ->setAmount('100,00')
                          ->setTxid('JHONSILVA016');

                          
?>