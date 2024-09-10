<?php
session_start();

// Verificar se o usuário está logado e é admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "loja";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se os campos estão definidos
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $preco = isset($_POST['preco']) ? trim($_POST['preco']) : '';

    // Validação básica
    if (empty($nome) || empty($preco)) {
        echo "Nome e preço são obrigatórios.";
        exit();
    }

    // Preparar a declaração
    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nome, $descricao, $preco);

    // Executar a inserção
    if ($stmt->execute()) {
        echo "Novo produto adicionado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fechar a declaração
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <h1>Adicionar Novo Produto</h1>
    <form action="adicionar.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        
        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao"></textarea>
        
        <label for="preco">Preço:</label>
        <input type="number" id="preco" name="preco" step="0.01" required>
        
        <button type="submit">Adicionar Produto</button>
    </form>
    <a href="logout.php">Sair</a>
</body>
</html>
