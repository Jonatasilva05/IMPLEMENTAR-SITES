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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos estão definidos e não estão vazios
    if (isset($_POST["produto"]) && isset($_POST["quantidade"]) && !empty($_POST["produto"]) && !empty($_POST["quantidade"])) {
        $produto = $_POST["produto"];
        $quantidade = $_POST["quantidade"];
        
        // Calcula o valor total do pedido
        $valor_unitario = 5; // Valor fixo do produto
        $valor_final = $quantidade * $valor_unitario;
        
        // Insere os dados no banco de dados
        $sql = "INSERT INTO pedidos (produto, quantidade, valor_total) VALUES ('$produto', '$quantidade', '$valor_final')";
        
        if ($conn->query($sql) === TRUE) {
            // Calcula o valor final do pedido (poderia ser feito ao exibir a lista de pedidos, mas para este exemplo, faremos aqui)
            $valor_total = $valor_final;
            // Atualiza o valor final no banco de dados
            $sql_update = "UPDATE pedidos SET valor_final='$valor_total' WHERE id=" . $conn->insert_id;
            $conn->query($sql_update);
            
            // Redireciona para a página de lista de pedidos após a inserção bem-sucedida
            header("Location: lista_pedidos.php");
            exit(); // Certifica-se de que o script termina aqui
        } else {
            echo "Erro ao adicionar pedido: " . $conn->error;
        }
    } else {
        echo "Por favor, selecione um produto e uma quantidade.";
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>