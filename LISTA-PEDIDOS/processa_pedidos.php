<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "seu_usuario";
$password = "sua_senha";
$dbname = "pedidos_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se a conexão foi estabelecida corretamente
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Função para limpar os dados de entrada
function limpar_dados($dados) {
    global $conn;
    return mysqli_real_escape_string($conn, $dados);
}

// Processar o pedido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto = limpar_dados($_POST["produto"]);
    $quantidade = limpar_dados($_POST["quantidade"]);

    // Inserir o pedido no banco de dados
    $sql = "INSERT INTO pedidos (produto, quantidade) VALUES ('$produto', '$quantidade')";

    if ($conn->query($sql) === TRUE) {
        echo "Pedido registrado com sucesso!";
    } else {
        echo "Erro ao registrar o pedido: " . $conn->error;
    }
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
