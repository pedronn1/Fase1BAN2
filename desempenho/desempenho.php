<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

$link = mysqli_connect("localhost", "root", "", "ban2"); // Altere o nome do banco de dados, usuário e senha conforme necessário

$username = mysqli_real_escape_string($link, $_SESSION['username']);

// Inicialize $result como nulo
$result = null;

// Inicialize $data_inicio e $data_fim como vazios
$data_inicio = "";
$data_fim = "";

// Exportar o relatório para um arquivo de texto
if (isset($_POST['exportar_relatorio'])) {
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Consulta para obter o valor total de compras no período selecionado
    $compra_query = "
    SELECT SUM(valor_total) AS total_compras
    FROM Compra
    WHERE data_compra BETWEEN '$data_inicio' AND '$data_fim';
    ";

    $compra_result = mysqli_query($link, $compra_query);
    $compra_row = mysqli_fetch_assoc($compra_result);
    $total_compras = $compra_row['total_compras'];

    $venda_query = "
    SELECT SUM(valor_total) AS total_vendas
    FROM Venda
    WHERE data_venda BETWEEN '$data_inicio' AND '$data_fim';
    ";

    $venda_result = mysqli_query($link, $venda_query);
    $venda_row = mysqli_fetch_assoc($venda_result);
    $total_vendas = $venda_row['total_vendas'];

    $lucro_total = $total_vendas - $total_compras;

    $nome_arquivo = "relatorio.txt";
    $relatorio_texto = "Relatório de Desempenho\n";
    $relatorio_texto .= "Período: $data_inicio a $data_fim\n";
    $relatorio_texto .= "Total de Compras: R$ " . number_format($total_compras, 2, ',', '.') . "\n";
    $relatorio_texto .= "Total de Vendas: R$ " . number_format($total_vendas, 2, ',', '.') . "\n";
    $relatorio_texto .= "Lucro Total: R$ " . number_format($lucro_total, 2, ',', '.') . "\n";

    $arquivo = fopen($nome_arquivo, 'w');
    fwrite($arquivo, $relatorio_texto);
    fclose($arquivo);

    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');
    header('Content-Length: ' . filesize($nome_arquivo));
    readfile($nome_arquivo);

    unlink($nome_arquivo);

    exit();
}

// Processar o filtro de data e gerar o relatório
if (isset($_POST['gerar_relatorio'])) {
    $data_inicio = $_POST['data_inicio'];
    $data_fim = $_POST['data_fim'];

    // Consulta para obter o valor total de compras no período selecionado
    $compra_query = "
    SELECT SUM(valor_total) AS total_compras
    FROM Compra
    WHERE data_compra BETWEEN '$data_inicio' AND '$data_fim';
    ";

    $compra_result = mysqli_query($link, $compra_query);
    $compra_row = mysqli_fetch_assoc($compra_result);
    $total_compras = $compra_row['total_compras'];

    // Consulta para obter o valor total de vendas no período selecionado
    $venda_query = "
    SELECT SUM(valor_total) AS total_vendas
    FROM Venda
    WHERE data_venda BETWEEN '$data_inicio' AND '$data_fim';
    ";

    $venda_result = mysqli_query($link, $venda_query);
    $venda_row = mysqli_fetch_assoc($venda_result);
    $total_vendas = $venda_row['total_vendas'];

    // Calcular o lucro total
    $lucro_total = $total_vendas - $total_compras;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            table-layout: auto;
        }
    </style>
</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="wrap">
                    <div class="img" style="background-image: url(images/bg-1.png);"></div>
                    <div class="login-wrap p-4 p-md-5" style="text-align: center; display: flex; flex-direction: column; align-items: center;">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Desempenho</h3>
                            </div>
                        </div>
                        <div class="content">
                            <form method="post">
                                <label for="data_inicio">Data de Início:</label><br>
                                <input type="date" name="data_inicio" id="data_inicio" value="<?php echo $data_inicio; ?>" required><br>

                                <label for="data_fim">Data de Término:</label><br>
                                <input type="date" name="data_fim" id="data_fim" value="<?php echo $data_fim; ?>" required><br><br>

                                <button type="submit" name="gerar_relatorio">Gerar Relatório</button>
                                <button type="submit" name="exportar_relatorio">Exportar para TXT</button>
                            </form><br>

                            <?php if (isset($total_compras) && isset($total_vendas) && isset($lucro_total)) { ?>
                                <div class="resultado">
                                    <p>Período: <?php echo $data_inicio; ?> a <?php echo $data_fim; ?></p>
                                    <p>Total de Compras: R$ <?php echo number_format($total_compras, 2, ',', '.'); ?></p>
                                    <p>Total de Vendas: R$ <?php echo number_format($total_vendas, 2, ',', '.'); ?></p>
                                    <p>Lucro Total: R$ <?php echo number_format($lucro_total, 2, ',', '.'); ?></p>
                                </div>
                            <?php } ?>

                            <div class="logout-delete">
                                <a class="form-control btn btn-primary rounded submit px-3" href="../menu_functions.php">Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
