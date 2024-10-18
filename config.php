<?php
$servername = "localhost"; // Endereço do servidor (pode ser 'localhost')
$username = "root"; // Seu usuário do MySQL
$password = "root"; // Sua senha do MySQL
$dbname = "barbeariaricardo"; // Nome do banco de dados

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

echo "Conexão bem-sucedida!";

// Aqui você pode adicionar suas consultas SQL

// Fechar a conexão
$conn->close();
?>
