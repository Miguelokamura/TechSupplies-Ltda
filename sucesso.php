<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Área Restrita</title>
</head>
<body>
  <h1>Bem-vindo, <?php echo $_SESSION['usuario']; ?>!</h1>
  <p>Você está logado com sucesso!</p>
  <a href="logout.php">Sair</a>
</body>
</html>
