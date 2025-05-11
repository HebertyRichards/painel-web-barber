<?php
session_start(); 

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início - Barbearia Freitas</title>
      <link rel="stylesheet" href="php.css">
</head>
<body>

<div class="container">
  <h1>Bem-vindo à Barbearia Freitas</h1>
  <p>Escolha uma das opções abaixo:</p>

  <a class="button" href="agendamento.php">Agendamentos</a>
  <a class="button" href="relatorio.php">Relatórios</a>
  <a class="button" href="logout.php">Sair</a>
</div>

</body>
</html>