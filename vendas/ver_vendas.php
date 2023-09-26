<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

$link = mysqli_connect("localhost", "root", "", "ban2");

$username = mysqli_real_escape_string($link, $_SESSION['username']);

$query = "
SELECT
    c.nome AS nome_cliente,
    f.nome AS nome_funcionario,
    v.venda_id,
    v.data_venda,
    v.valor_total
FROM Venda v
JOIN Cliente c ON v.cliente_id = c.cliente_id
JOIN Funcionario f ON v.funcionario_id = f.funcionario_id
ORDER BY v.venda_id DESC;
";

$result = mysqli_query($link, $query);

if (isset($_POST['export_venda_id'])) {
    $venda_id = $_POST['export_venda_id'];

    $export_query = "
    SELECT
        v.data_venda,
        c.nome AS nome_cliente,
        f.nome AS nome_funcionario,
        vp.produto_id,
        p.nome AS nome_produto,
        p.fornecedor_id,
        vp.quantidade,
        forn.nome AS nome_fornecedor,
        p.preco AS preco_produto,
        v.valor_total 
    FROM Venda v
    JOIN Cliente c ON v.cliente_id = c.cliente_id
    JOIN Funcionario f ON v.funcionario_id = f.funcionario_id
    JOIN venda_produto vp ON v.venda_id = vp.venda_id
    JOIN Produto p ON vp.produto_id = p.produto_id
    JOIN Fornecedor forn ON p.fornecedor_id = forn.fornecedor_id
    WHERE v.venda_id = $venda_id;
    ";

    $export_result = mysqli_query($link, $export_query);

    $filename = "relatorio_venda_" . $venda_id . ".txt";

    $file = fopen($filename, "w");

    $first_row = mysqli_fetch_assoc($export_result);
    $line = "Venda ID: " . $venda_id . "\n";
    $line .= "Data da Venda: " . $first_row['data_venda'] . "\n";
    $line .= "Cliente: " . $first_row['nome_cliente'] . "\n";
    $line .= "Funcionário: " . $first_row['nome_funcionario'] . "\n\n";
    $line .= "Valor total: " . number_format($first_row['valor_total'], 2) . "\n\n";
    fwrite($file, $line);

    do {
        $line = "Produto ID: " . $first_row['produto_id'] . "\n";
        $line .= "Nome do Produto: " . $first_row['nome_produto'] . "\n";
        $line .= "Fornecedor: " . $first_row['nome_fornecedor'] . "\n";
        $line .= "Quantidade: " . $first_row['quantidade'] . "\n";
        $line .= "Preço Individual do Produto: " . number_format($first_row['preco_produto'], 2) . "\n";
        $line .= "Valor Total do Produto: " . number_format($first_row['preco_produto'] * $first_row['quantidade'], 2) . "\n\n";
        fwrite($file, $line);
    } while ($first_row = mysqli_fetch_assoc($export_result));

    fclose($file);

    header("Content-disposition: attachment; filename=$filename");
    header("Content-type: application/octet-stream");
    readfile($filename);

    unlink($filename);
    exit();
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
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Vendas</h3>
                            </div>
                        </div>
                        <div class="content">
                            <div class="table-wrapper">
                                <table border="1">
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Funcionário</th>
                                        <th>Pedido ID</th>
                                        <th>Valor Total</th>
                                        <th>Ações</th>
                                    </tr>

                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['nome_cliente'] . "</td>";
                                        echo "<td>" . $row['nome_funcionario'] . "</td>";
                                        echo "<td>" . $row['venda_id'] . "</td>";
                                        echo "<td>" . number_format($row['valor_total'], 2) . "</td>";
                                        echo '<td>
                                            <form method="post">
                                                <input type="hidden" name="export_venda_id" value="' . $row['venda_id'] . '">
                                                <button class="export-button" type="submit">Exportar</button>
                                            </form>
                                        </td>';
                                        echo "</tr>";
                                    }
                                    ?>

                                </table>
                            </div><br>
                            <a class="form-control btn btn-primary rounded submit px-3" href="inserir_vendas.php">Adicionar venda</a><br>
                            <p class="text-center"> <a href="../menu_functions.php">Voltar</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
