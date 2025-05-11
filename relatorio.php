<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$url = "https://web-barber-production.up.railway.app/relatorio/todos";
$json = file_get_contents($url);
if ($json === FALSE) {
    die("Erro ao acessar a API de relatórios.");
}
$data = json_decode($json, true);

session_start(); 

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

require_once 'conexao.php';

$sql = "SELECT 
          nome_cliente,
          barbeiro,
          servico,
          valor
        FROM servicos_realizados";

$stmt = $conn->query($sql);
$result = $stmt;

if (!$result) {
    die("Erro ao executar a consulta: " . implode(" ", $conn->errorInfo()));
}

$relatorios = [];

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
  $barbeiro = $row['barbeiro'] ?? 'Indefinido';
  $nome_cliente = $row['nome_cliente'] ?? 'Indefinido';
  $servico_str = $row['servico'] ?? '';
  $valor = isset($row['valor']) ? (float)$row['valor'] : 0.0;

  if (!isset($relatorios[$barbeiro])) {
      $relatorios[$barbeiro] = [
          'totalServicos' => 0,
          'totalValor' => 0,
          'servicosPorCliente' => []
      ];
  }

  $relatorios[$barbeiro]['totalServicos'] += 1;
  $relatorios[$barbeiro]['totalValor'] += $valor;
  $relatorios[$barbeiro]['servicosPorCliente'][] = [
      'nome_cliente' => $nome_cliente,
      'servico' => $servico_str,
      'valor' => $valor
  ];
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - Barbearia Freitas</title>
    <link rel="stylesheet" href="php.css">
</head>
<body>
<h1>Relatórios de Serviços - Barbearia Freitas</h1>
<a id="sair" href="index.php">Início</a>
<?php foreach ($relatorios as $barbeiro => $info): ?>
  <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px;">
    <h2>Barbeiro: <?php echo htmlspecialchars($barbeiro); ?></h2>
    <p>Total de Serviços: <?php echo $info["totalServicos"]; ?></p>
    <p>Total em R$: R$ <?php echo number_format($info["totalValor"], 2, ',', '.'); ?></p>

    <button onclick="document.getElementById('<?php echo md5($barbeiro); ?>').style.display = 
      document.getElementById('<?php echo md5($barbeiro); ?>').style.display === 'none' ? 'block' : 'none'">
      Ver detalhes
    </button>

    <div id="<?php echo md5($barbeiro); ?>" style="display:none; margin-top:10px;">
    <table class="relatorio-tabela">
        <tr>
          <th>Cliente</th>
          <th>Serviços</th>
          <th>Valor</th>
        </tr>
        <?php foreach ($info["servicosPorCliente"] as $servico): ?>
          <tr>
          <td><?php echo htmlspecialchars($servico["nome_cliente"]); ?></td>
          <td><?php echo htmlspecialchars($servico["servico"]); ?></td>
          <td>R$ <?php echo number_format($servico["valor"], 2, ',', '.'); ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>
<?php endforeach; ?>
</body>
</html>
