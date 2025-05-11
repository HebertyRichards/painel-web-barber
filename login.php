<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    if ($usuario == 'admin' && $senha == 'senha123') {
        $_SESSION['usuario'] = $usuario; 
        header('Location: index.php'); 
        exit();
    } else {
        $erro = 'Credenciais inválidas!';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel AdministrativB - Login</title>
    <link rel="stylesheet" href="php.css">
</head>
<body>
    <h2>Painel Administrativo - Barbearia Freitas</h2>
    <form method="POST">
        <input type="text" name="usuario" placeholder="Usuário" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Login</button>
    </form>

    <?php if (isset($erro)) echo '<p>' . $erro . '</p>'; ?>
</body>
</html>