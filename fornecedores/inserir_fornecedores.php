<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You have to log in first";
        header('location: login.php');
        exit();
    }

    $link = mysqli_connect("localhost", "root", "", "ban2");

    $nome = mysqli_real_escape_string($link, $_POST['nome']);
    $cidade_id = mysqli_real_escape_string($link, $_POST['cidade_id']);

    $check_query = "SELECT nome FROM Fornecedor WHERE nome = '$nome'";
    $check_result = mysqli_query($link, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['msg'] = "O nome do fornecedor já está cadastrado.";
        header("location: inserir_fornecedores.php");
        exit();
    }

    $query = "INSERT INTO Fornecedor (nome, cidade_id) VALUES ('$nome', '$cidade_id')";
    mysqli_query($link, $query);

    mysqli_close($link);

    header("location: ver_fornecedores.php");
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
                                <h3 class="mb-4">Cadastro de Fornecedor</h3>
                            </div>
                        </div>
                        <div class="content">
                            <?php if (isset($_SESSION['msg'])): ?>
                                <p class="error-msg"><?php echo $_SESSION['msg']; ?></p>
                                <?php unset($_SESSION['msg']); ?>
                            <?php endif; ?>
                            <form class="form" method="POST" action="">
                                <label for="nome">Nome:</label><br>
                                <input type="text" name="nome" required>
                                <br>
                                <label for="cidade_id">Cidade:</label><br>
                                <select name="cidade_id" required>
                                    <?php
                                    $link = mysqli_connect("localhost", "root", "", "ban2");
                                    $query = "SELECT * FROM Cidade ORDER BY nome";
                                    $result = mysqli_query($link, $query);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<option value=\"" . $row['cidade_id'] . "\">" . $row['nome'] . "</option>";
                                    }

                                    mysqli_close($link);
                                    ?>
                                </select>
                                <br><br>
                                <br><input type="submit" class="form-control btn btn-primary rounded submit px-3" value="Salvar Fornecedor">
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
