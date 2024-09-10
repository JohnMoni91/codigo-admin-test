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

// Buscar produtos
$sql = "SELECT * FROM produtos";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Lista de Produtos</h1>
    <div class="produtos">
        <?php
        if ($result->num_rows > 0) {

            while($row = $result->fetch_assoc()) {
                echo "<div class='produto-card'>";
                echo "<h2><a href='produto.php?id=" . $row['id'] . "'>" . $row['nome'] . "</a></h2>";
                echo "<p>" . $row['descricao'] . "</p>";
                echo "<p>Preço: R$ " . number_format($row['preco'], 2, ',', '.') . "</p>";
                echo "</div>";
            }
        } else {
            echo "Nenhum produto encontrado.";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
