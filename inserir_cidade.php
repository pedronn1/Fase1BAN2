<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $link = mysqli_connect("localhost", "root", "", "ban2"); // Conectar à base de dados "ban2"

    $nome_cidade = mysqli_real_escape_string($link, $_POST['nome_cidade']);

    // Verificar se a cidade já existe no banco
    $check_query = "SELECT nome FROM cidade WHERE nome = '$nome_cidade'";
    $check_result = mysqli_query($link, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['msg'] = "O nome da cidade já está cadastrado.";
        header("location: inserir_cidade.php"); // Substitua "sua_pagina.php" pela página atual
        exit();
    }

    // Se a cidade não existe, então podemos inseri-la no banco
    $query = "INSERT INTO cidade (nome) VALUES ('$nome_cidade')";
    mysqli_query($link, $query);

    mysqli_close($link);

    // Redirecionar para a página de cadastro de clientes após adicionar a cidade
    if (isset($_POST['redirect'])) {
        header("location: register.php");
    }
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
                                <h3 class="mb-4">Adicionar Cidade</h3>
                            </div>
                        </div>
                        <div class="content">
                            <?php if (isset($_SESSION['msg'])): ?>
                                <p class="error-msg"><?php echo $_SESSION['msg']; ?></p>
                                <?php unset($_SESSION['msg']); ?>
                            <?php endif; ?>
                            <form class="form" method="POST" action="">
                                <label for="nome_cidade">Nome da Cidade:</label><br>
                                <input type="text" name="nome_cidade" required>
                                <br><br>
                                <input type="hidden" name="redirect" value="true">
                                <input type="submit" class="form-control btn btn-primary rounded submit px-3" value="Adicionar Cidade">
                            </form>
                        </div><br>
                        <p class="text-center"> <a href="register.php">Voltar</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
