<?php
session_start(); 

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once 'conexao.php';

$sql = "SELECT * FROM agendamentos";
$stmt = $conn->query($sql);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamentos - Barbearia Freitas</title>
    <link rel="stylesheet" href="php.css">
</head>
<body>
    <h1>Painel Agendamentos - Barbearia Freitas</h1>
    <a id="sair" href="index.php">Início</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome Cliente</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Data</th>
            <th>Horário</th>
            <th>Serviço</th>
            <th>Barbeiro</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($result as $row): ?>
            <tr>
                <td><?php echo $row['id_agendamento']; ?></td>
                <td><?php echo $row['nome_cliente']; ?></td>
                <td><?php echo $row['telefone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['data_agendamento']; ?></td>
                <td><?php echo $row['horario']; ?></td>
                <td><?php echo $row['servico']; ?></td>
                <td><?php echo $row['barbeiro']; ?></td>
                <td>
                    <a id="editar" href="editar.php?id=<?php echo $row['id_agendamento']; ?>">Editar</a>
                    <a id="excluir" href="excluir.php?id=<?php echo $row['id_agendamento']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
