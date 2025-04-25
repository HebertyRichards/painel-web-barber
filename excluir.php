<?php
session_start(); 

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once 'conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM agendamentos WHERE id_agendamento = ?");
    if ($stmt->execute([$id])) {
        header('Location: painel.php');
        exit();
    } else {
        echo "Erro ao excluir agendamento.";
    }
} else {
    echo "ID do agendamento não informado.";
}
?>
