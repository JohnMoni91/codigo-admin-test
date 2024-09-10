<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loja";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Obter o ID do produto
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Buscar o produto
$sql = "SELECT * FROM produtos WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Produto não encontrado.");
}

$produto = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produto['nome']); ?></title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="produto-detalhes">
        <h1><?php echo htmlspecialchars($produto['nome']); ?></h1>
        <p><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>
        <p>Preço: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
        <p>Criado em: <?php echo htmlspecialchars($produto['data_criacao']); ?></p>
        <a href="exibir_produtos.php">Voltar para a lista de produtos</a>
    </div>
</body>
</html>
