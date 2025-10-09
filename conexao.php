<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_login";

// Cria a conexão
$conn = new mysqli($servidor, $usuario, $senha, $banco);

// Verifica conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
