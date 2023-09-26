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
    c.nome AS nome_fornecedor,
    f.nome AS nome_funcionario,
    l.nome AS nome_loja,
    compra.compra_id,
    compra.valor_total,
    cp.custo AS custo_produto,
    GROUP_CONCAT(p.nome) AS nome_produto,
    GROUP_CONCAT(vp.quantidade) AS quantidade_produto
FROM Compra compra
JOIN Fornecedor c ON compra.fornecedor_id = c.fornecedor_id
JOIN Funcionario f ON compra.funcionario_id = f.funcionario_id
JOIN Loja l ON compra.loja_id = l.loja_id
JOIN compra_produto vp ON compra.compra_id = vp.compra_id
JOIN Produto p ON vp.produto_id = p.produto_id
JOIN compra_produto cp ON vp.produto_id = cp.produto_id AND vp.compra_id = cp.compra_id
GROUP BY compra.compra_id
ORDER BY compra.compra_id DESC;
";

$result = mysqli_query($link, $query);

if (isset($_POST['export_compra_id'])) {
    $compra_id = $_POST['export_compra_id'];

    $export_query = "
    SELECT
        v.data_compra,
        c.nome AS nome_fornecedor,
        f.nome AS nome_funcionario,
        vp.produto_id,
        p.nome AS nome_produto,
        cp.custo AS custo_produto,
        vp.quantidade 
    FROM Compra v
    JOIN Fornecedor c ON v.fornecedor_id = c.fornecedor_id
    JOIN Funcionario f ON v.funcionario_id = f.funcionario_id
    JOIN compra_produto vp ON v.compra_id = vp.compra_id
    JOIN Produto p ON vp.produto_id = p.produto_id
    JOIN compra_produto cp ON vp.produto_id = cp.produto_id AND vp.compra_id = cp.compra_id
    WHERE v.compra_id = $compra_id;
    ";

    $export_result = mysqli_query($link, $export_query);

    $filename = "relatorio_compra_" . $compra_id . ".txt";

    $file = fopen($filename, "w");

    $first_row = mysqli_fetch_assoc($export_result);
    $line = "Compra ID: " . $compra_id . "\n";
    $line .= "Data da Compra: " . $first_row['data_compra'] . "\n";
    $line .= "Fornecedor: " . $first_row['nome_fornecedor'] . "\n";
    $line .= "Funcionário: " . $first_row['nome_funcionario'] . "\n\n";
    $line .= "Produtos:\n";

    $valor_total_compra = 0; 

    do {
        $line .= "Produto ID: " . $first_row['produto_id'] . "\n";
        $line .= "Nome do Produto: " . $first_row['nome_produto'] . "\n";
        $line .= "Custo do Produto: " . $first_row['custo_produto'] . "\n";
        $line .= "Quantidade: " . $first_row['quantidade'] . "\n\n";
        
        $valor_total_compra += ($first_row['custo_produto'] * $first_row['quantidade']);
        
    } while ($first_row = mysqli_fetch_assoc($export_result));

    $line .= "Valor Total da Compra: " . number_format($valor_total_compra, 2) . "\n";
        
    fwrite($file, $line);
    
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
                                <h3 class="mb-4">Compras</h3>
                            </div>
                        </div>
                        <div class="content">
                            <div class="table-wrapper">
                                <table border="1">
                                <tr>
                                    <th>Fornecedor</th>
                                    <th>Loja</th>
                                    <th>Compra ID</th>
                                    <th>Valor Total</th>
                                    <th>Ações</th> 
                                </tr>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['nome_fornecedor'] . "</td>";
                                        echo "<td>" . $row['nome_loja'] . "</td>";
                                        echo "<td>" . $row['compra_id'] . "</td>";
                                        echo "<td>" . number_format($row['valor_total'], 2) . "</td>";
                                        echo '<td>
                                            <form method="post">
                                                <input type="hidden" name="export_compra_id" value="' . $row['compra_id'] . '">
                                                <button class="export-button" type="submit">Exportar</button>
                                            </form>
                                        </td>';
                                        echo "</tr>";
                                        echo "</tr>";
                                    }                                    
                                    ?>
                                </table>
                            </div><br>
                            <a class="form-control btn btn-primary rounded submit px-3" href="inserir_compras.php">Adicionar compra</a><br>
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
