<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Pedidos</title>
</head>
<body>

<h2>Lista de Pedidos:</h2>

<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bdlista";


// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Consulta os pedidos no banco de dados
$sql = "SELECT produto, quantidade, valor_total FROM pedidos";
$result = $conn->query($sql);

// Exibe os resultados em uma tabela HTML
if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Produto</th><th>Quantidade</th><th>Valor Total (R$)</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>".$row["produto"]."</td><td>".$row["quantidade"]."</td><td>".$row["valor_total"]."</td></tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum pedido encontrado.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

</body>
</html>
