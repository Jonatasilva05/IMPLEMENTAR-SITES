<?php
namespace App\Pix;

class Payload {
    /**
     * IDs do Payload do Pix
     * @var string
    */
    const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    const ID_POINT_OF_INITIATION_METHOD = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
    const ID_MERCHANT_ACCOUNT_INFORMATION_URL = '25';
    const ID_MERCHANT_CATEGORY_CODE = '52';
    const ID_TRANSACTION_CURRENCY = '53';
    const ID_TRANSACTION_AMOUNT = '54';
    const ID_COUNTRY_CODE = '58';
    const ID_MERCHANT_NAME = '59';
    const ID_MERCHANT_CITY = '60';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
    const ID_CRC16 = '63';

    /**
     * Chave Pix
     * @var string
     */
    private $pixKey;

    /**
     * Descrição do Pagamento
     * @var string
     */
    private $description;

    /**
     * Nome do Titular da conta
     * @var string
     */
    private $merchantName;

    /**
     * Cidade do titular da conta
     * @var string
     */
    private $merchantCity;

    /**
     * ID da transação pix
     * @var string
     */
    private $txid;

    /**
     * Valor da transação
     * @var string
     */
    private $amount;

    /**
     * @var boolean
     */
    private $uniquePayment = false;

    /**
     * URL do payload dinâmico
     * @var string
     */
    private $url;

    /**
     * Metodo responsavel por definir o valor de $pixkey
     * @param string $pixKey
     */
    public function setPixKey($pixKey){
        $this->pixKey = $pixKey;
        return $this;
    }

    /**
     * Metodo responsavel por definir o valor de $uniquePayment
     * @param boolean $uniquePayment
     */
    public function setUniquePayment($uniquePayment){
        $this->uniquePayment = $uniquePayment;
        return $this;
    }

    /**
     * Metodo responsavel por definir o valor de $url
     * @param string $url
     */
    public function setUrl($url){
        $this->url = $url;
        return $this;
    }

    /**
     * Metodo responsavel por definir o valor de $description
     * @param string $description
     */
    public function setDescription($description){
        $this->description = $description;
        return $this;
    }

    /**
     * Metodo responsavel por definir o valor de $merchantName
     * @param string $merchantName
     */
    public function setMerchantName($merchantName){
        $this->merchantName = $merchantName;
        return $this;
    }
    
    /**
     * Metodo responsavel por definir o valor de $merchantCity
     * @param string $merchantCity
     */
    public function setMerchantCity($merchantCity){
        $this->merchantCity = $merchantCity;
        return $this;
    }

    /**
     * Metodo responsavel por definir o valor de $txid
     * @param string $txid
     */
    public function setTxid($txid){
        $this->txid = $txid;
        return $this;
    }

    /**
     * Metodo responsavel por definir o valor de $amount
     * @param float $amount
     */
    public function setAmount($amount){
        $this->amount = (string)number_format($amount,2,'.','');
        return $this;
    }

    /**
     * Metodo responsavel por Gerar o código completo do payload pix
     * @param string $id
     * @param string $value
     * @return string $id.$size.$value
     */
    private function getValue($id, $value){
        $size = str_pad(strlen($value),2,'0',STR_PAD_LEFT);
        return $id.$size.$value;
    }

    /**
     * Metodo responsavel por Retornar os valores completos da informação da conta
     * @return string 
     */
    private function getMerchantAccountInformation(){
        //DOMINIO DO BANCO
        $gui = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI,'br.gov.bcb.pix');

        //CHAVE PIX
        $key = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY,$this->pixKey);

        //DESCRIÇÃO DO PAGAMENTO
        $description = strlen($this->description) ? $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION,$this->description) : '';

        //VALOR COMPLETO DA CONTA
        return $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION,$gui.$key.$description);
    }

    /**
     * Metodo responsavel por Retornar os valores completos do campo adicional do pix(TXID)
     * @return string 
     */
    private function getAdditionalDataFieldTemplate(){
        //TXID
        $txid = $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID,$this->txid);

        //RETORNA O VALOR COMPLETO
        return $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE,$txid);
    }
    
    /**
     * Metodo responsavel por Gerar o código completo do payload pix
     * @return string 
     */
    public function getPayload(){
        //CRIA O PAYLOAD
        $payload = $this->getValue(self::ID_PAYLOAD_FORMAT_INDICATOR,'01').
                   $this->getMerchantAccountInformation().
                   $this->getValue(self::ID_MERCHANT_CATEGORY_CODE,'0000').
                   $this->getValue(self::ID_TRANSACTION_CURRENCY,'986').
                   $this->getValue(self::ID_TRANSACTION_AMOUNT,$this->amount).
                   $this->getValue(self::ID_COUNTRY_CODE,'BR').
                   $this->getValue(self::ID_MERCHANT_NAME,$this->merchantName).
                   $this->getValue(self::ID_MERCHANT_CITY,$this->merchantCity).
                   $this->getAdditionalDataFieldTemplate();

        //RETORNA O PAYLOAD + CRC16
        return $payload.$this->getCRC16($payload);
    }

    /**
     * Método responsável por calcular o valor da hash de validação do código pix
     * @return string
     */
        private function getCRC16($payload) {
            //ADICIONA DADOS GERAIS NO PAYLOAD
            $payload .= self::ID_CRC16.'04';

            //DADOS DEFINIDOS PELO BACEN
            $polinomio = 0x1021;
            $resultado = 0xFFFF;

            //CHECKSUM
            if (($length = strlen($payload)) > 0) {
                for ($offset = 0; $offset < $length; $offset++) {
                    $resultado ^= (ord($payload[$offset]) << 8);
                    for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                        if (($resultado <<= 1) & 0x10000) $resultado ^= $polinomio;
                        $resultado &= 0xFFFF;
                    }
                }
            }

        //RETORNA CÓDIGO CRC16 DE 4 CARACTERES
        return self::ID_CRC16.'04'.strtoupper(dechex($resultado));
    }
}
?>