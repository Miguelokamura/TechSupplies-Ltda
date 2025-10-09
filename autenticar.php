<?php
session_start();
include("conexao.php");

$usuario = $_POST['usuario'];
$senha = $_POST['senha'];

// Prepara e executa consulta SQL
$sql = "SELECT * FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verifica senha com hash
    if (password_verify($senha, $user['senha'])) {
        $_SESSION['usuario'] = $user['usuario'];
        header("Location: sucesso.php");
        exit;
    } else {
        echo "<p>Senha incorreta!</p><a href='login.html'>Voltar</a>";
    }
} else {
    echo "<p>Usuário não encontrado!</p><a href='login.html'>Voltar</a>";
}
?>
