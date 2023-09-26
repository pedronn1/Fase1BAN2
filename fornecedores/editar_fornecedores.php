<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
    exit();
}

$link = mysqli_connect("localhost", "root", "", "ban2");

$username = mysqli_real_escape_string($link, $_SESSION['username']);

if (!isset($_GET['codigo'])) {
    echo "Código do cliente não fornecido";
    exit();
}

$codigo = $_GET['codigo'];

$query = "SELECT * FROM Fornecedor WHERE fornecedor_id = '$codigo'";
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Fornecedor não encontrado";
    exit();
}

$row = mysqli_fetch_assoc($result);

$cidades_query = "SELECT * FROM Cidade";
$cidades_result = mysqli_query($link, $cidades_query);

$cidades = array();
while ($cidade_row = mysqli_fetch_assoc($cidades_result)) {
    $cidades[$cidade_row['cidade_id']] = $cidade_row['nome'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = mysqli_real_escape_string($link, $_POST['nome']);
    $cidade_id = mysqli_real_escape_string($link, $_POST['cidade_id']);

    $check_query = "SELECT fornecedor_id FROM Fornecedor WHERE nome = '$nome' AND fornecedor_id != '$codigo'";
    $check_result = mysqli_query($link, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['msg'] = "O nome do fornecedor já está em uso.";
        header("location: editar_fornecedores.php?codigo=$codigo");
        exit();
    }

    $updateQuery = "UPDATE Fornecedor SET nome = '$nome', cidade_id = '$cidade_id' WHERE fornecedor_id = '$codigo'";
    mysqli_query($link, $updateQuery);

    header('location: ver_fornecedores.php');
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
                            <?php if (isset($_SESSION['msg'])): ?>
                                <p class="error-msg"><?php echo $_SESSION['msg']; ?></p>
                                <?php unset($_SESSION['msg']); ?>
                            <?php endif; ?>
                            <form class="form" method="POST" action="">
                                <label for="nome">Nome:</label><br>
                                <input type="text" name="nome" value="<?php echo $row['nome']; ?>" required>
                                <br>
                                <label for="cidade_id">Cidade:</label><br>
                                <select name="cidade_id" required>
                                    <?php
                                    foreach ($cidades as $cidade_id => $cidade_nome) {
                                        $selected = ($cidade_id == $row['cidade_id']) ? 'selected' : '';
                                        echo "<option value='$cidade_id' $selected>$cidade_nome</option>";
                                    }
                                    ?>
                                </select>
                                <br>
                                <input type="submit" class="form-control btn btn-primary rounded submit px-3" value="Salvar Alterações">
                            </form>
                        </div><br>
                        <p class="text-center"> <a href="ver_fornecedores.php">Voltar</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
