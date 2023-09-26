<?php
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

$link = mysqli_connect("localhost", "root", "", "ban2");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = mysqli_real_escape_string($link, $_SESSION['username']);

$query = "SELECT Fornecedor.fornecedor_id, Fornecedor.nome AS fornecedor_nome, Cidade.nome AS cidade_nome 
          FROM Fornecedor 
          INNER JOIN Cidade ON Fornecedor.cidade_id = Cidade.cidade_id";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($link, $_GET['search']);
    $query .= " WHERE Fornecedor.nome LIKE '%$search%'";
}

$query .= " ORDER BY Fornecedor.nome";

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
                                <h3 class="mb-4">Fornecedores</h3>
                            </div>
                        </div>
                        <div class="content">
                            <form method="GET" action="ver_fornecedores.php">
                                <input type="text" name="search" placeholder="Pesquisar fornecedor">
                                <input type="submit" value="Pesquisar">
                            </form><br>

                            <div class="table-wrapper">
                                <table border="1">
                                    <tr>
                                        <th>Nome do Fornecedor</th>
                                        <th>Cidade</th>
                                        <th>&nbsp;</th>
                                        <th>&nbsp;</th>
                                    </tr>

                                    <?php
                                    if (isset($_GET['search'])) {
                                        $search = mysqli_real_escape_string($link, $_GET['search']);
                                        $query .= " WHERE Fornecedor.nome LIKE '%$search%'";
                                    }

                                    mysqli_data_seek($result, 0);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td>" . $row['fornecedor_nome'] . "</td>";
                                        echo "<td>" . $row['cidade_nome'] . "</td>";
                                        echo "<td><a href=\"delete_fornecedores.php?codigo=" . $row['fornecedor_id'] . "\">deletar</a>";
                                        echo "<td><a href=\"editar_fornecedores.php?codigo=" . $row['fornecedor_id'] . "\">editar</a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </table>
                            </div><br>
                            <a class="form-control btn btn-primary rounded submit px-3" href="inserir_fornecedores.php">Adicionar fornecedor</a><br>
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
