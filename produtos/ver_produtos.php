<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

$link = mysqli_connect("localhost", "root", "", "ban2");

$query = "SELECT Produto.produto_id, Produto.nome AS produto_nome, Produto.preco, Fornecedor.nome AS fornecedor_nome FROM Produto
          INNER JOIN Fornecedor ON Produto.fornecedor_id = Fornecedor.fornecedor_id
          ORDER BY Produto.nome";

$result = mysqli_query($link, $query);
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
                                <h3 class="mb-4">Produtos</h3>
                            </div>
                        </div>
                        <div class="content">
                            <div class="table-wrapper">
                                <table border="1">
                                    <tr>
                                        <th>Nome do Produto</th>
                                        <th>Preço</th>
                                        <th>Nome do Fornecedor</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>

                                    <?php
									mysqli_data_seek($result, 0);
									while ($row = mysqli_fetch_assoc($result)) {
										echo "<tr>";
										echo "<td>" . $row['produto_nome'] . "</td>";
										echo "<td>" . $row['preco'] . "</td>";
										echo "<td>" . $row['fornecedor_nome'] . "</td>";
										echo "<td><a href=\"delete_produtos.php?produto_id=" . $row['produto_id'] . "\">deletar</a>";
										echo "<td><a href=\"editar_produtos.php?produto_id=" . $row['produto_id'] . "\">editar</a></td>";
										echo "</tr>";
									}
									?>
                                </table>
                            </div><br>
                            <a class="form-control btn btn-primary rounded submit px-3" href="inserir_produtos.php">Adicionar produto</a><br>
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
