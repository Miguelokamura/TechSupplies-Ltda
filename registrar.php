<?php
include("conexao.php");

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);

    // Verifica se o usuário já existe
    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p style='color:red;'>Usuário já existe!</p>";
    } else {
        // Criptografa a senha antes de salvar
        $hash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere novo usuário no banco
        $sql = "INSERT INTO usuarios (usuario, senha) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $usuario, $hash);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Usuário cadastrado com sucesso!</p>";
            echo "<a href='login.html'>Ir para login</a>";
        } else {
            echo "<p style='color:red;'>Erro ao cadastrar.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Registrar Usuário</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f5f5f5;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    form {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      width: 300px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
    }
    button {
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      border: none;
      color: white;
      border-radius: 5px;
      cursor: pointer;
    }
    a {
      display: block;
      margin-top: 10px;
      text-align: center;
      text-decoration: none;
      color: #007bff;
    }
  </style>
</head>
<body>
  <form action="registrar.php" method="POST">
    <h2>Cadastro de Usuário</h2>
    <input type="text" name="usuario" placeholder="Usuário" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Cadastrar</button>
    <a href="login.html">Voltar para o login</a>
  </form>
</body>
</html>
