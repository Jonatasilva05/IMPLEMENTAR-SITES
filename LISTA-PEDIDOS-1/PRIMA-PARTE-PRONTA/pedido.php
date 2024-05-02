<?php
// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar os dados do formulário
    $sabor = $_POST["sabor"];
    $quantidade = $_POST["quantidade"];

    // Salvar os dados em um arquivo de pedidos (ou banco de dados, se preferir)
    $pedido = "Sabor: " . $sabor . ", Quantidade: " . $quantidade . "\n";
    file_put_contents("pedidos.txt", $pedido, FILE_APPEND);

    echo "Pedido adicionado com sucesso!";
}
?>
